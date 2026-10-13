<?php

namespace App\Services\Payment;

use App\Models\PaymentTransaction;

interface PaymentServiceInterface
{
    /**
     * Create payment request with gateway and record transaction.
     *
     * @param  array<string, mixed>  $data
     */
    public function createPayment(array $data): PaymentTransaction;

    /**
     * Handle incoming payment notification webhook idempotently.
     *
     * @param  array<string, mixed>  $payload
     * @param  array<string, string>  $headers
     * @return array{success: bool, status: string, message: string}
     */
    public function handleNotification(array $payload, array $headers = []): array;

    /**
     * Verify webhook signature authenticity.
     *
     * @param  array<string, mixed>  $payload
     * @param  array<string, string>  $headers
     */
    public function verifySignature(array $payload, array $headers = []): bool;
}
