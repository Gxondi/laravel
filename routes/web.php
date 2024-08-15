<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegController;
use App\Http\Controllers\UserController;
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
//default route
Route::get('/', function () {
    return view('user/login');
})->name('login');
//新規登録画面
Route::get('/register', function () {
    return view('user/register');
})->name('register');


//ユーザーログイン作業
Route::post('/login', [LoginController::class, "login"])->name('login.login');
//ユーザー新規登録作業
Route::post('/register', [RegController::class, "register"])->name('register.register');
//ユーザー情報取得
Route::get('getUserInfo', [UserController::class, "getUserInfo"])->name('getUserInfo');
Route::get('getArticles', [UserController::class, "getArticles"])->name('getArticles');
Route::get('userCenter', [UserController::class, 'showData'])->name('userCenter');
Route::post('upload', [UserController::class, "upload"])->name('upload');
Route::delete('deleteArticle/{id}', [UserController::class, 'deleteArticle'])->name('deleteArticle');

Route::get('logout', function () {
    Auth::logout();
    return redirect()->route('login');
})->name('logout');


////控制器路由
////路由规则：当访问/test时，调用Ding控制器的test方法
//use App\Http\Controllers\Ding;
//Route::get('/test', [Ding::class, 'test']);
////基本路由，可以写业务逻辑
////路由规则：当访问/basic时，返回字符串“basic route”
//Route::get('/basic', function () {
//    return 'basic route';
//});
////视图路由，可以返回视图
////路由规则：当访问/view时，返回视图welcome
//Route::view('/view', 'welcome');
/////
///// use App\Http\Controllers\Ding;
//Route::get('/home/dbTest', [Ding::class, 'dbTest']);
