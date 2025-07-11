<?php

namespace App\Services;

use App\Mail\SendEmailOtp;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class OtpService
{
    public static function generateOtp(string $email, string $context): string
    {
        $otp = rand(100000, 999999);

        // 2 ways
        // first is making a db table and saving OTPs to it
        // second is caching
        Cache::put('otp_' . $context . '_' . $email, $otp, 300);
        
        // Log the OTP for debugging
        Log::info("Generated OTP for {$email}: {$otp}");
        
        // Send email
        try {
            Mail::to($email)->send(new SendEmailOtp($otp));
            Log::info("OTP email sent to {$email}");
        } catch (\Exception $e) {
            Log::error("Failed to send OTP email: " . $e->getMessage());
        }

        return $otp;
    }

    public static function verifyOtp(string $email, string $context, string $inputOtp): bool
    {
        $cachedOtp = Cache::get("otp_{$context}_{$email}");

        if ($cachedOtp && $cachedOtp == $inputOtp) {
            Cache::forget("otp_{$context}_{$email}");
            return true;
        }

        return false;
    }

    public static function clearOtp(string $email, string $context): void
    {
        // if cache
        Cache::forget("otp_{$context}_{$email}");
        // if db (maybe later)
    }
}
