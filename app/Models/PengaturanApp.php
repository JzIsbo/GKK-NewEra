<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class PengaturanApp extends Model
{
    protected $fillable = ['key', 'value', 'tipe', 'label'];
    protected $table = 'pengaturan_apps';

    // Known setting keys constants
    public const KEY_NAMA_GEREJA    = 'nama_gereja';
    public const KEY_ALAMAT_GEREJA  = 'alamat_gereja';
    public const KEY_TELEPON_GEREJA = 'telepon_gereja';
    public const KEY_EMAIL_GEREJA   = 'email_gereja';
    public const KEY_NAMA_PENDETA   = 'nama_pendeta';
    public const KEY_QR_STATIS      = 'qr_statis_gereja';
    public const KEY_REKENING       = 'rekening_gereja';
    public const KEY_FACEBOOK_URL   = 'facebook_url';
    public const KEY_INSTAGRAM_URL  = 'instagram_url';
    public const KEY_YOUTUBE_URL    = 'youtube_url';
    public const KEY_TENTANG_GEREJA = 'tentang_gereja';

    public static function cacheKey(string $key): string
    {
        return "app_setting_{$key}";
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        return Cache::remember(self::cacheKey($key), 3600, function () use ($key, $default) {
            $setting = self::where('key', $key)->first();
            return $setting ? $setting->value : $default;
        });
    }

    public static function set(string $key, mixed $value): void
    {
        self::updateOrCreate(['key' => $key], ['value' => $value]);
        Cache::forget(self::cacheKey($key));
    }
}
