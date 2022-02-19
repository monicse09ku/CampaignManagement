<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\CampaignController;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/campaigns', [CampaignController::class, 'index'])->name('campaigns');
Route::get('/create-campaign', [CampaignController::class, 'create'])->name('create-campaign');
Route::get('/campaigns/{id}/edit', [CampaignController::class, 'editCampaign'])->name('edit-campaign');
Route::get('/campaigns/{id}/delete', [CampaignController::class, 'deleteCampaign'])->name('delete-campaign');
Route::post('/save-campaign', [CampaignController::class, 'saveCampaign'])->name('save-campaign');
Route::post('/update-campaign', [CampaignController::class, 'updateCampaign'])->name('update-campaign');


