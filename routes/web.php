<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('site.home');
});
Route::get('/biddings', function() {
   return view('site.biddings');
});
Route::get('/about', function(){
    return view('site.about');
});
Route::get('/contact', function(){
    return view('site.contact');
});
Route::get('/help', function(){
    return view('site.help');
});
Route::get('/faq', function(){
    return view('site.faq');
});
Route::get('/customers', function(){
    return view('site.customers');
});
Route::get('/suppliers', function(){
    return view('site.suppliers');
});
Route::get('/rates', function(){
    return view('site.rates.show');
});
//Registration routes
Route::get('/auth/login', 'Auth\RegisterController@getLogin');
Route::post('/auth/login', 'Auth\RegisterController@postLogin');
Route::get('/auth/logout', 'Auth\AuthController@logout');
Route::get('/auth/register',['middleware' => 'guest', 'uses'=>'RegistrationController@getBaseRegister']);
Route::post('/auth/register', 'RegistrationController@register');
Route::get('/auth/userStatus', function(){
    return view('auth.user_status');
});
Route::get('register/confirm/{token}','RegistrationController@confirm');
//Password reset
Route::get('password/email','Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');
