<?php

use App\Http\Controllers\API\AdController;
use App\Http\Controllers\API\CareerController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\CommentController;
use App\Http\Controllers\API\ContactController;
use App\Http\Controllers\API\CountryController;
use App\Http\Controllers\API\CoverageController;
use App\Http\Controllers\API\EventController;
use App\Http\Controllers\API\FaqController;
use App\Http\Controllers\API\OfficeController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\PartnerController;
use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\SlideController;
use App\Http\Controllers\API\SubCategoryController;
use App\Http\Controllers\API\SubscriberController;
use App\Http\Controllers\API\TeamController;
use App\Http\Controllers\API\TenderController;
use Illuminate\Support\Facades\Route;
use Rap2hpoutre\LaravelLogViewer\LogViewerController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'prefix' => 'v1',
], static function () {
    // open routes - loads all the api resources
    Route::apiResources([
        'countries' => CountryController::class,
        'categories' => CategoryController::class,
        'sub-categories' => SubCategoryController::class,
    ]);

    // get
    Route::get('ads/{countryId?}/{limit?}', AdController::class);
    Route::get('careers/{countryId?}/{limit?}', CareerController::class);
    Route::get('coverages/{countryId?}/{limit?}', CoverageController::class);
    Route::get('events/{countryId?}/{limit?}', EventController::class);
    Route::get('faqs/{countryId?}/{limit?}', FaqController::class);
    Route::get('offices/{countryId?}/{limit?}', OfficeController::class);
    Route::get('partners/{countryId?}/{limit?}', PartnerController::class);
    Route::get('posts/{countryId?}/{limit?}', PostController::class);
    Route::get('products/{countryId?}/{limit?}', ProductController::class);
    Route::get('slides/{countryId?}/{limit?}', SlideController::class);
    Route::get('teams/{countryId?}/{limit?}', TeamController::class);
    Route::get('tenders/{countryId?}/{limit?}', TenderController::class);

    // post
    Route::post('order', OrderController::class);
    Route::post('subscriber', SubscriberController::class);
    Route::post('contact', ContactController::class);
    Route::post('comment', CommentController::class);

    // protected routes
    Route::group([
        'middleware' => ['auth:api']
    ], static function () {
        // ! logic that needs authentication
    });
});

Route::get('logs', [LogViewerController::class, 'index']);

