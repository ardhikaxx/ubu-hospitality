<?php

namespace App\Console\Commands;

use App\Models\Amenity;
use App\Models\Brand;
use App\Models\Destination;
use App\Models\Property;
use App\Models\PropertyType;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

#[Signature('app:sync-ubu-villa-live-properties {--download-images : Download photos to local public storage}')]
#[Description('Fetch real property data and images directly from https://ubuvilla.com/')]
class SyncUbuVillaLiveProperties extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Mengambil data halaman utama dari https://ubuvilla.com/...');

        $response = Http::withoutVerifying()->withHeaders([
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
        ])->timeout(30)->get('https://ubuvilla.com/');

        if (! $response->successful()) {
            $this->error('Gagal mengambil data dari https://ubuvilla.com/. Status: '.$response->status());

            return Command::FAILURE;
        }

        $html = $response->body();
        $villas = $this->parseHomepageVillas($html);

        $this->info('Ditemukan '.count($villas).' properti asli Ubu Villa.');

        $ubuBrand = Brand::where('slug', 'ubu-villa')->first();
        $burujBrand = Brand::where('slug', 'buruj-villa')->first();
        $glampingBrand = Brand::where('slug', 'ubu-glamping')->first();

        $destSleman = Destination::where('slug', 'sleman')->first();
        $destKaliurang = Destination::where('slug', 'kaliurang')->first();
        $destBantul = Destination::where('slug', 'bantul')->first();
        $destKota = Destination::where('slug', 'yogyakarta-kota')->first();

        $typePrivatePool = PropertyType::where('slug', 'private-pool-villa')->first();
        $typeFamily = PropertyType::where('slug', 'family-residence-villa')->first();
        $typeGlamping = PropertyType::where('slug', 'luxury-glamping')->first();

        $defaultAmenities = Amenity::whereIn('id', [1, 3, 4, 5, 8, 9, 10, 11])->pluck('id')->toArray();
        $syariahAmenities = Amenity::whereIn('id', [1, 3, 4, 5, 7, 8, 9, 10, 11])->pluck('id')->toArray();

        $shouldDownloadImages = $this->option('download-images');
        $progressBar = $this->output->createProgressBar(count($villas));
        $progressBar->start();

        foreach ($villas as $index => $v) {
            $detail = $this->fetchPropertyDetail($v['code'], $v['detail_url']);

            $name = $v['name'];
            $slug = Str::slug($name);

            // Tentukan Brand
            $isSyariah = Str::contains(strtolower($name.' '.$detail['description']), ['syariah', 'muslim', 'buruj']);
            if ($isSyariah) {
                $brand = $burujBrand ?: $ubuBrand;
            } elseif (Str::contains(strtolower($name), 'glamping')) {
                $brand = $glampingBrand ?: $ubuBrand;
            } else {
                $brand = $ubuBrand;
            }

            // Tentukan Destinasi & Alamat
            $fullAddress = $v['address'];
            if (! empty($detail['address']) && ! str_starts_with($detail['address'], 'Rp')) {
                $fullAddress = $detail['address'];
            }
            $addressLower = strtolower($fullAddress);
            if (Str::contains($addressLower, ['bantul', 'banguntapan', 'sewon', 'kasihan', 'mantup'])) {
                $destination = $destBantul;
                $city = 'Bantul';
            } elseif (Str::contains($addressLower, ['kaliurang', 'pakem', 'hargobinangun'])) {
                $destination = $destKaliurang;
                $city = 'Kaliurang';
            } elseif (Str::contains($addressLower, ['umbulharjo', 'malioboro', 'kraton', 'kota yogyakarta'])) {
                $destination = $destKota;
                $city = 'Kota Yogyakarta';
            } else {
                $destination = $destSleman;
                $city = 'Sleman';
            }

            // Tentukan Property Type
            if (Str::contains(strtolower($name), 'glamping')) {
                $propertyType = $typeGlamping;
            } elseif ($v['bedrooms'] >= 4 || $v['max_guests'] >= 10) {
                $propertyType = $typeFamily;
            } else {
                $propertyType = $typePrivatePool;
            }

            // Harga Asli dari Website
            $basePrice = ! empty($detail['price']) ? $detail['price'] : match (true) {
                $v['bedrooms'] <= 1 => 950000,
                $v['bedrooms'] == 2 => 1550000,
                $v['bedrooms'] == 3 => 2150000,
                $v['bedrooms'] == 4 => 2850000,
                default => 3450000,
            };

            // Kelola Gambar (Download atau gunakan direct CDN URL)
            $featuredImage = $v['thumb_image'];
            $galleryImages = ! empty($detail['gallery']) ? $detail['gallery'] : [$v['thumb_image']];

            if ($shouldDownloadImages) {
                $localDir = public_path('images/villas/'.$slug);
                if (! File::exists($localDir)) {
                    File::makeDirectory($localDir, 0755, true);
                }

                // Download featured image
                $featuredExt = pathinfo(parse_url($featuredImage, PHP_URL_PATH), PATHINFO_EXTENSION) ?: 'jpg';
                $localFeaturedPath = $localDir.'/featured.'.$featuredExt;
                $publicFeaturedUrl = '/images/villas/'.$slug.'/featured.'.$featuredExt;

                if (! File::exists($localFeaturedPath)) {
                    $this->downloadFile($featuredImage, $localFeaturedPath);
                }
                if (File::exists($localFeaturedPath)) {
                    $featuredImage = $publicFeaturedUrl;
                }

                // Download top 6 gallery images
                $localGallery = [];
                foreach (array_slice($galleryImages, 0, 6) as $gIndex => $gUrl) {
                    $gExt = pathinfo(parse_url($gUrl, PHP_URL_PATH), PATHINFO_EXTENSION) ?: 'jpg';
                    $localGPath = $localDir.'/gallery_'.$gIndex.'.'.$gExt;
                    $publicGUrl = '/images/villas/'.$slug.'/gallery_'.$gIndex.'.'.$gExt;

                    if (! File::exists($localGPath)) {
                        $this->downloadFile($gUrl, $localGPath);
                    }
                    if (File::exists($localGPath)) {
                        $localGallery[] = $publicGUrl;
                    } else {
                        $localGallery[] = $gUrl;
                    }
                }
                $galleryImages = ! empty($localGallery) ? $localGallery : $galleryImages;
            }

            // Headline
            $headlineId = ! empty($detail['tagline']) ? $detail['tagline'] : "Thematic Private Pool Villa di {$city}";
            $headlineEn = "Exclusive Thematic Private Pool Villa in {$city}";

            // Description
            $descriptionId = ! empty($detail['description']) ? $detail['description'] : "Rasakan pengalaman liburan privat dan nyaman di {$name}. Dilengkapi kolam renang pribadi, fasilitas lengkap, dan suasana tenang untuk keluarga maupun rombongan.";
            $descriptionEn = "Experience a serene private getaway at {$name}. Featuring private swimming pool, complete premium amenities, and spacious living spaces.";

            $property = Property::updateOrCreate(
                ['slug' => $slug],
                [
                    'brand_id' => $brand?->id ?: 1,
                    'property_type_id' => $propertyType?->id ?: 1,
                    'destination_id' => $destination?->id ?: 1,
                    'name' => $name,
                    'headline_id' => $headlineId,
                    'headline_en' => $headlineEn,
                    'description_id' => $descriptionId,
                    'description_en' => $descriptionEn,
                    'address' => $fullAddress,
                    'city' => $city,
                    'max_guests' => max(2, $v['max_guests']),
                    'bedrooms' => max(1, $v['bedrooms']),
                    'bathrooms' => max(1, $v['bathrooms']),
                    'beds_description' => "{$v['bedrooms']} King/Queen Beds",
                    'area_sqm' => max(100, $v['bedrooms'] * 80),
                    'featured_image' => $featuredImage,
                    'gallery_images' => $galleryImages,
                    'starting_price_display' => $basePrice,
                    'currency' => 'IDR',
                    'has_private_pool' => true,
                    'is_featured' => in_array($index, [0, 1, 2, 3, 5, 8, 13]), // Tandai beberapa sebagai featured
                    'is_syariah' => $isSyariah,
                    'sentec_property_id' => $v['code'],
                    'booking_engine_url' => $v['booking_url'],
                    'checkin_time' => '14:00',
                    'checkout_time' => '12:00',
                    'sort_order' => $index + 1,
                    'status' => 'published',
                    'meta_title_id' => "{$name} - Sewa Villa Private Pool di {$city}",
                    'meta_title_en' => "{$name} - Luxury Private Pool Villa in {$city}",
                    'meta_description_id' => Str::limit(strip_tags($descriptionId), 155),
                    'meta_description_en' => Str::limit(strip_tags($descriptionEn), 155),
                ]
            );

            // Sync amenities
            $property->amenities()->sync($isSyariah ? $syariahAmenities : $defaultAmenities);

            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine();
        $this->info('Berhasil menyinkronkan seluruh properti asli Ubu Villa ke dalam database!');

        return Command::SUCCESS;
    }

    /**
     * Parse daftar villa dari halaman utama ubuvilla.com
     */
    protected function parseHomepageVillas(string $html): array
    {
        $villas = [];

        // Cocokkan setiap blok villa grid
        preg_match_all('/<div class="portfolio grid-fading animated[^"]*">([\s\S]*?)<\/div>\s*<\/div>\s*<\/div>/', $html, $blocks);

        if (empty($blocks[0])) {
            // Fallback dengan regex judul
            preg_match_all('/<h4><a href="[^"]*property\/([^"]*)">([^<]+)<\/a><\/h4>/', $html, $titleMatches, PREG_SET_ORDER);
            foreach ($titleMatches as $tm) {
                $code = trim($tm[1]);
                $name = html_entity_decode(trim($tm[2]), ENT_QUOTES, 'UTF-8');
                $villas[] = [
                    'code' => $code,
                    'name' => $name,
                    'detail_url' => 'https://ubuvilla.com/property/'.$code,
                    'thumb_image' => 'https://ubuvilla.com/assets/images/favicon.png',
                    'address' => 'Yogyakarta, Indonesia',
                    'bedrooms' => 2,
                    'bathrooms' => 2,
                    'max_guests' => 4,
                    'booking_url' => 'https://api.whatsapp.com/send?phone=+6282320003297',
                ];
            }

            return $villas;
        }

        foreach ($blocks[0] as $block) {
            // Kode & Nama
            if (! preg_match('/<h4><a href="[^"]*property\/([^"]*)">([^<]+)<\/a><\/h4>/', $block, $titleMatch)) {
                continue;
            }
            $code = trim($titleMatch[1]);
            $name = html_entity_decode(trim($titleMatch[2]), ENT_QUOTES, 'UTF-8');

            // Gambar Thumbnail
            $thumb = 'https://ubuvilla.com/assets/images/logo.jpg';
            if (preg_match('/<img[^>]*src="([^"]*uploaded\/title_villa\/[^"]*)"/', $block, $imgMatch)) {
                $rawImg = trim($imgMatch[1]);
                $thumb = str_starts_with($rawImg, 'http') ? $rawImg : 'https://ubuvilla.com/'.$rawImg;
            }

            // Lokasi
            $address = 'Yogyakarta, Indonesia';
            if (preg_match('/<ul class="property-location">[\s\S]*?<span>([\s\S]*?)<\/span>/', $block, $locMatch)) {
                $address = trim(strip_tags($locMatch[1]));
                $address = preg_replace('/\s+/', ' ', $address);
            }

            // Bedrooms
            $bedrooms = 2;
            if (preg_match('/icon-bed2[\s\S]*?Bedrooms\s*&nbsp;\s*(\d+)/i', $block, $bedMatch)) {
                $bedrooms = (int) $bedMatch[1];
            }

            // Bathrooms
            $bathrooms = 2;
            if (preg_match('/icon-man-woman[\s\S]*?Bathrooms\s*&nbsp;\s*(\d+)/i', $block, $bathMatch)) {
                $bathrooms = (int) $bathMatch[1];
            }

            // Capacity
            $maxGuests = 4;
            if (preg_match('/icon-users[\s\S]*?Capacity\s*&nbsp;\s*(\d+)/i', $block, $capMatch)) {
                $maxGuests = (int) $capMatch[1];
            }

            // Booking URL
            $bookingUrl = 'https://api.whatsapp.com/send?phone=+6282320003297';
            if (preg_match('/href="([^"]*(?:bookingku|sentec|booking)[^"]*)"/', $block, $bookMatch)) {
                $bookingUrl = html_entity_decode(trim($bookMatch[1]), ENT_QUOTES, 'UTF-8');
            }

            $villas[] = [
                'code' => $code,
                'name' => $name,
                'detail_url' => 'https://ubuvilla.com/property/'.$code,
                'thumb_image' => $thumb,
                'address' => $address,
                'bedrooms' => $bedrooms,
                'bathrooms' => $bathrooms,
                'max_guests' => $maxGuests,
                'booking_url' => $bookingUrl,
            ];
        }

        return $villas;
    }

    /**
     * Ambil data lengkap per villa dari halaman detail
     */
    protected function fetchPropertyDetail(string $code, string $url): array
    {
        try {
            $resp = Http::withoutVerifying()->withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
            ])->timeout(15)->get($url);

            if (! $resp->successful()) {
                return ['description' => '', 'tagline' => '', 'address' => '', 'gallery' => []];
            }

            $html = $resp->body();

            // Deskripsi
            $description = '';
            if (preg_match('/VILLA DESCRIPTION[\s\S]*?<p>([\s\S]*?)<\/p>/', $html, $descMatch)) {
                $description = trim(strip_tags($descMatch[1]));
            } elseif (preg_match('/class="property-element property-desc"[\s\S]*?<p>([\s\S]*?)<\/p>/', $html, $descMatch)) {
                $description = trim(strip_tags($descMatch[1]));
            }

            // Alamat Lengkap
            $address = '';
            if (preg_match('/PALACE LOCATION[\s\S]*?<div class="text-holder">[\s\S]*?<span>([\s\S]*?)<\/span>/', $html, $addrMatch)) {
                $address = trim(strip_tags($addrMatch[1]));
                $address = preg_replace('/\s+/', ' ', $address);
            }

            // Galeri Foto
            $gallery = [];
            preg_match_all('/src="([^"]*uploaded\/villa\/[^"]*)"/', $html, $galMatches);
            if (! empty($galMatches[1])) {
                foreach (array_unique($galMatches[1]) as $rawG) {
                    $gUrl = str_starts_with($rawG, 'http') ? $rawG : 'https://ubuvilla.com/'.$rawG;
                    $gallery[] = $gUrl;
                }
            }

            // Tagline / Subtitle dari deskripsi (misal: “Lemme relax, lemme escape”)
            $tagline = '';
            if (preg_match('/[“"–-]\s*([“"][^”"]+[”"])/u', $description, $taglineMatch)) {
                $tagline = trim($taglineMatch[1], '“"”');
            }

            // Harga Asli
            $price = null;
            if (preg_match('/<span[^>]*style="[^"]*color:#e67e22[^"]*"[^>]*>[\s\S]*?Rp\.?([\d\.]+)/i', $html, $priceMatch)) {
                $price = (float) str_replace('.', '', $priceMatch[1]);
            }

            return [
                'description' => $description,
                'tagline' => $tagline,
                'address' => $address,
                'gallery' => $gallery,
                'price' => $price,
            ];
        } catch (\Throwable $e) {
            return ['description' => '', 'tagline' => '', 'address' => '', 'gallery' => [], 'price' => null];
        }
    }

    /**
     * Download file aman dengan timeout
     */
    protected function downloadFile(string $url, string $destinationPath): bool
    {
        try {
            $resp = Http::withoutVerifying()->withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
            ])->timeout(20)->get($url);

            if ($resp->successful() && strlen($resp->body()) > 1000) {
                File::put($destinationPath, $resp->body());

                return true;
            }
        } catch (\Throwable $e) {
            // Biarkan fallback ke remote URL
        }

        return false;
    }
}
