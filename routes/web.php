<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', [\App\Http\Controllers\DonationController::class, 'index'])->name('index');

Route::get('donor/appointments', function () {
    return view('appointments');
})->middleware(['auth', 'verified'])->name('appointments');


Route::middleware(['auth','verified'])->group(function (){
    Route::controller(\App\Http\Controllers\DonationController::class)->group(function () {
        Route::post('donor/donation/test', 'donationTest')->name('printDonation');
        Route::get('/donor/donations', 'getDonations')->name('prevdonation');
        Route::get('/donate','donate')->name('donation');
    });
    Route::get('donor/profile',function (){
        return view('editProfile');
    })->name('profile');
});




Auth::routes(['verify' => true]);

