<?php

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

Route::resource('swagger/writers', App\Http\Controllers\Swagger\WriterController::class);
Route::get('test/writers', [App\Http\Controllers\Test\WriterControllerViews::class, 'index']);

Route::delete('test/writers/{writer}', [App\Http\Controllers\Swagger\WriterController::class, 'destroy'])->middleware([ 'auth:sanctum','role:admin']);
