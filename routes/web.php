<?php

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
//Route::get('/', function () {//使用闭包函数 直接跳转到view视图了
//    return view('welcome');
//});
Route::get('/',"IndexController@home")->name("home");//@相当于里面的什么方法
Route::resource("user","UserController");//用户资源路由
Route::get('logout', 'LoginController@logout')->name('logout');
//虽然路由都是login 但是方法不一样
Route::get('login', "LoginController@login")->name('login');
Route::post('login', 'LoginController@store')->name('login');

Route::get('confirmEmailToken/{token}', 'UserController@confirmEmailToken')->name('confirmEmailToken');//邮箱注册

//找回密码
Route::get('FindPasswordEmail', 'PasswordController@email')->name('FindPasswordEmail');
Route::post('FindPasswordSend', 'PasswordController@send')->name('FindPasswordSend');
Route::get('FindPasswordEdit/{token}', 'PasswordController@edit')->name('FindPasswordEdit');
Route::post('FindPasswordUpdate', 'PasswordController@update')->name('FindPasswordUpdate');
//找回密码

Route::resource('blog', 'BlogController');//博客资源路由

//关注路由
Route::get('follow/{user}', 'UserController@follow')->name('user.follow');
Route::get('follower/{user}','FollowController@follower')->name('follow');
Route::get('following/{user}','FollowController@following')->name('following');
