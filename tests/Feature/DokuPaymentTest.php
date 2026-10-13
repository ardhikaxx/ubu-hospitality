<?php

use App\Models\PaymentTransaction;
use App\Services\Payment\PaymentServiceInterface;

beforeEach(function () {
    $this->paymentService = app(PaymentServiceInterface::class);
});

test('create payment creates pending transaction with unique invoice number', function () {
    $transaction = $this->paymentService->createPayment([
        'customer_name' => 'Aditya Pratama',
        'customer_email' => 'aditya@example.com',
        'customer_phone' => '081299887766',
        'amount' => 2500000,
        'currency' => 'IDR',
        'reservation_reference' => 'RES-202610-001',
    ]);

    expect($transaction)->toBeInstanceOf(PaymentTransaction::class);
    expect($transaction->status)->toBe('pending');
    expect($transaction->amount)->toBe('2500000.00');
    expect($transaction->invoice_number)->toStartWith('INV-');

    $this->assertDatabaseHas('payment_transactions', [
        'invoice_number' => $transaction->invoice_number,
        'customer_email' => 'aditya@example.com',
        'status' => 'pending',
    ]);
});

test('mock checkout page displays invoice information and simulated payment actions', function () {
    $transaction = $this->paymentService->createPayment([
        'customer_name' => 'Siti Nurhaliza',
        'customer_email' => 'siti@example.com',
        'customer_phone' => '081233445566',
        'amount' => 1750000,
    ]);

    $response = $this->get(route('payment.mock-checkout', $transaction->invoice_number));

    $response->assertStatus(200);
    $response->assertSee($transaction->invoice_number);
    $response->assertSee('Siti Nurhaliza');
    $response->assertSee('Simulasi Gateway DOKU');
});

test('doku webhook updates transaction status to paid and handles idempotency', function () {
    $transaction = $this->paymentService->createPayment([
        'customer_name' => 'Rian Hidayat',
        'customer_email' => 'rian@example.com',
        'customer_phone' => '081211223344',
        'amount' => 3200000,
    ]);

    $webhookPayload = [
        'order' => [
            'invoice_number' => $transaction->invoice_number,
            'amount' => 3200000,
        ],
        'transaction' => [
            'status' => 'SUCCESS',
            'date' => now()->toIso8601String(),
        ],
    ];

    // First Webhook Call
    $firstResponse = $this->postJson(route('payment.doku.webhook'), $webhookPayload);

    $firstResponse->assertStatus(200);
    $firstResponse->assertJson([
        'success' => true,
        'status' => 'PAID',
    ]);

    $transaction->refresh();
    expect($transaction->status)->toBe('paid');
    expect($transaction->paid_at)->not->toBeNull();

    // Second Webhook Call (Idempotency Guard)
    $secondResponse = $this->postJson(route('payment.doku.webhook'), $webhookPayload);

    $secondResponse->assertStatus(200);
    $secondResponse->assertJson([
        'success' => true,
        'status' => 'ALREADY_PAID',
    ]);
});

test('mock complete route redirects and marks transaction as paid', function () {
    $transaction = $this->paymentService->createPayment([
        'customer_name' => 'Dewi Lestari',
        'customer_email' => 'dewi@example.com',
        'customer_phone' => '081277889900',
        'amount' => 1200000,
    ]);

    $response = $this->post(route('payment.mock-complete', $transaction->invoice_number));

    $response->assertRedirect(route('payment.mock-checkout', $transaction->invoice_number));
    $response->assertSessionHas('success');

    $transaction->refresh();
    expect($transaction->status)->toBe('paid');
});
