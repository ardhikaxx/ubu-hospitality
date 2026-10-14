<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // General Company Info
            ['key' => 'company_name', 'value' => 'PT Ubu Hospitality Indonesia', 'group' => 'general', 'type' => 'text', 'description' => 'Nama legal badan usaha'],
            ['key' => 'brand_name', 'value' => 'Ubu Hospitality', 'group' => 'general', 'type' => 'text', 'description' => 'Nama brand utama'],
            ['key' => 'site_tagline_id', 'value' => 'Master of Warmth & Authentic Hospitality', 'group' => 'general', 'type' => 'text', 'description' => 'Tagline utama'],
            ['key' => 'site_tagline_en', 'value' => 'Master of Warmth & Authentic Hospitality', 'group' => 'general', 'type' => 'text', 'description' => 'Tagline EN'],
            ['key' => 'contact_whatsapp', 'value' => '0823-2000-3297', 'group' => 'contact', 'type' => 'text', 'description' => 'Nomor WhatsApp resmi'],
            ['key' => 'contact_whatsapp_url', 'value' => 'https://api.whatsapp.com/send?phone=+6282320003297', 'group' => 'contact', 'type' => 'text', 'description' => 'Direct link WhatsApp CS'],
            ['key' => 'contact_email', 'value' => 'info@ubuvilla.com', 'group' => 'contact', 'type' => 'text', 'description' => 'Email resmi reservasi'],
            ['key' => 'contact_partnership_email', 'value' => 'partnership@ubuvilla.com', 'group' => 'contact', 'type' => 'text', 'description' => 'Email kemitraan'],
            ['key' => 'contact_phone', 'value' => '0823-2000-3297', 'group' => 'contact', 'type' => 'text', 'description' => 'Nomor telepon kantor'],
            ['key' => 'contact_address', 'value' => 'Jl. Pandhawa No.002/17, Tegalrejo, Sariharjo, Kec. Ngaglik, Kabupaten Sleman, Daerah Istimewa Yogyakarta 55581', 'group' => 'contact', 'type' => 'text', 'description' => 'Alamat kantor pusat'],

            // Social Media
            ['key' => 'social_instagram', 'value' => 'https://www.instagram.com/ubuvilla/', 'group' => 'social', 'type' => 'text', 'description' => 'Akun Instagram resmi'],
            ['key' => 'social_tiktok', 'value' => 'https://www.tiktok.com/@ubuvilla', 'group' => 'social', 'type' => 'text', 'description' => 'Akun TikTok resmi'],
            ['key' => 'social_youtube', 'value' => 'https://www.youtube.com/@ubuvillaindonesia', 'group' => 'social', 'type' => 'text', 'description' => 'Channel YouTube resmi'],
            ['key' => 'social_facebook', 'value' => 'https://www.facebook.com/ubuvillaindonesia/', 'group' => 'social', 'type' => 'text', 'description' => 'Halaman Facebook resmi'],
            ['key' => 'social_whatsapp', 'value' => 'https://api.whatsapp.com/send?phone=+6282320003297', 'group' => 'social', 'type' => 'text', 'description' => 'Direct WhatsApp link'],
            ['key' => 'social_linkedin', 'value' => 'https://linkedin.com/company/ubu-hospitality', 'group' => 'social', 'type' => 'text', 'description' => 'Halaman LinkedIn'],

            // SEO Defaults
            ['key' => 'default_meta_title_id', 'value' => 'Ubu Hospitality - Manajemen Villa & Glamping Premium di Yogyakarta', 'group' => 'seo', 'type' => 'text', 'description' => 'Default meta title ID'],
            ['key' => 'default_meta_title_en', 'value' => 'Ubu Hospitality - Luxury Villa & Glamping Management in Yogyakarta', 'group' => 'seo', 'type' => 'text', 'description' => 'Default meta title EN'],
            ['key' => 'default_meta_description_id', 'value' => 'Temukan pengalaman menginap privat tak terlupakan bersama Ubu Hospitality. Menaungi Ubu Villa dan Buruj Villa (Syariah-compliant) dengan fasilitas private pool mewah di Yogyakarta.', 'group' => 'seo', 'type' => 'text', 'description' => 'Default meta description ID'],
            ['key' => 'default_meta_description_en', 'value' => 'Discover unforgettable private stays with Ubu Hospitality. Managing luxury brands including Ubu Villa and Buruj Villa (Syariah-compliant) in Yogyakarta.', 'group' => 'seo', 'type' => 'text', 'description' => 'Default meta description EN'],

            // Integrations
            ['key' => 'sentec_booking_subdomain', 'value' => 'booking.ubuhospitality.com', 'group' => 'integrations', 'type' => 'text', 'description' => 'Subdomain booking engine SENTEC'],
            ['key' => 'sentec_mock_mode', 'value' => '1', 'group' => 'integrations', 'type' => 'boolean', 'description' => 'Mode Mock SENTEC (Aktif bila API live belum disambungkan)'],
            ['key' => 'doku_mock_mode', 'value' => '1', 'group' => 'integrations', 'type' => 'boolean', 'description' => 'Mode Mock DOKU Payment'],
            ['key' => 'google_reviews_enabled', 'value' => '1', 'group' => 'integrations', 'type' => 'boolean', 'description' => 'Tampilkan ulasan bintang 5'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
