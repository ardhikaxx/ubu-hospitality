<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PartnershipLead extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'reference_no',
        'owner_name',
        'company_name',
        'email',
        'phone',
        'property_name',
        'property_type',
        'property_address',
        'city',
        'land_size_sqm',
        'building_size_sqm',
        'number_of_rooms',
        'partnership_model',
        'current_status',
        'proposal_notes',
        'internal_notes',
        'assigned_to',
        'pipeline_status',
        'status_history',
        'ip_address',
        'user_agent',
    ];

    protected function casts(): array
    {
        return [
            'status_history' => 'array',
            'land_size_sqm' => 'integer',
            'building_size_sqm' => 'integer',
            'number_of_rooms' => 'integer',
        ];
    }

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function scopeByStatus(Builder $query, string $status): Builder
    {
        return $query->where('pipeline_status', $status);
    }

    public static function generateReferenceNo(): string
    {
        $prefix = 'PRT-'.date('Ym').'-';
        $count = static::where('reference_no', 'like', $prefix.'%')->count() + 1;

        return $prefix.str_pad((string) $count, 4, '0', STR_PAD_LEFT);
    }

    public function addStatusHistory(string $newStatus, ?string $userName = null, ?string $note = null): void
    {
        $history = $this->status_history ?? [];
        $history[] = [
            'from_status' => $this->pipeline_status,
            'to_status' => $newStatus,
            'changed_by' => $userName ?? (auth()->user()?->name ?? 'System'),
            'timestamp' => Carbon::now()->toIso8601String(),
            'note' => $note,
        ];

        $this->pipeline_status = $newStatus;
        $this->status_history = $history;
    }

    public function getPipelineBadgeClassAttribute(): string
    {
        return match ($this->pipeline_status) {
            'new' => 'bg-primary',
            'contacted' => 'bg-info text-dark',
            'survey_scheduled' => 'bg-warning text-dark',
            'under_review' => 'bg-secondary',
            'negotiation' => 'bg-info text-white',
            'approved' => 'bg-success',
            'rejected' => 'bg-danger',
            default => 'bg-secondary',
        };
    }
}
