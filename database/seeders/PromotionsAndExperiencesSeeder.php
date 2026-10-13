<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Experience;
use App\Models\Promotion;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PromotionsAndExperiencesSeeder extends Seeder
{
    public function run(): void
    {
        $brandUbu = Brand::where('slug', 'ubu-villa')->first();
        $brandBuruj = Brand::where('slug', 'buruj-villa')->first();

        // 1. Promotions
        $promoWelcome = Promotion::firstOrCreate(
            ['code' => 'UBUWELCOME'],
            [
                'slug' => 'diskon-pengguna-baru-15-persen',
                'title_id' => 'Diskon Pengguna Baru 15%',
                'title_en' => 'New Guest Welcome 15% OFF',
                'subtitle_id' => 'Nikmati liburan pertama Anda di Ubu Hospitality dengan harga istimewa',
                'subtitle_en' => 'Enjoy your very first staycation at Ubu Hospitality with special savings',
                'description_id' => 'Khusus bagi tamu yang pertama kali melakukan reservasi langsung di website resmi Ubu Hospitality. Dapatkan potongan harga 15% untuk seluruh villa pilihan.',
                'description_en' => 'Exclusive for guests making their first direct booking on the official Ubu Hospitality website. Enjoy 15% off across selected villas.',
                'discount_type' => 'percentage',
                'discount_value' => 15.00,
                'banner_image' => 'https://images.unsplash.com/photo-1540555700478-4be289fbecef?auto=format&fit=crop&w=1200&q=80',
                'booking_period_start' => Carbon::now()->subMonths(1)->toDateString(),
                'booking_period_end' => Carbon::now()->addMonths(6)->toDateString(),
                'stay_period_start' => Carbon::now()->subMonths(1)->toDateString(),
                'stay_period_end' => Carbon::now()->addMonths(8)->toDateString(),
                'terms_conditions_id' => "1. Berlaku untuk tamu baru dengan akun terdaftar di ubu-hospitality.com.\n2. Tidak dapat digabungkan dengan promo lainnya.\n3. Berlaku untuk pemesanan minimal 1 malam.",
                'terms_conditions_en' => "1. Valid for new guests booking via official website.\n2. Cannot be combined with other ongoing promotions.\n3. Minimum stay 1 night.",
                'is_new_user_only' => true,
                'is_popup' => true,
                'popup_cta_text' => 'Klaim Promo',
                'popup_cta_link' => '/stay',
                'priority' => 10,
                'status' => 'published',
                'sentec_promo_sync_status' => 'local_display_only',
            ]
        );

        $promoBuruj = Promotion::firstOrCreate(
            ['code' => 'BURUJBERKAH'],
            [
                'slug' => 'berkah-syariah-potongan-250k',
                'title_id' => 'Berkah Syariah Potongan Rp 250.000',
                'title_en' => 'Buruj Berkah Staycation Rp 250.000 OFF',
                'subtitle_id' => 'Liburan syariah lebih berkah dan hemat bersama keluarga di Buruj Villa',
                'subtitle_en' => 'More rewarding Syariah staycation with family at Buruj Villa',
                'description_id' => 'Dapatkan potongan langsung senilai Rp 250.000 untuk setiap reservasi di seluruh properti Buruj Villa dengan masa menginap minimal 2 malam berturut-turut.',
                'description_en' => 'Receive direct discount of Rp 250,000 for any reservation across all Buruj Villa properties with minimum 2 consecutive nights.',
                'discount_type' => 'fixed_amount',
                'discount_value' => 250000.00,
                'banner_image' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=1200&q=80',
                'booking_period_start' => Carbon::now()->subMonths(1)->toDateString(),
                'booking_period_end' => Carbon::now()->addMonths(4)->toDateString(),
                'stay_period_start' => Carbon::now()->subMonths(1)->toDateString(),
                'stay_period_end' => Carbon::now()->addMonths(5)->toDateString(),
                'terms_conditions_id' => "1. Khusus berlaku untuk brand Buruj Villa.\n2. Minimal menginap 2 malam.\n3. Mematuhi kebijakan syariah yang berlaku.",
                'terms_conditions_en' => "1. Applicable exclusively to Buruj Villa brand.\n2. Minimum stay of 2 nights.\n3. Compliance with Syariah guidelines.",
                'is_new_user_only' => false,
                'is_popup' => false,
                'priority' => 5,
                'status' => 'published',
            ]
        );

        if ($brandUbu) {
            $promoWelcome->brands()->sync([$brandUbu->id]);
        }
        if ($brandBuruj) {
            $promoBuruj->brands()->sync([$brandBuruj->id]);
        }

        // 2. Experiences
        Experience::firstOrCreate(
            ['slug' => 'floating-breakfast-romantis'],
            [
                'title_id' => 'Floating Breakfast Romantis di Kolam Renang',
                'title_en' => 'Romantic Poolside Floating Breakfast',
                'category' => 'culinary',
                'short_description_id' => 'Awali pagi Anda dengan sajian sarapan lezat terapung di atas nampan anyaman estetik tepat di kolam renang privat villa Anda.',
                'short_description_en' => 'Start your morning with a lavish floating breakfast served on an aesthetic tray directly in your private pool.',
                'content_id' => 'Floating Breakfast merupakan salah satu pengalaman paling diminati di Ubu Hospitality. Chef kami menyiapkan pilihan menu khas Indonesia seperti Nasi Goreng Spesial atau American Breakfast lengkap dengan croissant hangat, jus buah segar, teh/kopi pilihan, serta hiasan kelopak bunga di sekitar kolam renang.',
                'content_en' => 'Floating Breakfast is one of the most beloved signature experiences at Ubu Hospitality. Enjoy freshly prepared Indonesian or Continental breakfast sets adorned with fresh tropical flowers.',
                'featured_image' => 'https://images.unsplash.com/photo-1540555700478-4be289fbecef?auto=format&fit=crop&w=800&q=80',
                'price_display' => 'Rp 175.000 / 2 orang',
                'location' => 'Tersedia di seluruh unit villa berkolam renang',
                'brand_id' => $brandUbu?->id,
                'sort_order' => 1,
                'status' => 'published',
            ]
        );

        Experience::firstOrCreate(
            ['slug' => 'merapi-lava-tour-sunrise-jeep'],
            [
                'title_id' => 'Merapi Lava Tour & Sunrise Jeep Adventure',
                'title_en' => 'Merapi Lava Tour & Sunrise Jeep Adventure',
                'category' => 'adventure',
                'short_description_id' => 'Jelajahi keindahan lereng Gunung Merapi saat fajar menyingsing dengan armada jeep 4WD eksklusif diantar langsung dari villa.',
                'short_description_en' => 'Explore the scenic slopes of Mount Merapi at dawn with an exclusive 4WD jeep adventure picked up directly from the villa.',
                'content_id' => 'Pengalaman petualangan memacu adrenalin menyusuri trek bebatuan bekas aliran lava Merapi, mengunjungi Bunker Kaliadem, Batu Alien, dan Museum Mini Sisa Hartaku.',
                'content_en' => 'Adrenaline-pumping journey across historical lava trails, Kaliadem Bunker, Alien Rock, and the historic memorial museum.',
                'featured_image' => 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=800&q=80',
                'price_display' => 'Mulai Rp 450.000 / jeep (maks. 4 orang)',
                'location' => 'Kaliurang & Lereng Merapi',
                'sort_order' => 2,
                'status' => 'published',
            ]
        );

        Experience::firstOrCreate(
            ['slug' => 'private-bbq-dining-setup'],
            [
                'title_id' => 'Private Chef Villa BBQ Dinner',
                'title_en' => 'Private Chef Villa BBQ Dinner',
                'category' => 'culinary',
                'short_description_id' => 'Makan malam hangat bersama keluarga dengan sajian daging panggang premium dan seafood segar yang dimasak langsung oleh koki di halaman villa Anda.',
                'short_description_en' => 'Intimate family evening with premium grilled meats and fresh seafood prepared on-site by our private villa chef.',
                'content_id' => 'Tidak perlu repot keluar villa saat malam hari. Tim kami akan menyiapkan meja makan outdoor dengan penerangan lampu gantung estetik, memanggang daging wagyu meltique, sate ayam bumbu rempah, jagung manis, dan hidangan penutup istimewa.',
                'content_en' => 'No need to leave the comfort of your villa. Our team arranges a delightful candlelit outdoor table, succulent grill cuts, and desserts.',
                'featured_image' => 'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?auto=format&fit=crop&w=800&q=80',
                'price_display' => 'Rp 295.000 / orang (Min. 4 orang)',
                'location' => 'Di villa masing-masing',
                'sort_order' => 3,
                'status' => 'published',
            ]
        );
    }
}
