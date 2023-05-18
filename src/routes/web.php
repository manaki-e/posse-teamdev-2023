<?php

use App\Http\Controllers\Admin\AdminIndexController;
use App\Http\Controllers\Admin\AdminItemController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\ItemController;
use App\Http\Controllers\User\MyPageController;
use App\Http\Controllers\User\PointExchangeController;
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
    Route::post('/items/{item}/borrow', [ItemController::class, 'borrow'])->name('items.borrow');
    Route::post('/items/{item}/cancel', [ItemController::class, 'cancel'])->name('items.cancel');
    Route::post('/items/{item}/return', [ItemController::class, 'return'])->name('items.return');
    Route::post('/items/{item}/receive', [ItemController::class, 'receive'])->name('items.receive');
    Route::resource('/point-exchange', PointExchangeController::class);

    Route::put('/point-exchanges/{id}', [PointExchangeController::class, 'updateApproved'])->name('point-exchanges.update-approved');

    Route::group(['prefix' => 'mypage', 'as' => 'mypage.'], function () {
        Route::get('/items', [MyPageController::class, 'items'])->name('items');
        Route::get('/deals', [MyPageController::class, 'deals'])->name('deals');
        Route::get('/requests', [MyPageController::class, 'requests'])->name('requests');
        Route::get('/points', [MyPageController::class, 'points'])->name('points');
        Route::get('/point/history', [MyPageController::class, 'pointHistory'])->name('point.history');
        Route::get('/profile', [MyPageController::class, 'profile'])->name('profile');
        Route::get('/events/organized', [MyPageController::class, 'eventsOrganized'])->name('events.organized');
        Route::get('/events/joined', [MyPageController::class, 'eventsJoined'])->name('events.joined');
    });

    Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'check.admin'], function () {
        Route::get('/dashboard', [AdminIndexController::class, 'index'])->name('dashboard');
        Route::get('/histories', [AdminIndexController::class, 'histories'])->name('histories');
        Route::get('/point-exchanges', [AdminIndexController::class, 'pointExchanges'])->name('point-exchanges');
        Route::resource('/users', AdminUserController::class);
        Route::resource('/items', AdminItemController::class);
    });
});

require __DIR__ . '/auth.php';
