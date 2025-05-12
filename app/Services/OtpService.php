<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class OtpService
{
    public static function generateOtp(string $phoneNumber, string $context): string
    {
        $otp = rand(100000, 999999);

        // 2 ways 
        // first is making a db table and saving OTPs to it
        // second is caching
        Cache::put('otp_' . $context . '_' . $phoneNumber, $otp, 300);
        // Here Add Real OTP sending functionality
        // like mtn or syriatel
        return $otp;
    }

    public static function verifyOtp(string $phone, string $context, string $inputOtp): bool
    {
        $cachedOtp = Cache::get("otp_{$context}_{$phone}");

        if ($cachedOtp && $cachedOtp == $inputOtp) {
            Cache::forget("otp_{$context}_{$phone}");
            return true;
        }

        return false;
    }

    public static function clearOtp(string $phoneNumber, string $context): void
    {
        // if cache
        Cache::forget("otp_{$context}_{$phoneNumber}");
        // if db (maybe later)
    }
}
