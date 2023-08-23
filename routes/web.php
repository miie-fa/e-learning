<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\VideoController as VideoRoleUserController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VideoController;
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

Route::get('/', [HomeController::class,'index'])->name('home');

Route::prefix('/callback')->name('callback.')->group(function(){

    Route::get('/return', function(){return view('pages.callback.return');});
    Route::get('/cancel', function(){return view('pages.callback.cancel');});

});

Route::get('/video',[VideoRoleUserController::class,'index'])->name('video');

Route::get('/my-video',[VideoRoleUserController::class,'index_my_video'])->name('my_video');

// Route::prefix('/user')->name('user.')->group(function() {
//     Route::get('/videos', function () {
//         return view('pages.user.videos');
//     })->name('video');

//     Route::get('/my-videos', function () {
//         return view('pages.user.my_videos');
//     })->name('my.video');
// });

//AUTHENTICATION
Route::middleware('guest')->group(function(){
    Route::get('/login', [AuthController::class,'login_page'])->name('login');

    Route::post('/login/process', [AuthController::class,'authenticate'])->name('login.process');
    
    Route::get('/register', [AuthController::class,'register_page'])->name('register');

    Route::post('/register/process',[AuthController::class,'register'])->name('register.process');

    Route::get('/activication',[AuthController::class,'activication'])->name('activication');

    Route::post('/activication/process',[AuthController::class,'activication_process'])->name('activication.process');


});
Route::post('/logout',[AuthController::class,'logout'])->name('logout.process');
//Admin
Route::prefix('/admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('transaction', TransactionController::class);
    Route::get('/setting', [SettingController::class,'index'])->name('setting.index');
    Route::post('/setting/process',[SettingController::class,'update'])->name('setting.update');
    Route::get('/setting/change/password',[SettingController::class,'change_password'])->name('setting.change.password');
    Route::post('/setting/change/password/process',[SettingController::class,'change_password_process'])->name('setting.change.password.process');
    Route::resource('videos', VideoController::class);
    Route::delete('/videos/destroy/all',[VideoController::class,'destroy_all'])->name('videos.destroy.all');
    Route::resource('user', UserController::class);
    Route::delete('/user/destroy/all',[UserController::class,'destroy_all'])->name('user.destroy.all');
});

