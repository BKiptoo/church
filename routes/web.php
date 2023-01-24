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
use App\Http\Livewire\User\Blogs\AddPost;
use App\Http\Livewire\User\Blogs\EditPost;
use App\Http\Livewire\User\Blogs\ListPosts;
use App\Http\Livewire\User\Careers\AddCareer;
use App\Http\Livewire\User\Careers\EditCareer;
use App\Http\Livewire\User\Careers\ListCareers;
use App\Http\Livewire\User\Category\AddCategory;
use App\Http\Livewire\User\Category\EditCategory;
use App\Http\Livewire\User\Category\ListCategories;
use App\Http\Livewire\User\Contact\ListContacts;
use App\Http\Livewire\User\Coverage\AddCoverage;
use App\Http\Livewire\User\Coverage\EditCoverage;
use App\Http\Livewire\User\Coverage\ListCoverages;
use App\Http\Livewire\User\Events\AddEvent;
use App\Http\Livewire\User\Events\EditEvent;
use App\Http\Livewire\User\Events\ListEvents;
use App\Http\Livewire\User\Faqs\AddFaq;
use App\Http\Livewire\User\Faqs\EditFaq;
use App\Http\Livewire\User\Faqs\ListFaqs;
use App\Http\Livewire\User\ListMedia;
use App\Http\Livewire\User\Office\AddOffice;
use App\Http\Livewire\User\Office\EditOffice;
use App\Http\Livewire\User\Office\ListOffices;
use App\Http\Livewire\User\Orders\ListOrders;
use App\Http\Livewire\User\Products\AddProduct;
use App\Http\Livewire\User\Products\EditProduct;
use App\Http\Livewire\User\Products\ListProducts;
use App\Http\Livewire\User\Slider\AddSlide;
use App\Http\Livewire\User\Slider\EditSlide;
use App\Http\Livewire\User\Slider\ListSlides;
use App\Http\Livewire\User\SubCategory\AddSubCategory;
use App\Http\Livewire\User\SubCategory\EditSubCategory;
use App\Http\Livewire\User\SubCategory\ListSubCategories;
use App\Http\Livewire\User\Subscriber\ListSubscribers;
use App\Http\Livewire\User\Team\AddTeam;
use App\Http\Livewire\User\Team\EditTeam;
use App\Http\Livewire\User\Team\ListTeams;
use App\Http\Livewire\User\Tender\AddTenders;
use App\Http\Livewire\User\Tender\EditTenders;
use App\Http\Livewire\User\Tender\ListTenders;
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

        Route::group([
            'prefix' => 'events'
        ], static function () {
            Route::get('add', AddEvent::class)->name('add.event');
            Route::get('edit/{slug}', EditEvent::class)->name('edit.event');
            Route::get('/', ListEvents::class)->name('list.events');
        });

        Route::group([
            'prefix' => 'faqs'
        ], static function () {
            Route::get('add', AddFaq::class)->name('add.faq');
            Route::get('edit/{id}', EditFaq::class)->name('edit.faq');
            Route::get('/', ListFaqs::class)->name('list.faqs');
        });

        Route::group([
            'prefix' => 'offices'
        ], static function () {
            Route::get('add', AddOffice::class)->name('add.office');
            Route::get('edit/{slug}', EditOffice::class)->name('edit.office');
            Route::get('/', ListOffices::class)->name('list.offices');
        });

        Route::group([
            'prefix' => 'categories'
        ], static function () {
            Route::get('add', AddCategory::class)->name('add.category');
            Route::get('edit/{slug}', EditCategory::class)->name('edit.category');
            Route::get('/', ListCategories::class)->name('list.categories');
        });

        Route::group([
            'prefix' => 'sub-categories'
        ], static function () {
            Route::get('add', AddSubCategory::class)->name('add.sub.category');
            Route::get('edit/{slug}', EditSubCategory::class)->name('edit.sub.category');
            Route::get('/', ListSubCategories::class)->name('list.sub.categories');
        });

        Route::group([
            'prefix' => 'products'
        ], static function () {
            Route::get('add', AddProduct::class)->name('add.product');
            Route::get('edit/{slug}', EditProduct::class)->name('edit.product');
            Route::get('/', ListProducts::class)->name('list.products');
        });

        Route::group([
            'prefix' => 'blogs'
        ], static function () {
            Route::get('add', AddPost::class)->name('add.post');
            Route::get('edit/{slug}', EditPost::class)->name('edit.post');
            Route::get('/', ListPosts::class)->name('list.posts');
        });

        Route::group([
            'prefix' => 'orders'
        ], static function () {
            Route::get('/', ListOrders::class)->name('list.orders');
        });

        Route::group([
            'prefix' => 'contacts'
        ], static function () {
            Route::get('/', ListContacts::class)->name('list.contacts');
        });

        Route::group([
            'prefix' => 'subscribers'
        ], static function () {
            Route::get('/', ListSubscribers::class)->name('list.subscribers');
        });

        Route::group([
            'prefix' => 'media'
        ], static function () {
            Route::get('/', ListMedia::class)->name('list.media');
        });

        Route::group([
            'prefix' => 'slides'
        ], static function () {
            Route::get('add', AddSlide::class)->name('add.slide');
            Route::get('edit/{slug}', EditSlide::class)->name('edit.slide');
            Route::get('/', ListSlides::class)->name('list.slides');
        });

        Route::group([
            'prefix' => 'teams'
        ], static function () {
            Route::get('add', AddTeam::class)->name('add.team');
            Route::get('edit/{slug}', EditTeam::class)->name('edit.team');
            Route::get('/', ListTeams::class)->name('list.teams');
        });

        Route::group([
            'prefix' => 'tenders'
        ], static function () {
            Route::get('add', AddTenders::class)->name('add.tender');
            Route::get('edit/{slug}', EditTenders::class)->name('edit.tender');
            Route::get('/', ListTenders::class)->name('list.tenders');
        });
    });
});
