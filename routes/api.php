<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DocumentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::post('login', [AuthController::class, 'login']);
Route::prefix('document')->controller(DocumentController::class)->group(function () {
    Route::get('/', 'get');
    Route::get('/{id}', 'show');
    Route::get('/arvhives', 'getArchives');
    Route::post("/create", 'store');
    Route::post('clone/{document}', 'clone');
    Route::put('update/{document}', 'update');
    Route::delete('delete/{document}', 'destoy');
    Route::delete('suppr-definitive/{id}', 'deleteForce');
});