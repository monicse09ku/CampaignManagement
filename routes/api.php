<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Campaigns\CampaignController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::middleware('auth:api')
    ->namespace('Api')
    ->group(function () {
        
        Route::get('/campaigns', [CampaignController::class, 'campaigns'])->name('campaigns');
        Route::get('/campaign/{id}', [CampaignController::class, 'getCampaign'])->name('getCampaign');
        Route::post('/create-campaign', [CampaignController::class, 'createCampaign'])->name('create-campaign');
        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    });
