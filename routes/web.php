<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ForgotController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ResetController;
use App\Http\Controllers\UserController;
use Illuminate\Routing\Route as RoutingRoute;
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
Route::get('profile/{user}',[UserController::class,'profile'])->name('user.profile');
Route::resource('articles',ArticleController::class)->except('index');

Route::get('register',[RegisterController::class,'index'])->name('register');
Route::post('register',[RegisterController::class,'register'])->name('post.register');

Route::get('login',[LoginController::class,'index'])->name('login');
Route::post('login',[LoginController::class,'login'])->name('post.login');

Route::get('logout',[LogoutController::class,'logout'])->name('logout');

Route::get('forgot',[ForgotController::class,'index'])->name('forgot');
Route::post('forgot',[ForgotController::class,'store'])->name('post.forgot');

Route::get('reset/{token}',[ResetController::class,'index'])->name('reset');
Route::post('reset',[ResetController::class,'reset'])->name('post.reset');

Route::get('/',[ArticleController::class,'index']);

Route::post('comment/{article}',[CommentController::class,'store'])->name('post.comment');

// Route::get('/test', function () {
//     $fuits =['orange','citron','banane'];
//     $data =[
//         'number' => 21,
//         'fruits'=> $fuits,

//     ];
//     return view('test',$data);
// });

