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
//导入用户 成功后会直接跳转到登录
Route::get('/', 'IndexController@index')->name('index');
Route::post('/', 'IndexController@import');
//用户登录
Route::get('/login', 'IndexController@login')->name('login');
Route::post('/login', 'IndexController@login');
// Route::get('/user', 'IndexController@user')->name('user');
Route::post('/user', 'IndexController@user');
// 从推广链接进来后注册新用户
Route::get('/register', 'IndexController@register')->name('register');
Route::post('/register', 'IndexController@createUser');
// 根据用户id获取该用户下的无限子用户
Route::get('/info/{id}', 'IndexController@info')->name('info');
// 设置积分规则
Route::get('/setting', 'IndexController@setting')->name('setting');
Route::post('/setting', 'IndexController@set');