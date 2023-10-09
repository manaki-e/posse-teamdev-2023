<?php

use App\Http\Controllers\Admin\AdminIndexController;
use App\Http\Controllers\Admin\AdminItemController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\EventController;
use App\Http\Controllers\User\ItemController;
use App\Http\Controllers\User\MyPageController;
use App\Http\Controllers\User\PointExchangeController;
use App\Http\Controllers\User\RequestController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;

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
    return Redirect::to('/login');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('/items', ItemController::class);
    Route::post('/items/{item}/borrow', [ItemController::class, 'borrow'])->name('items.borrow');
    Route::post('/items/{item}/cancel', [ItemController::class, 'cancel'])->name('items.cancel');
    Route::post('/items/{item}/return', [ItemController::class, 'return'])->name('items.return');
    Route::post('/items/{item}/receive', [ItemController::class, 'receive'])->name('items.receive');
    Route::get('/items/create/{chosen_request_id}', [ItemController::class, 'createWithRequest'])->name('items.create-with-request');
    Route::post('/items/{item}/like', [ItemController::class, 'like'])->name('items.like');
    Route::post('/items/{item}/unlike', [ItemController::class, 'unlike'])->name('items.unlike');

    Route::resource('/events', EventController::class);
    Route::post('/events/{event}/held', [EventController::class, 'held'])->name('events.held');
    Route::post('/events/{event}/participate', [EventController::class, 'participate'])->name('events.participate');
    Route::post('/events/{event}/cancel', [EventController::class, 'cancel'])->name('events.cancel');
    Route::get('/events/create/{chosen_request_id}', [EventController::class, 'createWithRequest'])->name('events.create-with-request');
    Route::post('/events/{event}/like', [EventController::class, 'like'])->name('events.like');
    Route::post('/events/{event}/unlike', [EventController::class, 'unlike'])->name('events.unlike');

    Route::resource('/requests', RequestController::class);
    Route::post('/requests/{request}/resolve', [RequestController::class, 'resolve'])->name('requests.resolve');
    Route::post('/requests/{request}/like', [RequestController::class, 'like'])->name('requests.like');
    Route::post('/requests/{request}/unlike', [RequestController::class, 'unlike'])->name('requests.unlike');

    Route::resource('/point-exchange', PointExchangeController::class);
    Route::put('/point-exchanges/{id}', [PointExchangeController::class, 'updateApproved'])->name('point-exchanges.update-approved');

    Route::group(['prefix' => 'mypage', 'as' => 'mypage.'], function () {
        Route::get('/items', [MyPageController::class, 'items'])->name('items');
        Route::get('/deals', [MyPageController::class, 'deals'])->name('deals');
        Route::get('/requests', [MyPageController::class, 'requests'])->name('requests');
        Route::get('/points', [MyPageController::class, 'points'])->name('points');
        Route::get('/profile', [MyPageController::class, 'profile'])->name('profile');
        Route::get('/account', [MyPageController::class, 'account'])->name('account');
        Route::get('/point/history', [MyPageController::class, 'pointHistory'])->name('point.history');
        Route::get('/items/listed', [MyPageController::class, 'itemsListed'])->name('items.listed');
        Route::get('/items/borrowed', [MyPageController::class, 'itemsBorrowed'])->name('items.borrowed');
        Route::get('/items/history', [MyPageController::class, 'itemsHistory'])->name('items.history');
        Route::get('/items/liked', [MyPageController::class, 'itemsLiked'])->name('items.liked');
        Route::get('/events/organized', [MyPageController::class, 'eventsOrganized'])->name('events.organized');
        Route::get('/events/joined', [MyPageController::class, 'eventsJoined'])->name('events.joined');
        Route::get('/events/liked', [MyPageController::class, 'eventsLiked'])->name('events.liked');
        Route::get('/requests/posted', [MyPageController::class, 'requestsPosted'])->name('requests.posted');
        Route::get('/requests/liked', [MyPageController::class, 'requestsLiked'])->name('requests.liked');
    });

    Route::get('/users/{user_id}', [MyPageController::class, 'userProfile'])->name('users.profile');

    Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'check.admin'], function () {
        Route::get('/histories', [AdminIndexController::class, 'histories'])->name('histories');
        Route::get('/point-exchanges', [AdminIndexController::class, 'pointExchanges'])->name('point-exchanges');
        Route::resource('/users', AdminUserController::class);
        Route::resource('/items', AdminItemController::class);
    });
});

Route::fallback(function () {
    if (auth()->check()) {
        return redirect('/items');
    } else {
        return redirect('/login');
    }
});

require __DIR__ . '/auth.php';
