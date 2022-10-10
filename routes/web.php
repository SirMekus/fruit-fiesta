<?php

use App\Http\Controllers\Backstage\CampaignsController;
use App\Http\Controllers\Backstage\DashboardController;
use App\Http\Controllers\Backstage\GameController;
use App\Http\Controllers\Backstage\PrizeController;
use App\Http\Controllers\Backstage\UserController;
use App\Http\Controllers\Backstage\SymbolController;
use App\Http\Controllers\FrontendController;
use Illuminate\Support\Facades\Route;

Route::get('matrix', [GameController::class, 'test']);

Route::prefix('backstage')->name('backstage.')->middleware(['auth', 'setActiveCampaign'])->group(function () {

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Campaigns
    Route::get('campaigns/{campaign}/use', [CampaignsController::class, 'use'])->name('campaigns.use');
    Route::resource('campaigns', CampaignsController::class);

    //Symbols
    Route::get('symbols', App\Http\Livewire\Backstage\SymbolTable::class)->name('symbols');
    Route::post('symbols', [SymbolController::class, 'Submit'])->name('symbols.post');

    Route::group(['middleware' => ['redirectIfNoActiveCampaign']], function () {
        Route::resource('games', GameController::class);
        Route::resource('prizes', PrizeController::class);

        Route::get('generate-matrix', [GameController::class, 'generateMatrix'])->middleware('daily-spins');
        Route::get('export-as-csv', [GameController::class, 'exportAsCsv'])->name('csv_export');
    });

    // Users
    Route::resource('users', UserController::class);
});

// Route::prefix('backstage')->middleware('setActiveCampaign')->group(function () {
//     // Account activation
//     Route::get('activate/{ott}', 'Auth\ActivateAccountController@index')->name('backstage.activate.show');
//     Route::put('activate/{ott}', 'Auth\ActivateAccountController@update')->name('backstage.activate.update');
// });

Route::get('{campaign:slug}', [FrontendController::class, 'loadCampaign'])->middleware(['auth', 'symbol-checker', 'verify-campaign', 'daily-spins']);
Route::get('/', [FrontendController::class, 'placeholder']);
