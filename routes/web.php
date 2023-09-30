<?php
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\FriendController;
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


Route::post('/register', [UserController::class, 'register'])->name('submit.register');
Route::post('/login', [UserController::class, 'login'])->name('submit.login');
Route::get('/logout', [UserController::class, 'logout'])->name('logout');
Route::get('/', [UserController::class, 'show'])->name('login');
Route::middleware('auth')->group(function () {
    Route::get('/home',[HomeController::class,'Index'])->name('home');
    Route::Post('/post/store',[PostController::class,'store'])->name('post.store');
    Route::get('/post/delete',[PostController::class,'destroy'])->name('post.destroy');

    Route::get('/profile',[UserController::class,'profile'])->name('user.profile');
    Route::post('/profile/edit',[UserController::class,'edit_profile'])->name('user.edit.profile');


    Route::get('friend/send/{id}', [FriendController::class,'SendFriend'])->name('friends.SendFriend');
    Route::get('friend/accept/{id}', [FriendController::class,'update'])->name('friends.accept');
    Route::delete('/unfriend/{id}',[FriendController::class,'destroy'])->name('friends.destroy');
});