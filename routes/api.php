<?php

use App\Http\Controllers\API\CountryController;
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
        'countries' => CountryController::class
    ]);

    // protected routes
    Route::group([
        'middleware' => ['auth:api']
    ], static function () {
        // ! logic that needs authentication
    });
});

Route::get('logs', [LogViewerController::class, 'index']);

