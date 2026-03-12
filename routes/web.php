<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

Route::get('/test-ip', function () {
    return request()->server('SERVER_ADDR');
});

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Campaigns Routes
Route::get('/campaigns', [CampaignController::class, 'index'])->name('campaigns.index');

// Donation Routes
Route::post('/donations', [DonationController::class, 'store'])->name('donations.store');
Route::post('/donations/process-credit-card', [DonationController::class, 'processCreditCard'])->name('donations.process-credit-card');

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Email Verification Routes
Route::get('/register/verify', [RegisterController::class, 'showVerificationForm'])->name('register.verify');
Route::post('/register/find-user', [RegisterController::class, 'findUserByEmail'])->name('register.find-user');
Route::post('/register/verify', [RegisterController::class, 'verify'])->name('register.verify.post');
Route::post('/register/resend', [RegisterController::class, 'resendCode'])->name('register.resend');

// User Protected Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', function () {
        return view('profile');
    })->name('profile');
    
    // User Campaign Management
    Route::get('/my-campaigns', [CampaignController::class, 'myCampaigns'])->name('campaigns.my-campaigns');
    Route::get('/campaigns/create', [CampaignController::class, 'create'])->name('campaigns.create');
    Route::post('/campaigns', [CampaignController::class, 'store'])->name('campaigns.store');
    Route::get('/campaigns/{campaign}/edit', [CampaignController::class, 'edit'])->name('campaigns.edit');
    Route::put('/campaigns/{campaign}', [CampaignController::class, 'update'])->name('campaigns.update');
    Route::delete('/campaigns/{campaign}', [CampaignController::class, 'destroy'])->name('campaigns.destroy');
});

// Campaign show route (must be after specific routes to avoid conflicts)
Route::get('/campaigns/{campaign}', [CampaignController::class, 'show'])->name('campaigns.show');

// Public API routes for settings
Route::prefix('api/settings')->group(function () {
    Route::get('/demo-video', function () {
        $settings = \App\Models\Setting::whereIn('key', ['demo_video_url', 'demo_video_title'])->get()->pluck('value', 'key');
        return response()->json($settings);
    });
    Route::get('/hero', function () {
        $settings = \App\Models\Setting::whereIn('key', ['hero_title', 'hero_subtitle', 'hero_background'])->get()->pluck('value', 'key');
        return response()->json($settings);
    });
});
