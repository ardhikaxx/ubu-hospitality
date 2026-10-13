<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Property extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'brand_id',
        'property_type_id',
        'destination_id',
        'name',
        'slug',
        'headline_id',
        'headline_en',
        'description_id',
        'description_en',
        'address',
        'city',
        'latitude',
        'longitude',
        'google_maps_url',
        'max_guests',
        'bedrooms',
        'bathrooms',
        'beds_description',
        'area_sqm',
        'featured_image',
        'video_url',
        'virtual_tour_url',
        'google_maps_embed_url',
        'gallery_images',
        'starting_price_display',
        'currency',
        'has_private_pool',
        'is_featured',
        'is_syariah',
        'sentec_property_id',
        'booking_engine_url',
        'house_rules_id',
        'house_rules_en',
        'checkin_time',
        'checkout_time',
        'cancellation_policy_id',
        'cancellation_policy_en',
        'nearby_attractions',
        'sort_order',
        'status',
        'meta_title_id',
        'meta_title_en',
        'meta_description_id',
        'meta_description_en',
        'meta_keywords',
    ];

    protected function casts(): array
    {
        return [
            'gallery_images' => 'array',
            'nearby_attractions' => 'array',
            'has_private_pool' => 'boolean',
            'is_featured' => 'boolean',
            'is_syariah' => 'boolean',
            'max_guests' => 'integer',
            'bedrooms' => 'integer',
            'bathrooms' => 'integer',
            'area_sqm' => 'integer',
            'sort_order' => 'integer',
            'starting_price_display' => 'decimal:2',
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
        ];
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function propertyType(): BelongsTo
    {
        return $this->belongsTo(PropertyType::class);
    }

    public function destination(): BelongsTo
    {
        return $this->belongsTo(Destination::class);
    }

    public function amenities(): BelongsToMany
    {
        return $this->belongsToMany(Amenity::class, 'property_amenity');
    }

    public function units(): HasMany
    {
        return $this->hasMany(PropertyUnit::class);
    }

    public function promotions(): BelongsToMany
    {
        return $this->belongsToMany(Promotion::class, 'promotion_property');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(GuestReview::class);
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published');
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    public function scopeWithFilters(Builder $query, array $filters): Builder
    {
        if (! empty($filters['brand'])) {
            $brand = $filters['brand'];
            $query->whereHas('brand', function ($q) use ($brand) {
                if (is_numeric($brand)) {
                    $q->where('id', $brand);
                } else {
                    $q->where('slug', $brand);
                }
            });
        }

        if (! empty($filters['property_type'])) {
            $type = $filters['property_type'];
            $query->whereHas('propertyType', function ($q) use ($type) {
                if (is_numeric($type)) {
                    $q->where('id', $type);
                } else {
                    $q->where('slug', $type);
                }
            });
        }

        if (! empty($filters['city'])) {
            $query->where('city', 'like', '%'.$filters['city'].'%');
        }

        if (! empty($filters['guests'])) {
            $query->where('max_guests', '>=', (int) $filters['guests']);
        }

        if (! empty($filters['bedrooms'])) {
            $query->where('bedrooms', '>=', (int) $filters['bedrooms']);
        }

        if (! empty($filters['private_pool'])) {
            $query->where('has_private_pool', true);
        }

        if (! empty($filters['syariah'])) {
            $query->where('is_syariah', true);
        }

        if (! empty($filters['min_price'])) {
            $query->where('starting_price_display', '>=', (float) $filters['min_price']);
        }

        if (! empty($filters['max_price'])) {
            $query->where('starting_price_display', '<=', (float) $filters['max_price']);
        }

        if (! empty($filters['amenities']) && is_array($filters['amenities'])) {
            foreach ($filters['amenities'] as $amenityId) {
                $query->whereHas('amenities', fn ($q) => $q->where('amenities.id', $amenityId));
            }
        }

        if (! empty($filters['keyword'])) {
            $keyword = '%'.$filters['keyword'].'%';
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', $keyword)
                    ->orWhere('headline_id', 'like', $keyword)
                    ->orWhere('headline_en', 'like', $keyword)
                    ->orWhere('city', 'like', $keyword)
                    ->orWhere('address', 'like', $keyword);
            });
        }

        $sort = $filters['sort'] ?? 'recommended';

        return match ($sort) {
            'price_low' => $query->orderBy('starting_price_display', 'asc'),
            'price_high' => $query->orderBy('starting_price_display', 'desc'),
            'guests_high' => $query->orderBy('max_guests', 'desc'),
            default => $query->orderBy('is_featured', 'desc')->orderBy('sort_order', 'asc')->orderBy('id', 'desc'),
        };
    }

    public function getHeadlineAttribute(): ?string
    {
        $locale = app()->getLocale();

        return $locale === 'en' && ! empty($this->headline_en) ? $this->headline_en : $this->headline_id;
    }

    public function getDescriptionAttribute(): ?string
    {
        $locale = app()->getLocale();

        return $locale === 'en' && ! empty($this->description_en) ? $this->description_en : $this->description_id;
    }

    public function getHouseRulesAttribute(): ?string
    {
        $locale = app()->getLocale();

        return $locale === 'en' && ! empty($this->house_rules_en) ? $this->house_rules_en : $this->house_rules_id;
    }

    public function getCancellationPolicyAttribute(): ?string
    {
        $locale = app()->getLocale();

        return $locale === 'en' && ! empty($this->cancellation_policy_en) ? $this->cancellation_policy_en : $this->cancellation_policy_id;
    }

    public function getFormattedPriceAttribute(): string
    {
        return 'Rp '.number_format((float) $this->starting_price_display, 0, ',', '.');
    }

    public function isSentecLinked(): bool
    {
        return ! empty($this->sentec_property_id);
    }
}
