<?php

use App\Http\Controllers\Admin\AdminIndexController;
use App\Http\Controllers\Admin\AdminItemController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\ItemController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('/items', ItemController::class);
    Route::post('/items/{id}/borrow',[ItemController::class, 'borrow'])->name('items.borrow');
    Route::post('/items/{id}/cancel',[ItemController::class, 'cancel'])->name('items.cancel');
    Route::post('/items/{id}/return',[ItemController::class, 'return'])->name('items.return');
    Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'check.admin'], function () {
        Route::get('/dashboard', [AdminIndexController::class, 'index'])->name('dashboard');
        Route::get('/histories', [AdminIndexController::class, 'histories'])->name('histories');
        Route::get('/point-exchanges', [AdminIndexController::class, 'pointExchanges'])->name('point-exchanges');
        Route::resource('/users', AdminUserController::class);
        Route::resource('/items', AdminItemController::class);
    });
});

require __DIR__ . '/auth.php';