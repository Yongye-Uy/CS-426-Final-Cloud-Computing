<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\Admin\CampaignController as AdminCampaignController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

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

// Admin Protected Routes
Route::middleware(['auth', 'verified', 'admin'])->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    
    // Admin Donation Management
    Route::post('/admin/donations/cleanup', [DonationController::class, 'cleanupAbandonedDonations'])->name('admin.donations.cleanup');
    
    // Admin Campaign Management
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/campaigns', [AdminCampaignController::class, 'index'])->name('campaigns.index');
        Route::get('/campaigns/{campaign}', [AdminCampaignController::class, 'show'])->name('campaigns.show');
        Route::post('/campaigns/{campaign}/approve', [AdminCampaignController::class, 'approve'])->name('campaigns.approve');
        Route::get('/campaigns/{campaign}/reject', [AdminCampaignController::class, 'rejectForm'])->name('campaigns.reject-form');
        Route::post('/campaigns/{campaign}/reject', [AdminCampaignController::class, 'reject'])->name('campaigns.reject');
        Route::patch('/campaigns/{campaign}/status', [AdminCampaignController::class, 'updateStatus'])->name('campaigns.update-status');
        Route::delete('/campaigns/{campaign}', [AdminCampaignController::class, 'destroy'])->name('campaigns.destroy');
        Route::post('/campaigns/bulk-action', [AdminCampaignController::class, 'bulkAction'])->name('campaigns.bulk-action');
        
        // Admin User Management
        Route::get('/users/{user}', [\App\Http\Controllers\Admin\UserController::class, 'show'])->name('users.show');
        Route::get('/users/{user}/edit', [\App\Http\Controllers\Admin\UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [\App\Http\Controllers\Admin\UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [\App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('users.destroy');
        
        // Admin Testimonials Management
        Route::resource('testimonials', \App\Http\Controllers\Admin\TestimonialController::class);
        
        // Admin Settings Management
        Route::get('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
        Route::post('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');
        Route::post('/settings/initialize', [\App\Http\Controllers\Admin\SettingController::class, 'initializeDefaults'])->name('settings.initialize');
        Route::get('/settings/api', [\App\Http\Controllers\Admin\SettingController::class, 'getSettings'])->name('settings.api');
    });
});
