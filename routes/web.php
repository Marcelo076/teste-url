<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RedirectController;
use App\Http\Controllers\CreateController;
use App\Http\Controllers\inactiveController;


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



Route::get('/', [RedirectController::class, 'index'])->name('home');







Route::get('/r/{redirect}', [RedirectController::class, 'show'])->name('redirect');



Route::prefix('api')->group(function () {
    Route::resource('redirects', RedirectController::class)->except(['create', 'edit']);
    Route::get('redirects/{redirect}/stats', [RedirectController::class, 'stats'])->name('stats');
    Route::get('redirects/{redirect}/edit', [RedirectController::class, 'edit'])->name('edit');
    Route::get('redirects/{redirect}/logs', [RedirectController::class, 'logs'])->name('logs');
});


Route::get('redirects/create', function(){
    return view ('create');
})->name('redirects.create');


Route::post('/redirects', [CreateController::class, 'createRedirect'])->name('redirects.store');


Route::put('/redirects/{id}/update', [RedirectController::class, 'update'])->name('redirects.update');



Route::put('/redirects/{id}/desactivate', [inactiveController::class, 'desactivateRedirect'])->name('redirects.desactivate');
Route::put('/redirects/{id}/remove', [inactiveController::class, 'desactivateRedirect'])->name('remove');









