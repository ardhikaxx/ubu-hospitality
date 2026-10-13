<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\Brand;
use App\Models\GuestReview;
use App\Models\Property;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class BlogAndReviewsSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::first();
        $brandUbu = Brand::where('slug', 'ubu-villa')->first();
        $brandBuruj = Brand::where('slug', 'buruj-villa')->first();
        $propGitoGati = Property::where('slug', 'ubu-villa-gito-gati')->first();
        $propPalagan = Property::where('slug', 'buruj-villa-palagan-syariah')->first();

        // 1. Blog Categories
        $catDestinasi = BlogCategory::firstOrCreate(
            ['slug' => 'destinasi-wisata'],
            [
                'name_id' => 'Destinasi & Wisata',
                'name_en' => 'Destinations & Travel',
                'description_id' => 'Inspirasi tempat wisata menarik dan tersembunyi di sekitar Yogyakarta.',
                'description_en' => 'Inspiring attractions and hidden gems around Yogyakarta.',
            ]
        );

        $catTips = BlogCategory::firstOrCreate(
            ['slug' => 'tips-menginap'],
            [
                'name_id' => 'Tips Menginap',
                'name_en' => 'Staycation Tips',
                'description_id' => 'Panduan memaksimalkan kenyamanan liburan privat Anda.',
                'description_en' => 'Guides to maximizing your private luxury holiday experience.',
            ]
        );

        $catSyariah = BlogCategory::firstOrCreate(
            ['slug' => 'hospitality-syariah'],
            [
                'name_id' => 'Hospitality Syariah',
                'name_en' => 'Halal & Syariah Living',
                'description_id' => 'Edukasi dan nilai menginap ramah keluarga muslim.',
                'description_en' => 'Insights into Muslim-friendly and Syariah family vacations.',
            ]
        );

        // 2. Blog Posts
        BlogPost::firstOrCreate(
            ['slug' => 'alasan-memilih-private-pool-villa-yogyakarta'],
            [
                'category_id' => $catTips->id,
                'author_id' => $admin?->id ?? 1,
                'title_id' => '7 Alasan Memilih Private Pool Villa untuk Liburan Keluarga di Yogyakarta',
                'title_en' => '7 Reasons to Choose a Private Pool Villa for Family Vacation in Yogyakarta',
                'excerpt_id' => 'Mengapa private pool villa menjadi pilihan utama wisatawan yang mendambakan keintiman, keleluasaan, dan kenyamanan tanpa gangguan keramaian publik?',
                'excerpt_en' => 'Why are private pool villas the ultimate choice for travelers seeking intimacy, freedom, and comfort away from public crowds?',
                'content_id' => '<p>Liburan bersama keluarga tercinta selalu menjadi momen yang dinanti-nanti. Di tengah pesona budaya dan keindahan alam Yogyakarta, memilih akomodasi yang tepat adalah kunci utama terciptanya kenangan manis.</p><h3>1. Privasi Penuh Tanpa Gangguan Tamu Lain</h3><p>Berbeda dengan hotel konvensional di mana kolam renang harus berbagi dengan puluhan tamu lain, di private pool villa Anda memiliki kontrol penuh atas ruang dan waktu Anda sendiri.</p><h3>2. Suasana Hangat Seperti di Rumah Sendiri</h3><p>Dengan ruang tamu yang luas, dapur bersih, dan area makan terbuka, seluruh anggota keluarga dapat berkumpul, memasak bersama, atau sekadar berbincang santai hingga larut malam.</p><h3>3. Layanan Floating Breakfast yang Ikonik</h3><p>Momen sarapan terapung di atas kolam renang pribadi bukan hanya lezat tetapi juga menghasilkan foto-foto estetik yang tak terlupakan.</p>',
                'content_en' => '<p>A family holiday is always a cherished moment. Choosing the right accommodation in Yogyakarta is key to creating everlasting memories.</p><h3>1. Absolute Privacy</h3><p>Unlike conventional hotels, a private pool villa grants you uninterrupted seclusion and freedom.</p><h3>2. Warm Residential Feel</h3><p>Spacious living spaces and kitchens allow your family to bond intimately.</p>',
                'featured_image' => 'https://images.unsplash.com/photo-1580587771525-78b9dba3b914?auto=format&fit=crop&w=1200&q=80',
                'reading_time_minutes' => 4,
                'status' => 'published',
                'published_at' => Carbon::now()->subDays(5),
                'views_count' => 142,
            ]
        );

        BlogPost::firstOrCreate(
            ['slug' => 'panduan-staycation-syariah-buruj-villa'],
            [
                'category_id' => $catSyariah->id,
                'author_id' => $admin?->id ?? 1,
                'title_id' => 'Panduan Staycation Syariah: Berlibur Tenang dan Berkah di Buruj Villa',
                'title_en' => 'Syariah Staycation Guide: Peaceful and Blessed Retreat at Buruj Villa',
                'excerpt_id' => 'Ketahui standar dan fasilitas yang menjadikan Buruj Villa pilihan terpercaya bagi keluarga muslim yang mengutamakan privasi dan nilai keislaman.',
                'excerpt_en' => 'Discover the standards and amenities making Buruj Villa the premier choice for Muslim families valuing privacy and halal values.',
                'content_id' => '<p>Bagi keluarga muslim dan para muslimah, mencari tempat menginap dengan kolam renang yang benar-benar terlindung dari pandangan luar sering kali menjadi tantangan. Buruj Villa hadir menjawab keresahan tersebut dengan rancangan arsitektur khusus.</p><h3>Kolam Renang Berpagar Tinggi</h3><p>Dinding pembatas yang didesain secara cermat memastikan tidak ada sudut pandang dari bangunan tetangga maupun jalan raya.</p><h3>Fasilitas Ibadah yang Memuliakan Tamu</h3><p>Setiap kamar tidur telah dilengkapi dengan sajadah bersih, mukena wangi, mushaf Al-Qur\'an, serta penanda arah kiblat yang telah dikalibrasi secara akurat.</p>',
                'content_en' => '<p>For Muslim families, finding a retreat with complete swimming pool privacy is paramount. Buruj Villa fulfills this requirement with dedicated architectural design and verified halal standards.</p>',
                'featured_image' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=1200&q=80',
                'reading_time_minutes' => 5,
                'status' => 'published',
                'published_at' => Carbon::now()->subDays(2),
                'views_count' => 98,
            ]
        );

        // 3. Guest Reviews (Curated 5-Star Google Reviews)
        $reviews = [
            [
                'property_id' => $propGitoGati?->id,
                'brand_id' => $brandUbu?->id,
                'guest_name' => 'Dimas Pratama & Keluarga',
                'guest_origin' => 'Jakarta Selatan',
                'rating' => 5,
                'review_text_id' => 'Villa luar biasa bersih dan sangat estetik! Anak-anak sangat suka kolam renangnya, airnya jernih sekali. Pelayanan butlernya sangat ramah dan responsif saat kami minta tambahan handuk dan sarapan terapung. Pasti akan kembali lagi kalau ke Jogja!',
                'review_text_en' => 'Exceptionally clean and aesthetic villa! Kids loved the crystal-clear pool. Butler service was friendly and swift for our floating breakfast. Will definitely return!',
                'review_date' => Carbon::now()->subDays(12)->toDateString(),
                'source' => 'google',
                'google_review_id' => 'G-REV-001',
                'is_verified' => true,
                'is_featured' => true,
            ],
            [
                'property_id' => $propPalagan?->id,
                'brand_id' => $brandBuruj?->id,
                'guest_name' => 'Hj. Siti Nurhaliza & Suami',
                'guest_origin' => 'Surabaya',
                'rating' => 5,
                'review_text_id' => 'Alhamdulillah menemukan Buruj Villa. Sebagai muslimah berhijab, saya bisa berenang dengan sangat leluasa karena kolam renangnya benar-benar tertutup tanpa terlihat dari luar sama sekali. Peralatan sholat lengkap dan wangi. Sangat recommended untuk keluarga muslim!',
                'review_text_en' => 'Alhamdulillah for discovering Buruj Villa. As a hijabi, I could swim freely because the pool is completely shielded from external view. Complete prayer amenities and wonderful serenity.',
                'review_date' => Carbon::now()->subDays(8)->toDateString(),
                'source' => 'google',
                'google_review_id' => 'G-REV-002',
                'is_verified' => true,
                'is_featured' => true,
            ],
            [
                'property_id' => $propGitoGati?->id,
                'brand_id' => $brandUbu?->id,
                'guest_name' => 'Michael & Sarah TAN',
                'guest_origin' => 'Singapore',
                'rating' => 5,
                'review_text_id' => 'One of the best villa experiences in Indonesia! Private, luxurious, and surrounded by quiet greenery. The floating breakfast setup was sensational. Highly recommended for couples!',
                'review_text_en' => 'One of the best villa experiences in Indonesia! Private, luxurious, and surrounded by quiet greenery. The floating breakfast setup was sensational. Highly recommended for couples!',
                'review_date' => Carbon::now()->subDays(18)->toDateString(),
                'source' => 'google',
                'google_review_id' => 'G-REV-003',
                'is_verified' => true,
                'is_featured' => true,
            ],
            [
                'property_id' => $propPalagan?->id,
                'brand_id' => $brandBuruj?->id,
                'guest_name' => 'dr. Ridwan Hakim',
                'guest_origin' => 'Bandung',
                'rating' => 5,
                'review_text_id' => 'Konsep syariahnya benar-benar dijalankan dengan profesional dan modern, bukan sekadar tempelan nama. Fasilitasnya kelas bintang lima, kasur sangat empuk, AC dingin, dan lingkungan asri tanpa kebisingan.',
                'review_text_en' => 'The Syariah concept is implemented professionally and modernly. 5-star standard bedding, quiet surroundings, and peaceful ambiance.',
                'review_date' => Carbon::now()->subDays(25)->toDateString(),
                'source' => 'google',
                'google_review_id' => 'G-REV-004',
                'is_verified' => true,
                'is_featured' => true,
            ],
        ];

        foreach ($reviews as $rev) {
            GuestReview::create($rev);
        }
    }
}
