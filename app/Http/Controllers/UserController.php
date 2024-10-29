<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class UserController extends Controller
{
    // متد ارسال کد OTP
    public function sendOtp(Request $request)
    {
        $validatedData = $request->validate([
            'phone' => 'required|string|exists:users,phone',
        ]);

        // تولید کد OTP تصادفی
        $otp = rand(1000, 9999);

        // به‌روزرسانی کد OTP برای کاربر
        $user = User::where('phone', $validatedData['phone'])->first();
        $user->otp = $otp;
        $user->save();

        // ارسال پیامک OTP با استفاده از GuzzleHTTP
        $client = new Client();
        $response = $client->post(env('FARAZ_SMS_API_URL'), [
            'form_params' => [
                'api_key' => env('FARAZ_SMS_API_KEY'),
                'sender' => env('FARAZ_SMS_SENDER_NUMBER'),
                'receptor' => $user->phone,
                'message' => "Your OTP code is: $otp",
            ]
        ]);

        // بررسی نتیجه ارسال پیامک
        if ($response->getStatusCode() == 200) {
            return response()->json(['message' => 'OTP sent successfully'], 200);
        } else {
            return response()->json(['message' => 'Failed to send OTP'], 500);
        }
    }
}
