<?php

namespace App\Services\Seo;

use App\Models\BlogPost;
use App\Models\Brand;
use App\Models\Page;
use App\Models\Promotion;
use App\Models\Property;
use App\Models\Setting;

class SeoService
{
    /**
     * Build SEO metadata for a page or entity.
     *
     * @param  array<string, mixed>  $override
     * @return array<string, string>
     */
    public function buildMetadata(array $override = []): array
    {
        $locale = app()->getLocale();
        $defaultTitle = Setting::get(
            $locale === 'en' ? 'default_meta_title_en' : 'default_meta_title_id',
            'Ubu Hospitality - Private Luxury Villa & Glamping Management'
        );
        $defaultDesc = Setting::get(
            $locale === 'en' ? 'default_meta_description_en' : 'default_meta_description_id',
            'Official website of Ubu Hospitality. Premier private pool villas and glamping in Yogyakarta.'
        );

        $title = $override['title'] ?? $defaultTitle;
        if (! str_contains($title, 'Ubu Hospitality') && $title !== $defaultTitle) {
            $title .= ' | Ubu Hospitality';
        }

        return [
            'title' => $title,
            'description' => $override['description'] ?? $defaultDesc,
            'keywords' => $override['keywords'] ?? 'ubu hospitality, ubu villa, buruj villa, private pool villa jogja, villa syariah jogja, glamping jogja',
            'canonical' => $override['canonical'] ?? url()->current(),
            'og_type' => $override['og_type'] ?? 'website',
            'og_image' => $override['image'] ?? asset('images/og-default.jpg'),
            'og_locale' => $locale === 'en' ? 'en_US' : 'id_ID',
        ];
    }

    /**
     * Generate Schema.org JSON-LD for Organization.
     *
     * @return array<string, mixed>
     */
    public function getOrganizationSchema(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'LodgingBusiness',
            'name' => Setting::get('company_name', 'PT Ubu Hospitality Indonesia'),
            'alternateName' => 'Ubu Hospitality',
            'url' => url('/'),
            'logo' => asset('images/ubu-logo.png'),
            'telephone' => Setting::get('contact_phone', '(0274) 889977'),
            'email' => Setting::get('contact_email', 'reservation@ubuhospitality.com'),
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => Setting::get('contact_address', 'Jl. Gito Gati No. 88, Sleman'),
                'addressLocality' => 'Sleman',
                'addressRegion' => 'D.I. Yogyakarta',
                'postalCode' => '55581',
                'addressCountry' => 'ID',
            ],
        ];
    }

    /**
     * Generate Schema.org JSON-LD for Property (Hotel / Lodging).
     *
     * @return array<string, mixed>
     */
    public function getPropertySchema(Property $property): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'LodgingBusiness',
            'name' => $property->name,
            'description' => $property->description,
            'url' => route('stay.show', $property->slug),
            'image' => $property->featured_image,
            'priceRange' => $property->formatted_price,
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => $property->address,
                'addressLocality' => $property->city,
                'addressCountry' => 'ID',
            ],
            'geo' => $property->latitude && $property->longitude ? [
                '@type' => 'GeoCoordinates',
                'latitude' => (float) $property->latitude,
                'longitude' => (float) $property->longitude,
            ] : null,
            'amenityFeature' => $property->amenities->map(fn ($a) => [
                '@type' => 'LocationFeatureSpecification',
                'name' => $a->name,
                'value' => true,
            ])->values()->all(),
        ];
    }

    /**
     * Generate dynamic XML sitemap string.
     */
    public function generateSitemapXml(): string
    {
        $urls = [];

        // Static Pages
        $staticRoutes = [
            ['url' => url('/'), 'priority' => '1.0', 'freq' => 'daily'],
            ['url' => route('about'), 'priority' => '0.8', 'freq' => 'weekly'],
            ['url' => route('stay.index'), 'priority' => '0.9', 'freq' => 'daily'],
            ['url' => route('experience.index'), 'priority' => '0.8', 'freq' => 'weekly'],
            ['url' => route('offer.index'), 'priority' => '0.9', 'freq' => 'daily'],
            ['url' => route('partnership.index'), 'priority' => '0.8', 'freq' => 'monthly'],
            ['url' => route('blog.index'), 'priority' => '0.8', 'freq' => 'daily'],
            ['url' => route('contact'), 'priority' => '0.7', 'freq' => 'monthly'],
            ['url' => route('faq'), 'priority' => '0.6', 'freq' => 'monthly'],
        ];

        foreach ($staticRoutes as $r) {
            $urls[] = $r;
        }

        // Brands
        Brand::active()->get()->each(function (Brand $brand) use (&$urls) {
            $urls[] = [
                'url' => route('brand.show', $brand->slug),
                'priority' => '0.9',
                'freq' => 'weekly',
                'lastmod' => $brand->updated_at->toAtomString(),
            ];
        });

        // Properties
        Property::published()->get()->each(function (Property $prop) use (&$urls) {
            $urls[] = [
                'url' => route('stay.show', $prop->slug),
                'priority' => '0.9',
                'freq' => 'daily',
                'lastmod' => $prop->updated_at->toAtomString(),
            ];
        });

        // Blog Posts
        BlogPost::published()->get()->each(function (BlogPost $post) use (&$urls) {
            $urls[] = [
                'url' => route('blog.show', $post->slug),
                'priority' => '0.7',
                'freq' => 'weekly',
                'lastmod' => $post->updated_at->toAtomString(),
            ];
        });

        // Promotions
        Promotion::published()->get()->each(function (Promotion $promo) use (&$urls) {
            $urls[] = [
                'url' => route('offer.show', $promo->slug),
                'priority' => '0.8',
                'freq' => 'weekly',
                'lastmod' => $promo->updated_at->toAtomString(),
            ];
        });

        $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";

        foreach ($urls as $item) {
            $xml .= "  <url>\n";
            $xml .= '    <loc>'.htmlspecialchars($item['url'])."</loc>\n";
            if (! empty($item['lastmod'])) {
                $xml .= "    <lastmod>{$item['lastmod']}</lastmod>\n";
            }
            $xml .= "    <changefreq>{$item['freq']}</changefreq>\n";
            $xml .= "    <priority>{$item['priority']}</priority>\n";
            $xml .= "  </url>\n";
        }

        $xml .= '</urlset>';

        return $xml;
    }
}
