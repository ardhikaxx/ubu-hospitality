<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'reservation_reference',
        'customer_name',
        'customer_email',
        'customer_phone',
        'amount',
        'currency',
        'payment_channel',
        'status',
        'doku_invoice_number',
        'doku_payment_url',
        'raw_request',
        'raw_response',
        'callback_payload',
        'paid_at',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'raw_request' => 'array',
            'raw_response' => 'array',
            'callback_payload' => 'array',
            'paid_at' => 'datetime',
        ];
    }

    public function scopePaid(Builder $query): Builder
    {
        return $query->where('status', 'paid');
    }

    public function getFormattedAmountAttribute(): string
    {
        return 'Rp '.number_format((float) $this->amount, 0, ',', '.');
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            'paid' => 'bg-success',
            'pending' => 'bg-warning text-dark',
            'failed' => 'bg-danger',
            'expired' => 'bg-secondary',
            'cancelled' => 'bg-dark',
            default => 'bg-secondary',
        };
    }
}
