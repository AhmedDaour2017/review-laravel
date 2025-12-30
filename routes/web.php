<?php

use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserAuthController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*Route::get('/', function () {
    return view('welcome');
});*/



Route::prefix('cms')->group(function () {
    Route::get('/login', [UserAuthController::class, 'showLogin'])->name('cms.login');
    Route::post('/login', [UserAuthController::class, 'login']);
});

//Route::resource('tasks',TaskController::class);
Route::prefix('cms/admin')->middleware('auth')->group(function(){
    //Route::view('login','cms.auth.login')->name('cms.login');
     route::view('/','cms.dashboard')->name('cms.dashboard');
      Route::get('/tasks/filter', [TaskController::class, 'filter'])
    ->name('tasks.filter');
     Route::resource('tasks', TaskController::class);
     Route::get('logout', [UserAuthController::class, 'logout'])->name('cms.logout');


     Route::post('/notifications/{id}/read', function($id) {
    $user = Auth::user();
    $notification = $user->unreadNotifications()->find($id);
    if($notification) {
        $notification->markAsRead();
        return response()->json(['status' => 'success']);
    }
    return response()->json(['status' => 'not found'], 404);
});
});



