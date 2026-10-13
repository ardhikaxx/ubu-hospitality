<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Promotion extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'slug',
        'title_id',
        'title_en',
        'subtitle_id',
        'subtitle_en',
        'description_id',
        'description_en',
        'discount_type',
        'discount_value',
        'banner_image',
        'booking_period_start',
        'booking_period_end',
        'stay_period_start',
        'stay_period_end',
        'terms_conditions_id',
        'terms_conditions_en',
        'is_new_user_only',
        'is_popup',
        'popup_cta_text',
        'popup_cta_link',
        'priority',
        'status',
        'sentec_promo_sync_status',
    ];

    protected function casts(): array
    {
        return [
            'booking_period_start' => 'date',
            'booking_period_end' => 'date',
            'stay_period_start' => 'date',
            'stay_period_end' => 'date',
            'is_new_user_only' => 'boolean',
            'is_popup' => 'boolean',
            'discount_value' => 'decimal:2',
            'priority' => 'integer',
        ];
    }

    public function brands(): BelongsToMany
    {
        return $this->belongsToMany(Brand::class, 'promotion_brand');
    }

    public function properties(): BelongsToMany
    {
        return $this->belongsToMany(Property::class, 'promotion_property');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published');
    }

    public function scopeActiveBooking(Builder $query, ?Carbon $date = null): Builder
    {
        $today = ($date ?? Carbon::today())->toDateString();

        return $query->where('status', 'published')
            ->where('booking_period_start', '<=', $today)
            ->where('booking_period_end', '>=', $today);
    }

    public function getTitleAttribute(): string
    {
        $locale = app()->getLocale();

        return $locale === 'en' && ! empty($this->title_en) ? $this->title_en : $this->title_id;
    }

    public function getSubtitleAttribute(): ?string
    {
        $locale = app()->getLocale();

        return $locale === 'en' && ! empty($this->subtitle_en) ? $this->subtitle_en : $this->subtitle_id;
    }

    public function getDescriptionAttribute(): ?string
    {
        $locale = app()->getLocale();

        return $locale === 'en' && ! empty($this->description_en) ? $this->description_en : $this->description_id;
    }

    public function getTermsConditionsAttribute(): ?string
    {
        $locale = app()->getLocale();

        return $locale === 'en' && ! empty($this->terms_conditions_en) ? $this->terms_conditions_en : $this->terms_conditions_id;
    }

    public function getDiscountLabelAttribute(): string
    {
        if ($this->discount_type === 'percentage') {
            return (int) $this->discount_value.'% OFF';
        }

        return 'Potongan Rp '.number_format((float) $this->discount_value, 0, ',', '.');
    }
}
