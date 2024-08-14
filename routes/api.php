<?php

use App\Http\Controllers\UrlShorteningController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('decode', [UrlShorteningController::class, 'decode'])->name('decode');
Route::post('encode', [UrlShorteningController::class, 'encode'])->name('encode');
