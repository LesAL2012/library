<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', App\Http\Controllers\HomeController::class)->name('home');

Route::get('/packages', App\Http\Controllers\PackageController::class)->name('packages');

Route::resource('/books', App\Http\Controllers\BookController::class);


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::resource('/books', App\Http\Controllers\BookController::class, ['only' => ['create', 'store', 'edit', 'update']])
        ->middleware(['role:admin|moderator']);

    Route::resource('/books', App\Http\Controllers\BookController::class, ['only' => ['destroy']])
        ->middleware(['permission:books-delete']);

    Route::post('/{book_id}/like', App\Http\Controllers\LikeStoreController::class)->name('like.store');
    Route::get('/settings', App\Http\Controllers\SettingsController::class)->name('settings');

    Route::group(['prefix' => 'settings'], function () {
        Route::resources(
            [
                '/writers' => App\Http\Controllers\WriterController::class,
                '/categories' => App\Http\Controllers\CategoryController::class,
                '/tags' => App\Http\Controllers\TagController::class,
                '/genres' => App\Http\Controllers\GenreController::class,
                '/type_genres' => App\Http\Controllers\TypeGenreController::class,
            ],
            [
                'only' => ['index']
            ]
        );

        Route::group(['middleware' => ['role:admin|moderator']], function () {
            Route::resources(
                [
                    '/writers' => App\Http\Controllers\WriterController::class,
                    '/categories' => App\Http\Controllers\CategoryController::class,
                    '/tags' => App\Http\Controllers\TagController::class,
                    '/genres' => App\Http\Controllers\GenreController::class,
                    '/type_genres' => App\Http\Controllers\TypeGenreController::class,
                ],
                [
                    'only' => ['store', 'update', 'destroy']
                ]
            );
        });
    });
});

Route::get('/auth/{provider}/redirect', [App\Http\Controllers\Auth\ProviderController::class, 'redirect'])->where('provider', 'github|google');
Route::get('/auth/{provider}/callback', [App\Http\Controllers\Auth\ProviderController::class, 'callback'])->where('provider', 'github|google');

