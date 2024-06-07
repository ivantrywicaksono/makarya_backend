<?php

use App\Http\Controllers\PublicationController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PengajuanController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResources([
    'publication' => PublicationController::class,
    'event' => EventController::class,
    'pengajuan' => PengajuanController::class,
]);
