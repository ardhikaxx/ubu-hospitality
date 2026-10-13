<?php

namespace App\Http\Controllers;

use App\Models\PaymentTransaction;
use App\Services\Payment\PaymentServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaymentController extends Controller
{
    /**
     * Webhook endpoint for DOKU notifications.
     */
    public function dokuWebhook(Request $request, PaymentServiceInterface $paymentService): JsonResponse
    {
        $payload = $request->all();
        $headers = $request->headers->all();

        $result = $paymentService->handleNotification($payload, $headers);

        $httpStatus = $result['success'] ? 200 : 400;

        return response()->json($result, $httpStatus);
    }

    /**
     * Development mock checkout page for testing DOKU payment flow.
     */
    public function mockCheckout(string $invoiceNumber): View
    {
        $transaction = PaymentTransaction::where('invoice_number', $invoiceNumber)->firstOrFail();

        return view('payment.mock-checkout', compact('transaction'));
    }

    /**
     * Simulate successful payment in mock mode.
     */
    public function mockComplete(string $invoiceNumber, PaymentServiceInterface $paymentService)
    {
        $transaction = PaymentTransaction::where('invoice_number', $invoiceNumber)->firstOrFail();

        $payload = [
            'order' => [
                'invoice_number' => $invoiceNumber,
                'amount' => $transaction->amount,
            ],
            'transaction' => [
                'status' => 'SUCCESS',
                'date' => now()->toIso8601String(),
            ],
        ];

        $paymentService->handleNotification($payload);

        return redirect()->route('payment.mock-checkout', $invoiceNumber)
            ->with('success', 'Simulasi pembayaran berhasil! Transaksi kini berstatus LUNAS.');
    }
}
