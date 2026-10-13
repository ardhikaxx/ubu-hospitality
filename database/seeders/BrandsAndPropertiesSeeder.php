<?php

namespace Database\Seeders;

use App\Models\Amenity;
use App\Models\Brand;
use App\Models\Destination;
use App\Models\Property;
use App\Models\PropertyType;
use App\Models\PropertyUnit;
use Illuminate\Database\Seeder;

class BrandsAndPropertiesSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Destinations
        $destSleman = Destination::firstOrCreate(
            ['slug' => 'sleman'],
            [
                'name' => 'Sleman',
                'description_id' => 'Kawasan sejuk dengan suasana asri di utara Yogyakarta, dekat dengan pusat kuliner dan pemandangan Gunung Merapi.',
                'description_en' => 'Scenic and serene area north of Yogyakarta, close to culinary hubs and stunning Mount Merapi vistas.',
                'image_path' => 'https://images.unsplash.com/photo-1544644181-1484b3fdfc62?auto=format&fit=crop&w=800&q=80',
                'sort_order' => 1,
                'is_active' => true,
            ]
        );

        $destKaliurang = Destination::firstOrCreate(
            ['slug' => 'kaliurang'],
            [
                'name' => 'Kaliurang',
                'description_id' => 'Puncak pegunungan berhawa dingin di lereng Merapi, surga liburan keluarga dan retret ketenangan.',
                'description_en' => 'Cool mountain retreat on the slopes of Merapi, a haven for family vacations and peaceful relaxation.',
                'image_path' => 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=800&q=80',
                'sort_order' => 2,
                'is_active' => true,
            ]
        );

        $destBantul = Destination::firstOrCreate(
            ['slug' => 'bantul'],
            [
                'name' => 'Bantul',
                'description_id' => 'Kawasan budaya, seni kerajinan, dan hamparan alam pedesaan yang menyejukkan hati.',
                'description_en' => 'Cultural and craft heritage heartland surrounded by lush countryside tranquility.',
                'image_path' => 'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&w=800&q=80',
                'sort_order' => 3,
                'is_active' => true,
            ]
        );

        $destJogjaKota = Destination::firstOrCreate(
            ['slug' => 'yogyakarta-kota'],
            [
                'name' => 'Kota Yogyakarta',
                'description_id' => 'Jantung kota bersejarah dengan kemudahan akses ke Malioboro, Keraton, dan pusat perbelanjaan.',
                'description_en' => 'Historic city center with seamless access to Malioboro, Kraton Palace, and shopping hubs.',
                'image_path' => 'https://images.unsplash.com/photo-1571003123894-1f0594d2b5d9?auto=format&fit=crop&w=800&q=80',
                'sort_order' => 4,
                'is_active' => true,
            ]
        );

        // 2. Property Types
        $typePrivatePool = PropertyType::firstOrCreate(
            ['slug' => 'private-pool-villa'],
            [
                'name_id' => 'Private Pool Villa',
                'name_en' => 'Private Pool Villa',
                'icon' => 'bi-water',
                'sort_order' => 1,
                'is_active' => true,
            ]
        );

        $typeFamilyVilla = PropertyType::firstOrCreate(
            ['slug' => 'family-residence-villa'],
            [
                'name_id' => 'Family Residence Villa',
                'name_en' => 'Family Residence Villa',
                'icon' => 'bi-house-heart',
                'sort_order' => 2,
                'is_active' => true,
            ]
        );

        $typeGlamping = PropertyType::firstOrCreate(
            ['slug' => 'luxury-glamping'],
            [
                'name_id' => 'Luxury Glamping',
                'name_en' => 'Luxury Glamping',
                'icon' => 'bi-tree',
                'sort_order' => 3,
                'is_active' => true,
            ]
        );

        // 3. Brands
        $brandUbu = Brand::firstOrCreate(
            ['slug' => 'ubu-villa'],
            [
                'name' => 'Ubu Villa',
                'is_master_brand' => false,
                'positioning_type' => 'luxury',
                'tagline_id' => 'Private Sanctuary of Warmth & Elegance',
                'tagline_en' => 'Private Sanctuary of Warmth & Elegance',
                'description_id' => 'Koleksi villa privat eksklusif dengan kolam renang pribadi, layanan personal butler, dan kenyamanan premium untuk liburan romantis maupun keluarga.',
                'description_en' => 'Exclusive private villas featuring private pools, personalized butler service, and premium comfort for romantic getaways and family vacations.',
                'story_id' => 'Ubu Villa lahir dari hasrat untuk menghadirkan oase peristirahatan privat di tengah pesona Yogyakarta. Setiap villa kami rancang dengan sentuhan arsitektur tropis kontemporer, mengutamakan privasi penuh dan kehangatan layanan khas Indonesia. Di sini, setiap momen bersantai bersama orang tersayang menjadi kenangan berharga.',
                'story_en' => 'Ubu Villa was born from a passion to craft private sanctuaries amidst the captivating charm of Yogyakarta. Each villa blends contemporary tropical design with absolute seclusion and genuine Indonesian hospitality warmth.',
                'character_highlights_id' => [
                    'Kolam Renang Privat Eksklusif di setiap unit',
                    'Layanan Floating Breakfast & Afternoon Tea',
                    'Smart Living dengan Wi-Fi kencang & Netflix',
                    'Kehangatan Hospitality khas Jawa & Butler 24 Jam',
                ],
                'character_highlights_en' => [
                    'Exclusive Private Swimming Pool in every villa',
                    'Signature Floating Breakfast & Afternoon Tea',
                    'Smart Living with High-speed Wi-Fi & Netflix',
                    'Genuine Javanese Hospitality & 24/7 Butler Support',
                ],
                'logo_path' => 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=400&q=80',
                'cover_image_path' => 'https://images.unsplash.com/photo-1540555700478-4be289fbecef?auto=format&fit=crop&w=1200&q=80',
                'gallery_images' => [
                    'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=800&q=80',
                    'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=800&q=80',
                    'https://images.unsplash.com/photo-1571896349842-33c89424de2d?auto=format&fit=crop&w=800&q=80',
                ],
                'accent_color' => '#1b3b2b',
                'secondary_color' => '#c5a059',
                'sort_order' => 1,
                'is_active' => true,
                'meta_title_id' => 'Ubu Villa - Sewa Villa Private Pool Mewah Yogyakarta',
                'meta_title_en' => 'Ubu Villa - Luxury Private Pool Villas in Yogyakarta',
                'meta_description_id' => 'Koleksi private pool villa terbaik di Yogyakarta dari Ubu Villa. Dapatkan harga terbaik dengan booking langsung di situs resmi.',
                'meta_description_en' => 'Best private pool villas in Yogyakarta by Ubu Villa. Book directly for the best rates.',
            ]
        );

        $brandBuruj = Brand::firstOrCreate(
            ['slug' => 'buruj-villa'],
            [
                'name' => 'Buruj Villa',
                'is_master_brand' => false,
                'positioning_type' => 'syariah',
                'tagline_id' => 'Peaceful Living in Halal Harmony',
                'tagline_en' => 'Peaceful Living in Halal Harmony',
                'description_id' => 'Villa berkonsep syariah ramah keluarga muslim dengan jaminan privasi kolam renang tanpa celah pandang, lingkungan bersih tanpa alkohol, serta fasilitas ibadah lengkap.',
                'description_en' => 'Muslim-friendly Syariah concept private villa guaranteeing uncompromised pool seclusion, alcohol-free atmosphere, and complete prayer amenities.',
                'story_id' => 'Buruj Villa dihadirkan sebagai jawaban atas kebutuhan keluarga muslim yang mendambakan liburan privat tanpa rasa was-was. Kami menerapkan prinsip kesucian, kenyamanan, dan privasi tinggi. Desain arsitektur kami memastikan kolam renang terlindungi dari pandangan luar sehingga seluruh anggota keluarga dapat berenang dengan leluasa dan tenang.',
                'story_en' => 'Buruj Villa addresses the needs of Muslim families seeking private holidays with complete peace of mind. We implement high privacy standards, ensuring pool areas are completely sheltered from external sightlines so you can unwind comfortably in halal harmony.',
                'character_highlights_id' => [
                    'Jaminan Privasi Kolam Renang Tertutup dari Pandangan Luar',
                    'Fasilitas Ibadah Lengkap (Mukena, Sajadah, Al-Qur\'an, Arah Kiblat Terverifikasi)',
                    'Lingkungan Bersih Bebas Alkohol & Asap Rokok di Kamar',
                    'Khusus Pasangan Halal & Keluarga Berkeluarga',
                ],
                'character_highlights_en' => [
                    'Guaranteed Pool Privacy completely sheltered from external views',
                    'Complete Prayer Amenities (Clean prayer mats, robes, Qur\'an & verified Qibla)',
                    'Strictly Alcohol-Free and Smoke-Free indoor environment',
                    'Dedicated to Married Couples & Family Travel',
                ],
                'logo_path' => 'https://images.unsplash.com/photo-1578683010236-d716f9a3f461?auto=format&fit=crop&w=400&q=80',
                'cover_image_path' => 'https://images.unsplash.com/photo-1613490493576-7fde63acd811?auto=format&fit=crop&w=1200&q=80',
                'gallery_images' => [
                    'https://images.unsplash.com/photo-1613490493576-7fde63acd811?auto=format&fit=crop&w=800&q=80',
                    'https://images.unsplash.com/photo-1580587771525-78b9dba3b914?auto=format&fit=crop&w=800&q=80',
                ],
                'accent_color' => '#0f2c3d',
                'secondary_color' => '#d4af37',
                'sort_order' => 2,
                'is_active' => true,
                'meta_title_id' => 'Buruj Villa - Villa Syariah Privat Kolam Renang di Yogyakarta',
                'meta_title_en' => 'Buruj Villa - Syariah Private Pool Villa in Yogyakarta',
                'meta_description_id' => 'Pengalaman menginap syariah ramah keluarga di Yogyakarta. Kolam renang privat terlindung, fasilitas ibadah lengkap, dan suasana damai.',
                'meta_description_en' => 'Muslim-friendly private pool villa in Yogyakarta with verified halal standards and complete privacy.',
            ]
        );

        $brandGlamping = Brand::firstOrCreate(
            ['slug' => 'ubu-glamping'],
            [
                'name' => 'Ubu Glamping',
                'is_master_brand' => false,
                'positioning_type' => 'glamping',
                'tagline_id' => 'Nature Escape with Luxury Comfort',
                'tagline_en' => 'Nature Escape with Luxury Comfort',
                'description_id' => 'Pengalaman berkemah mewah menyatu dengan keindahan alam perbukitan Yogyakarta, dilengkapi kasur empuk, kamar mandi dalam, dan api unggun privat.',
                'description_en' => 'Luxury glamping blending raw nature and lavish comfort with ensuite bathrooms, plush beds, and private stargazing campfires.',
                'story_id' => 'Ubu Glamping menawarkan pelarian dari kepenatan kota menuju pelukan alam yang meneduhkan, tanpa mengorbankan kenyamanan kasur bintang lima.',
                'story_en' => 'Ubu Glamping offers a soothing escape into nature without sacrificing five-star sleeping comforts.',
                'character_highlights_id' => [
                    'Tenda Mewah Berpendingin Udara (AC)',
                    'Kamar Mandi Dalam dengan Water Heater',
                    'Area Api Unggun & BBQ Malam Hari',
                ],
                'character_highlights_en' => [
                    'Air-Conditioned Luxury Safari Tents',
                    'Private Ensuite Bathroom with Hot Water',
                    'Campfire & Evening BBQ Experience',
                ],
                'logo_path' => 'https://images.unsplash.com/photo-1510312305653-8ed496efae75?auto=format&fit=crop&w=400&q=80',
                'cover_image_path' => 'https://images.unsplash.com/photo-1499793983690-e29da59ef1c2?auto=format&fit=crop&w=1200&q=80',
                'accent_color' => '#3d3422',
                'secondary_color' => '#8fbc8f',
                'sort_order' => 3,
                'is_active' => true,
            ]
        );

        // 4. Amenities
        $amenityData = [
            ['name_id' => 'Private Swimming Pool', 'name_en' => 'Private Swimming Pool', 'category' => 'outdoor', 'icon' => 'bi-water', 'sort' => 1],
            ['name_id' => 'Floating Breakfast', 'name_en' => 'Floating Breakfast', 'category' => 'service', 'icon' => 'bi-cup-hot', 'sort' => 2],
            ['name_id' => 'Wi-Fi 100 Mbps', 'name_en' => 'High-Speed Wi-Fi', 'category' => 'general', 'icon' => 'bi-wifi', 'sort' => 3],
            ['name_id' => 'Smart TV & Netflix', 'name_en' => 'Smart TV & Netflix', 'category' => 'room', 'icon' => 'bi-tv', 'sort' => 4],
            ['name_id' => 'Dapur Lengkap & Kulkas', 'name_en' => 'Equipped Kitchenette', 'category' => 'room', 'icon' => 'bi-egg-fried', 'sort' => 5],
            ['name_id' => 'Alat BBQ Grill', 'name_en' => 'BBQ Grill Facilities', 'category' => 'outdoor', 'icon' => 'bi-fire', 'sort' => 6],
            ['name_id' => 'Perlengkapan Ibadah & Arah Kiblat', 'name_en' => 'Prayer Set & Verified Qibla', 'category' => 'syariah', 'icon' => 'bi-compass', 'sort' => 7],
            ['name_id' => 'Air Conditioner (AC)', 'name_en' => 'Air Conditioning', 'category' => 'room', 'icon' => 'bi-snow', 'sort' => 8],
            ['name_id' => 'Water Heater (Air Hangat)', 'name_en' => 'Hot Water Shower', 'category' => 'room', 'icon' => 'bi-droplet-half', 'sort' => 9],
            ['name_id' => 'Parkir Mobil Privat Gratis', 'name_en' => 'Free Private Parking', 'category' => 'general', 'icon' => 'bi-p-circle', 'sort' => 10],
            ['name_id' => 'Layanan Butler 24 Jam', 'name_en' => '24/7 Butler Service', 'category' => 'service', 'icon' => 'bi-person-check', 'sort' => 11],
        ];

        $amenities = [];
        foreach ($amenityData as $item) {
            $amenities[$item['name_en']] = Amenity::firstOrCreate(
                ['name_en' => $item['name_en']],
                [
                    'name_id' => $item['name_id'],
                    'category' => $item['category'],
                    'icon' => $item['icon'],
                    'sort_order' => $item['sort'],
                ]
            );
        }

        // 5. Properties
        // Property 1: Ubu Villa Gito Gati
        $p1 = Property::updateOrCreate(
            ['slug' => 'ubu-villa-gito-gati'],
            [
                'brand_id' => $brandUbu->id,
                'property_type_id' => $typePrivatePool->id,
                'destination_id' => $destSleman->id,
                'name' => 'Ubu Villa Gito Gati',
                'headline_id' => 'Private pool villa elegan di Sleman dengan suasana tropis yang menenangkan',
                'headline_en' => 'Elegant private pool villa in Sleman with soothing tropical ambiance',
                'description_id' => 'Ubu Villa Gito Gati dirancang untuk menghadirkan kenyamanan istimewa di tengah suasana tenang Sleman, Yogyakarta. Dilengkapi dengan kolam renang privat berair jernih, area bersantai terbuka dengan sofa empuk, serta dapur bersih modern. Lokasi strategis dekat dengan berbagai destinasi kuliner terkenal seperti Kopi Klotok dan Jejamuran.',
                'description_en' => 'Ubu Villa Gito Gati is designed to offer exceptional privacy and relaxation in the serene neighborhood of Sleman, Yogyakarta. Featuring a crystal-clear private pool, open-air sunken lounge, and modern equipped kitchen. Strategically located near famous culinary hotspots.',
                'address' => 'Jl. Gito Gati No. 45, Sariharjo, Ngaglik, Sleman',
                'city' => 'Sleman, Yogyakarta',
                'latitude' => -7.7182900,
                'longitude' => 110.3785400,
                'google_maps_url' => 'https://maps.google.com/?q=-7.7182900,110.3785400',
                'max_guests' => 6,
                'bedrooms' => 3,
                'bathrooms' => 3,
                'beds_description' => '2 King Beds, 1 Queen Bed',
                'area_sqm' => 280,
                'featured_image' => 'https://images.unsplash.com/photo-1580587771525-78b9dba3b914?auto=format&fit=crop&w=1200&q=80',
                'gallery_images' => [
                    'https://images.unsplash.com/photo-1580587771525-78b9dba3b914?auto=format&fit=crop&w=800&q=80',
                    'https://images.unsplash.com/photo-1540555700478-4be289fbecef?auto=format&fit=crop&w=800&q=80',
                    'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=800&q=80',
                    'https://images.unsplash.com/photo-1571896349842-33c89424de2d?auto=format&fit=crop&w=800&q=80',
                ],
                'starting_price_display' => 1850000.00,
                'currency' => 'IDR',
                'has_private_pool' => true,
                'is_featured' => true,
                'is_syariah' => false,
                'sentec_property_id' => 'SENTEC-UV-001',
                'house_rules_id' => "1. Waktu check-in mulai pukul 14:00 WIB, check-out maksimal pukul 12:00 WIB.\n2. Dilarang merokok di dalam kamar tidur (tersedia area merokok di teras luar).\n3. Jam tenang lingkungan mulai pukul 22:00 WIB untuk menjaga kenyamanan sekitar.\n4. Hewan peliharaan tidak diperkenankan.",
                'house_rules_en' => "1. Check-in starts at 14:00, check-out by 12:00.\n2. No smoking inside bedrooms (smoking area available at outdoor terrace).\n3. Quiet hours start at 22:00 to respect neighborhood tranquility.\n4. Pets are not allowed.",
                'checkin_time' => '14:00',
                'checkout_time' => '12:00',
                'cancellation_policy_id' => 'Pembatalan gratis hingga 7 hari sebelum tanggal check-in. Pembatalan dalam rentang 3-6 hari dikenakan biaya 50%.',
                'cancellation_policy_en' => 'Free cancellation up to 7 days before check-in date. Cancellations within 3-6 days incur 50% charge.',
                'nearby_attractions' => [
                    ['title' => 'Warung Kopi Klotok', 'distance' => '15 menit berkendara'],
                    ['title' => 'Restoran Jejamuran', 'distance' => '8 menit berkendara'],
                    ['title' => 'Pusat Kota Malioboro', 'distance' => '25 menit berkendara'],
                ],
                'sort_order' => 1,
                'status' => 'published',
                'meta_title_id' => 'Ubu Villa Gito Gati - Villa Private Pool di Sleman Yogyakarta',
                'meta_title_en' => 'Ubu Villa Gito Gati - Private Pool Villa in Sleman Yogyakarta',
                'meta_description_id' => 'Sewa Ubu Villa Gito Gati Sleman Yogyakarta. 3 kamar tidur, private pool, floating breakfast, booking langsung harga terbaik.',
                'meta_description_en' => 'Book Ubu Villa Gito Gati Sleman Yogyakarta. 3 bedrooms, private pool, floating breakfast, best direct rate guaranteed.',
            ]
        );
        $p1->amenities()->sync(Amenity::pluck('id')->toArray());

        // Property 2: Ubu Villa Kaliurang Peak
        $p2 = Property::updateOrCreate(
            ['slug' => 'ubu-villa-kaliurang-peak'],
            [
                'brand_id' => $brandUbu->id,
                'property_type_id' => $typeFamilyVilla->id,
                'destination_id' => $destKaliurang->id,
                'name' => 'Ubu Villa Kaliurang Peak',
                'headline_id' => 'Villa keluarga mewah di lereng Gunung Merapi dengan hawa sejuk dan pemandangan hijau',
                'headline_en' => 'Luxury family villa on the slopes of Merapi with cool mountain breeze and pine views',
                'description_id' => 'Ubu Villa Kaliurang Peak menawarkan peristirahatan luas berkapasitas hingga 10 tamu. Dikelilingi pohon pinus rindang dan hawa pegunungan yang segar. Dilengkapi dengan kolam renang privat air hangat, area BBQ luas, dan balkon lantai dua dengan pemandangan langsung ke puncak Merapi saat pagi hari.',
                'description_en' => 'Ubu Villa Kaliurang Peak provides spacious family accommodation accommodating up to 10 guests. Surrounded by pine trees and crisp alpine air. Features heated private pool, expansive outdoor BBQ lawn, and panoramic balcony.',
                'address' => 'Jl. Boyong KM 22, Hargobinangun, Pakem, Sleman',
                'city' => 'Kaliurang, Yogyakarta',
                'latitude' => -7.6041000,
                'longitude' => 110.4256000,
                'max_guests' => 10,
                'bedrooms' => 4,
                'bathrooms' => 4,
                'beds_description' => '3 King Beds, 2 Single Beds',
                'area_sqm' => 420,
                'featured_image' => 'https://images.unsplash.com/photo-1613490493576-7fde63acd811?auto=format&fit=crop&w=1200&q=80',
                'gallery_images' => [
                    'https://images.unsplash.com/photo-1613490493576-7fde63acd811?auto=format&fit=crop&w=800&q=80',
                    'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&w=800&q=80',
                ],
                'starting_price_display' => 2450000.00,
                'currency' => 'IDR',
                'has_private_pool' => true,
                'is_featured' => true,
                'is_syariah' => false,
                'sentec_property_id' => 'SENTEC-UV-002',
                'sort_order' => 2,
                'status' => 'published',
            ]
        );
        $p2->amenities()->sync(Amenity::pluck('id')->toArray());

        // Property 3: Buruj Villa Palagan Syariah
        $p3 = Property::updateOrCreate(
            ['slug' => 'buruj-villa-palagan-syariah'],
            [
                'brand_id' => $brandBuruj->id,
                'property_type_id' => $typePrivatePool->id,
                'destination_id' => $destSleman->id,
                'name' => 'Buruj Villa Palagan Syariah',
                'headline_id' => 'Villa syariah berpagar tinggi dengan privasi penuh kolam renang tanpa celah pandang',
                'headline_en' => 'Syariah private pool villa with absolute seclusion and uncompromised family privacy',
                'description_id' => 'Buruj Villa Palagan dihadirkan khusus bagi keluarga muslim yang mengutamakan privasi dan kenyamanan syariah. Kolam renang didesain tertutup dari pandangan luar sehingga muslimah dapat berenang dengan rasa aman dan nyaman. Dilengkapi sajadah bersih wangi di setiap kamar, mukena premium, Al-Qur\'an, serta sertifikasi arah kiblat terverifikasi. Seluruh lingkungan bebas dari minuman keras dan rokok.',
                'description_en' => 'Buruj Villa Palagan is thoughtfully created for Muslim families seeking privacy and Halal hospitality excellence. The private swimming pool is completely enclosed from external line-of-sight. Includes fragrant prayer mats, premium prayer gowns, Qur\'an, and verified Qibla in every suite. Strictly alcohol-free and smoke-free.',
                'address' => 'Jl. Palagan Tentara Pelajar KM 9, Sariharjo, Ngaglik, Sleman',
                'city' => 'Sleman, Yogyakarta',
                'latitude' => -7.7125000,
                'longitude' => 110.3850000,
                'max_guests' => 8,
                'bedrooms' => 3,
                'bathrooms' => 3,
                'beds_description' => '2 King Beds, 2 Single Beds',
                'area_sqm' => 310,
                'featured_image' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=1200&q=80',
                'gallery_images' => [
                    'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=800&q=80',
                    'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=800&q=80',
                ],
                'starting_price_display' => 1950000.00,
                'currency' => 'IDR',
                'has_private_pool' => true,
                'is_featured' => true,
                'is_syariah' => true,
                'sentec_property_id' => 'SENTEC-BV-001',
                'house_rules_id' => "1. Wajib menunjukkan identitas sah pasangan halal (buku nikah/KTP berdomisili sama) untuk pasangan non-keluarga besar.\n2. Lingkungan 100% bebas dari minuman keras dan zat terlarang.\n3. Dilarang merokok di seluruh area dalam kamar.\n4. Waktu check-in 14:00, check-out 12:00.",
                'house_rules_en' => "1. Married couples or families only. Valid marriage documentation or shared ID requested at check-in.\n2. 100% alcohol-free and substance-free environment.\n3. Strictly no smoking inside all bedroom suites.\n4. Check-in 14:00, check-out 12:00.",
                'sort_order' => 3,
                'status' => 'published',
            ]
        );
        $p3->amenities()->sync(Amenity::pluck('id')->toArray());

        // Property 4: Buruj Villa Bantul Heritage
        $p4 = Property::updateOrCreate(
            ['slug' => 'buruj-villa-bantul-heritage'],
            [
                'brand_id' => $brandBuruj->id,
                'property_type_id' => $typePrivatePool->id,
                'destination_id' => $destBantul->id,
                'name' => 'Buruj Villa Bantul Heritage',
                'headline_id' => 'Retret syariah asri dengan sentuhan arsitektur limasan kayu jati dan kolam renang privat',
                'headline_en' => 'Serene Syariah retreat blending classic Javanese teak Limasan architecture and private pool',
                'description_id' => 'Buruj Villa Bantul Heritage memadukan kehangatan budaya Jawa klasik dengan kemewahan fasilitas modern yang ramah syariah. Berada di lingkungan pedesaan yang tenang dekat sentra kerajinan Kasongan, sangat cocok untuk liburan keluarga yang mencari kedamaian dan suasana islami yang teduh.',
                'description_en' => 'Buruj Villa Bantul Heritage harmonizes traditional Javanese Limasan artistry with contemporary Halal-friendly luxury. Nestled in a quiet rural setting near Kasongan pottery center.',
                'address' => 'Jl. Bantul KM 7.5, Pendowoharjo, Sewon, Bantul',
                'city' => 'Bantul, Yogyakarta',
                'max_guests' => 6,
                'bedrooms' => 2,
                'bathrooms' => 2,
                'beds_description' => '2 King Beds',
                'area_sqm' => 240,
                'featured_image' => 'https://images.unsplash.com/photo-1571896349842-33c89424de2d?auto=format&fit=crop&w=1200&q=80',
                'starting_price_display' => 1450000.00,
                'currency' => 'IDR',
                'has_private_pool' => true,
                'is_featured' => false,
                'is_syariah' => true,
                'sentec_property_id' => 'SENTEC-BV-002',
                'sort_order' => 4,
                'status' => 'published',
            ]
        );
        $p4->amenities()->sync(Amenity::pluck('id')->toArray());

        // Property 5: Ubu Glamping Menoreh
        $p5 = Property::updateOrCreate(
            ['slug' => 'ubu-glamping-menoreh'],
            [
                'brand_id' => $brandGlamping->id,
                'property_type_id' => $typeGlamping->id,
                'destination_id' => $destKaliurang->id,
                'name' => 'Ubu Glamping Menoreh',
                'headline_id' => 'Sensasi glamping mewah tenda safari berpendingin udara di pelukan bukit hijau',
                'headline_en' => 'Luxury air-conditioned safari glamping experience embraced by verdant hills',
                'description_id' => 'Ubu Glamping Menoreh menghadirkan pengalaman menginap unik di bawah taburan bintang tanpa kehilangan kenyamanan kasur empuk dan AC. Nikmati sore yang tenang dengan kopi hangat dan malam syahdu di samping perapian api unggun privat.',
                'description_en' => 'Ubu Glamping Menoreh delivers a unique stargazing escape beneath the night sky without compromising on plush bedding, air conditioning, and private ensuite comforts.',
                'address' => 'Perbukitan Menoreh, Samigaluh, Kulon Progo - Sleman',
                'city' => 'Sleman / Kulon Progo',
                'max_guests' => 2,
                'bedrooms' => 1,
                'bathrooms' => 1,
                'beds_description' => '1 King Bed',
                'area_sqm' => 45,
                'featured_image' => 'https://images.unsplash.com/photo-1499793983690-e29da59ef1c2?auto=format&fit=crop&w=1200&q=80',
                'starting_price_display' => 850000.00,
                'currency' => 'IDR',
                'has_private_pool' => false,
                'is_featured' => false,
                'is_syariah' => false,
                'sentec_property_id' => 'SENTEC-UG-001',
                'sort_order' => 5,
                'status' => 'published',
            ]
        );
        $p5->amenities()->sync(Amenity::whereIn('name_en', ['Air Conditioning', 'Hot Water Shower', 'Free Private Parking', 'High-Speed Wi-Fi'])->pluck('id')->toArray());

        // Units for Property 1
        PropertyUnit::firstOrCreate(
            ['property_id' => $p1->id, 'name' => 'Master Suite Tropical'],
            [
                'capacity_guests' => 2,
                'bedrooms' => 1,
                'bathrooms' => 1,
                'beds_configuration' => '1 King Bed',
                'area_sqm' => 48,
                'price_estimate' => 800000.00,
                'sentec_room_type_id' => 'ROOM-UV-01-MASTER',
            ]
        );
        PropertyUnit::firstOrCreate(
            ['property_id' => $p1->id, 'name' => 'Entire Villa Booking (3 BR Private Pool)'],
            [
                'capacity_guests' => 6,
                'bedrooms' => 3,
                'bathrooms' => 3,
                'beds_configuration' => '2 King Beds, 1 Queen Bed',
                'area_sqm' => 280,
                'price_estimate' => 1850000.00,
                'sentec_room_type_id' => 'ROOM-UV-01-ENTIRE',
            ]
        );
    }
}
