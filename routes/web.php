<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BloodDonationController;
use App\Http\Controllers\BloodRequestController;
use App\Http\Controllers\DonorController;
use App\Http\Controllers\Admin\BloodDonationController as AdminBloodDonationController;
use App\Http\Controllers\Admin\DonorController as AdminDonorController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\LoginController as AdminLoginController;

/* pages */
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/about', function () {
    return view('pages.about');
})->name('about');

Route::get('/contact', function () {
    return view('pages.contact');
})->name('contact');

Route::get('/donors', [DonorController::class, 'index'])->name('donors');

Route::get('/be-a-donor', function () {
    return view('pages.be-a-donor');
})->name('be-a-donor');

/* request blood */
Route::get('/request-blood', [BloodRequestController::class, 'create'])->name('blood-request.create');
Route::post('/request-blood', [BloodRequestController::class, 'store'])->name('blood-request.store');
Route::get('/blood-request/{bloodRequest}/matches', [BloodRequestController::class, 'findMatches'])->name('blood-request.matches');

/* admin authentication */
Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminLoginController::class, 'login']);
Route::post('/admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

Route::middleware('auth:admin')->group(function () {
    Route::get('/admin/dashboard', function () {
        $totalDonors = \App\Models\User::count();
        $totalDonations = \App\Models\BloodDonation::count();
        $pendingDonations = \App\Models\BloodDonation::where('status', 'pending')->count();
        $completedDonations = \App\Models\BloodDonation::where('status', 'completed')->count();
        $totalUnits = \App\Models\BloodDonation::where('status', 'completed')->sum('units');
        
        return view('admin.dashboard', compact('totalDonors', 'totalDonations', 'pendingDonations', 'completedDonations', 'totalUnits'));
    })->name('admin.dashboard');
    
    Route::get('/admin/donors', [AdminDonorController::class, 'index'])->name('admin.donors.index');
    Route::get('/admin/donations', [AdminBloodDonationController::class, 'index'])->name('admin.donations.index');
    Route::patch('/admin/donations/{donation}/status', [AdminBloodDonationController::class, 'updateStatus'])->name('admin.donations.update-status');
});

/* donor user dashboard and authenticated pages */
Route::get('/dashboard', function () {
    return view('dashboard');
})
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::get('/my-donations', [BloodDonationController::class, 'index'])->name('user.donations');
    Route::post('/blood-donations', [BloodDonationController::class, 'store'])->name('blood-donations.store');
    Route::delete('/blood-donations/{bloodDonation}', [BloodDonationController::class, 'destroy'])->name('blood-donations.destroy');
});

require __DIR__ . '/auth.php';
