<?php

use App\Http\Livewire\Auth\Forgot;
use App\Http\Livewire\Auth\Login;
use App\Http\Livewire\Auth\OtpVerification;
use App\Http\Livewire\Auth\Reset;
use App\Http\Livewire\User\UserDashboard;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group([
    'prefix' => '/'
], function () {
    Route::get('login', Login::class)->name('login');
    Route::get('forgot', Forgot::class)->name('forgot');
    Route::get('reset/{token}', Reset::class)->name('reset');
    Route::get('otp', OtpVerification::class)->name('otp.verification');

    // Do only process that needs authentication here
    Route::group([
        'middleware' => ['auth']
    ], function () {
        Route::get('/', UserDashboard::class)->name('home');
    });
});
