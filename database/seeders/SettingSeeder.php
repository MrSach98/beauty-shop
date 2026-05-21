<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run()
    {
        $settings = [
            // General
            ['key' => 'site_name',        'value' => 'Beauty Shop',          'group' => 'general'],
            ['key' => 'site_tagline',      'value' => 'Beauty at your door',  'group' => 'general'],
            ['key' => 'site_email',        'value' => 'info@beautyshop.com',  'group' => 'general'],
            ['key' => 'site_phone',        'value' => '+91 9999999999',        'group' => 'general'],
            ['key' => 'site_address',      'value' => '',                      'group' => 'general'],
            ['key' => 'site_logo',         'value' => '',                      'group' => 'general'],
            ['key' => 'site_favicon',      'value' => '',                      'group' => 'general'],
            ['key' => 'maintenance_mode',  'value' => '0',                     'group' => 'general'],
            ['key' => 'maintenance_msg',   'value' => 'We are under maintenance. Back soon!', 'group' => 'general'],
            ['key' => 'currency_symbol',   'value' => '₹',                    'group' => 'general'],
            ['key' => 'currency_code',     'value' => 'INR',                   'group' => 'general'],

            // Payment
            ['key' => 'razorpay_enabled',  'value' => '0',  'group' => 'payment'],
            ['key' => 'razorpay_key_id',   'value' => '',   'group' => 'payment'],
            ['key' => 'razorpay_key_secret','value' => '',  'group' => 'payment'],
            ['key' => 'cod_enabled',       'value' => '1',  'group' => 'payment'],
            ['key' => 'wallet_enabled',    'value' => '0',  'group' => 'payment'],

            // Social
            ['key' => 'facebook_url',   'value' => '', 'group' => 'social'],
            ['key' => 'instagram_url',  'value' => '', 'group' => 'social'],
            ['key' => 'youtube_url',    'value' => '', 'group' => 'social'],
            ['key' => 'twitter_url',    'value' => '', 'group' => 'social'],

            // SEO
            ['key' => 'meta_title',       'value' => 'Beauty Shop',           'group' => 'seo'],
            ['key' => 'meta_description', 'value' => 'Best beauty products',  'group' => 'seo'],
            ['key' => 'meta_keywords',    'value' => 'beauty, cosmetics',     'group' => 'seo'],
            ['key' => 'google_analytics', 'value' => '',                      'group' => 'seo'],

            // Email
            ['key' => 'smtp_host',       'value' => '',        'group' => 'email'],
            ['key' => 'smtp_port',       'value' => '587',     'group' => 'email'],
            ['key' => 'smtp_username',   'value' => '',        'group' => 'email'],
            ['key' => 'smtp_password',   'value' => '',        'group' => 'email'],
            ['key' => 'smtp_encryption', 'value' => 'tls',    'group' => 'email'],
            ['key' => 'mail_from_name',  'value' => 'Beauty Shop', 'group' => 'email'],
            ['key' => 'mail_from_email', 'value' => '',        'group' => 'email'],
        ];

        foreach ($settings as $s) {
            Setting::updateOrCreate(['key' => $s['key']], $s);
        }

        $this->command->info('✅ Settings seeded!');
    }
}