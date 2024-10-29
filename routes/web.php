<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// مسیر برای ارسال کد OTP
Route::post('/send-otp', [UserController::class, 'sendOtp']);
