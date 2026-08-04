<?php

use App\Http\Controllers\AnalysisController;
use App\Http\Controllers\ChapterController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ChapterController::class, 'dashboard'])->name('dashboard');

// Chapters management
Route::get('/chapters', [ChapterController::class, 'index'])->name('chapters.index');
Route::get('/chapters/create', [ChapterController::class, 'create'])->name('chapters.create');
Route::post('/chapters', [ChapterController::class, 'store'])->name('chapters.store');
Route::get('/chapters/{chapter}', [ChapterController::class, 'show'])->name('chapters.show');
Route::delete('/chapters/{chapter}', [ChapterController::class, 'destroy'])->name('chapters.destroy');

// Analysis trigger
Route::post('/chapters/{chapter}/analyze', [AnalysisController::class, 'analyze'])->name('chapters.analyze');
Route::get('/chapters/{chapter}/results', [AnalysisController::class, 'results'])->name('analysis.results');
