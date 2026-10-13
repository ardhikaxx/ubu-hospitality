<?php

namespace App\Services\Payment;

use App\Models\AuditLog;
use App\Models\PaymentTransaction;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DokuPaymentService implements PaymentServiceInterface
{
    protected string $clientId;

    protected string $secretKey;

    protected string $environment;

    protected bool $mockMode;

    protected string $baseUrl;

    public function __construct()
    {
        $this->clientId = (string) config('services.doku.client_id', env('DOKU_CLIENT_ID', ''));
        $this->secretKey = (string) config('services.doku.secret_key', env('DOKU_SECRET_KEY', ''));
        $this->environment = (string) config('services.doku.environment', env('DOKU_ENVIRONMENT', 'sandbox'));
        $this->mockMode = (bool) config('services.doku.mock_mode', env('DOKU_MOCK_MODE', true));
        $this->baseUrl = $this->environment === 'production'
            ? 'https://api.doku.com'
            : 'https://api-sandbox.doku.com';
    }

    /**
     * {@inheritDoc}
     */
    public function createPayment(array $data): PaymentTransaction
    {
        $invoiceNumber = 'INV-'.date('YmdHis').'-'.strtoupper(substr(uniqid(), -4));

        return DB::transaction(function () use ($data, $invoiceNumber) {
            $transaction = PaymentTransaction::create([
                'invoice_number' => $invoiceNumber,
                'reservation_reference' => $data['reservation_reference'] ?? null,
                'customer_name' => $data['customer_name'],
                'customer_email' => $data['customer_email'],
                'customer_phone' => $data['customer_phone'],
                'amount' => $data['amount'],
                'currency' => $data['currency'] ?? 'IDR',
                'payment_channel' => $data['payment_channel'] ?? 'DOKU_CHECKOUT',
                'status' => 'pending',
                'raw_request' => [
                    'invoice_number' => $invoiceNumber,
                    'amount' => $data['amount'],
                    'created_at' => Carbon::now()->toIso8601String(),
                ],
            ]);

            if ($this->mockMode || empty($this->clientId)) {
                // In mock mode, generate simulated checkout URL
                $mockPaymentUrl = url("/payment/mock-checkout/{$invoiceNumber}");
                $transaction->update([
                    'doku_invoice_number' => 'DOKU-'.$invoiceNumber,
                    'doku_payment_url' => $mockPaymentUrl,
                    'raw_response' => [
                        'status' => 'SUCCESS',
                        'payment_url' => $mockPaymentUrl,
                        'is_mock' => true,
                    ],
                ]);
            } else {
                try {
                    $response = Http::timeout(8)
                        ->withHeaders([
                            'Client-Id' => $this->clientId,
                            'Request-Id' => $invoiceNumber,
                            'Request-Timestamp' => Carbon::now()->toIso8601String(),
                        ])
                        ->post("{$this->baseUrl}/checkout/v1/payment", [
                            'order' => [
                                'invoice_number' => $invoiceNumber,
                                'amount' => (int) $data['amount'],
                            ],
                            'customer' => [
                                'name' => $data['customer_name'],
                                'email' => $data['customer_email'],
                                'phone' => $data['customer_phone'],
                            ],
                        ]);

                    $resData = $response->json();
                    $transaction->update([
                        'doku_invoice_number' => $resData['response']['payment']['invoice_number'] ?? null,
                        'doku_payment_url' => $resData['response']['payment']['url'] ?? null,
                        'raw_response' => $resData,
                    ]);
                } catch (Exception $e) {
                    Log::error('DOKU payment generation failed', ['error' => $e->getMessage()]);
                }
            }

            return $transaction;
        });
    }

    /**
     * {@inheritDoc}
     */
    public function verifySignature(array $payload, array $headers = []): bool
    {
        if ($this->mockMode) {
            return true;
        }

        $signatureHeader = $headers['signature'] ?? $headers['Signature'] ?? null;
        if (! $signatureHeader || empty($this->secretKey)) {
            return false;
        }

        // Standard DOKU HMAC-SHA256 signature calculation
        $digest = base64_encode(hash('sha256', json_encode($payload), true));
        $componentSignature = 'HMACSHA256='.base64_encode(hash_hmac('sha256', $digest, $this->secretKey, true));

        return hash_equals($componentSignature, $signatureHeader);
    }

    /**
     * {@inheritDoc}
     */
    public function handleNotification(array $payload, array $headers = []): array
    {
        if (! $this->verifySignature($payload, $headers)) {
            Log::warning('DOKU webhook signature verification failed', ['payload' => $payload]);

            return [
                'success' => false,
                'status' => 'INVALID_SIGNATURE',
                'message' => 'Tanda tangan webhook tidak valid.',
            ];
        }

        $invoiceNumber = $payload['order']['invoice_number'] ?? ($payload['invoice_number'] ?? null);
        if (! $invoiceNumber) {
            return [
                'success' => false,
                'status' => 'MISSING_INVOICE',
                'message' => 'Nomor invoice tidak ditemukan dalam payload.',
            ];
        }

        return DB::transaction(function () use ($invoiceNumber, $payload) {
            $transaction = PaymentTransaction::where('invoice_number', $invoiceNumber)
                ->lockForUpdate()
                ->first();

            if (! $transaction) {
                return [
                    'success' => false,
                    'status' => 'NOT_FOUND',
                    'message' => "Transaksi {$invoiceNumber} tidak ditemukan.",
                ];
            }

            // IDEMPOTENCY: If transaction is already marked paid, return success without re-processing
            if ($transaction->status === 'paid') {
                return [
                    'success' => true,
                    'status' => 'ALREADY_PAID',
                    'message' => 'Transaksi sudah berstatus lunas sebelumnya (idempoten).',
                ];
            }

            $paymentStatus = strtoupper($payload['transaction']['status'] ?? ($payload['status'] ?? ''));

            if (in_array($paymentStatus, ['SUCCESS', 'PAID', 'COMPLETED'], true)) {
                $transaction->update([
                    'status' => 'paid',
                    'paid_at' => Carbon::now(),
                    'callback_payload' => $payload,
                ]);

                AuditLog::create([
                    'action' => 'payment.received',
                    'auditable_type' => PaymentTransaction::class,
                    'auditable_id' => $transaction->id,
                    'description' => "Pembayaran diterima via webhook: Invoice {$invoiceNumber} sejumlah Rp ".number_format((float) $transaction->amount, 0, ',', '.'),
                    'new_values' => ['status' => 'paid', 'amount' => $transaction->amount],
                ]);

                return [
                    'success' => true,
                    'status' => 'PAID',
                    'message' => 'Pembayaran berhasil diverifikasi dan dicatat.',
                ];
            }

            $transaction->update([
                'status' => 'failed',
                'callback_payload' => $payload,
            ]);

            return [
                'success' => true,
                'status' => 'FAILED',
                'message' => 'Status pembayaran gagal dicatat.',
            ];
        });
    }
}
