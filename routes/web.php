<?php

use App\Http\Livewire\Auth\Forgot;
use App\Http\Livewire\Auth\GoogleAuth;
use App\Http\Livewire\Auth\Login;
use App\Http\Livewire\Auth\OtpVerification;
use App\Http\Livewire\Auth\Reset;
use App\Http\Livewire\User\Account\CountrySetting;
use App\Http\Livewire\User\Account\Credentials;
use App\Http\Livewire\User\Account\Profile;
use App\Http\Livewire\User\Account\RoleSetting;
use App\Http\Livewire\User\AdManagement\AddAd;
use App\Http\Livewire\User\AdManagement\EditAd;
use App\Http\Livewire\User\AdManagement\ListAds;
use App\Http\Livewire\User\Careers\AddCareer;
use App\Http\Livewire\User\Careers\EditCareer;
use App\Http\Livewire\User\Careers\ListCareers;
use App\Http\Livewire\User\Coverage\AddCoverage;
use App\Http\Livewire\User\Coverage\EditCoverage;
use App\Http\Livewire\User\Coverage\ListCoverages;
use App\Http\Livewire\User\UserDashboard;
use App\Http\Livewire\User\UserManagement\AddUser;
use App\Http\Livewire\User\UserManagement\EditUser;
use App\Http\Livewire\User\UserManagement\ListUsers;
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
], static function () {
    Route::get('login', Login::class)->name('login');
    Route::get('forgot', Forgot::class)->name('forgot');
    Route::get('reset/{token}', Reset::class)->name('reset');
    Route::get('otp', OtpVerification::class)->name('otp.verification');

    // Google authentication
    Route::group([
        'prefix' => 'google'
    ], static function () {
        Route::get('callback', GoogleAuth::class)->name('google.authentication');
    });

    // Do only process that needs authentication here
    Route::group([
        'middleware' => ['auth', 'otpPass']
    ], static function () {
        Route::get('/', UserDashboard::class)->name('home');

        Route::group([
            'prefix' => 'account'
        ], static function () {
            Route::get('/', Profile::class)->name('profile');
            Route::get('credentials', Credentials::class)->name('credentials');
            Route::group([
                'prefix' => 'settings'
            ], static function () {
                Route::get('country', CountrySetting::class)->name('country.settings');
                Route::get('roles', RoleSetting::class)->name('role.settings');
            });
        });

        Route::group([
            'prefix' => 'users'
        ], static function () {
            Route::get('add', AddUser::class)->name('add.user');
            Route::get('edit/{slug}', EditUser::class)->name('edit.user');
            Route::get('/', ListUsers::class)->name('list.users');
        });

        Route::group([
            'prefix' => 'ads'
        ], static function () {
            Route::get('add', AddAd::class)->name('add.ad');
            Route::get('edit/{slug}', EditAd::class)->name('edit.ad');
            Route::get('/', ListAds::class)->name('list.ads');
        });

        Route::group([
            'prefix' => 'careers'
        ], static function () {
            Route::get('add', AddCareer::class)->name('add.career');
            Route::get('edit/{slug}', EditCareer::class)->name('edit.career');
            Route::get('/', ListCareers::class)->name('list.careers');
        });

        Route::group([
            'prefix' => 'coverages'
        ], static function () {
            Route::get('add', AddCoverage::class)->name('add.coverage');
            Route::get('edit/{slug}', EditCoverage::class)->name('edit.coverage');
            Route::get('/', ListCoverages::class)->name('list.coverages');
        });
    });
});
