<?php

use App\Http\Controllers\TestController;
use App\Models\Specialization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('test', [TestController::class, 'getCoursesByStudyYear']);