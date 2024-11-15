<?php

use App\Http\Controllers\CampaignController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CampaignController::class, 'index'])->name('home');
Route::get('/campaigns/{campaign}/{type?}', [CampaignController::class, 'show'])->name('campaign');
Route::get('/campaigns/{campaign}/publishers', [CampaignController::class, 'publishers'])->name('publishers');
