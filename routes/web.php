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

<<<<<<< HEAD

Route::get('/', [\App\Http\Controllers\DonationController::class, 'index'])->name('index');

Route::get('/appointments', function () {
    return view('appointments');
})->middleware(['auth', 'verified'])->name('appointments');


Route::middleware(['auth','verified'])->group(function (){
    Route::controller(\App\Http\Controllers\DonationController::class)->group(function () {
        Route::post('donation/test', 'donationTest')->name('printDonation');
        Route::get('/prev/donation', 'getDonations')->name('prevdonation');
        Route::get('/donation','donate')->name('donation');
    });
    Route::get('donor/editProfile',function (){
        return view('editProfile');
    })->name('profile');
});


Auth::routes(['verify' => true]);

=======
Route::get('/', function () {
    return view('index');
});

Route::get('/index', function () {
    return view('index');
})->name('index');
Route::get('/donation', function () {
    return view('donation');
})->middleware(['auth', 'verified'])->name('donation');

Route::get('/appointments', function () {
    return view('appointments');
})->middleware(['auth', 'verified'])->name('appointments');



Auth::routes(['verify' => true]);

>>>>>>> origin/main
