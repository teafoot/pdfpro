<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PdfController;
use App\Http\Controllers\OllamaController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user/uploads', [PdfController::class, 'index']);
    Route::post('/user/uploads', [PdfController::class, 'upload']);
    Route::post('/user/uploads/split', [PdfController::class, 'split']);

    Route::post('/ollama/chat', [OllamaController::class, 'sendChatMessage']);
// });