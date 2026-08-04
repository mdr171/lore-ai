<?php

use App\Http\Controllers\Api\LoreApiController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('/novels', [LoreApiController::class, 'novels']);
    Route::get('/novels/{id}/characters', [LoreApiController::class, 'characters']);
    Route::get('/novels/{id}/factions', [LoreApiController::class, 'factions']);
    Route::get('/novels/{id}/relationships', [LoreApiController::class, 'relationships']);
    Route::get('/chapters/{id}', [LoreApiController::class, 'chapterDetail']);
});
