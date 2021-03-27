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


Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);
Route::get('/auth/google' ,'Auth\GoogleAuthController@redirect')->name('auth.google');
Route::get('/auth/google/callback' ,'Auth\GoogleAuthController@callback');
Route::get('/auth/token' ,'Auth\AuthTokenController@getToken')->name('2fa.token');
Route::post('/auth/token' ,'Auth\AuthTokenController@postToken');


Route::get('/home', 'HomeController@index')->name('home');
Route::get('/secret' , function() {
    return 'secret';
})->middleware(['auth' , 'password.confirm']);


Route::middleware('auth')->group(function() {
    Route::get('profile' , 'ProfileController@index')->name('profile');
    Route::get('profile/twofactor' , 'ProfileController@manageTwoFactor')->name('profile.2fa.manage');
    Route::post('profile/twofactor' , 'ProfileController@postManageTwoFactor');

    Route::get('profile/twofacto/phone' , 'ProfileController@getPhoneVerify')->name('profile.2fa.phone');
    Route::post('profile/twofacto/phone' , 'ProfileController@postPhoneVerify');
});



Route::group(['prefix'=>'admin', 'middleware' => ['auth '=> 'auth.admin' ]], function(){
Route::get('/', 'Admin\AdminController@index');
Route::get('/index', 'Admin\UserController@ShowUser')->name('indexpanel');
Route::get('/user/create', 'Admin\UserController@create')->name('admin.users.create');
Route::post('/user/store', 'Admin\UserController@store')->name('admin.users.store');
 Route::get('/user/edit/{id}', 'Admin\UserController@edit')->name('admin.users.edit');
Route::post('/user/update/{id}','Admin\UserController@update')->name('admin.users.update');
Route::get('/user/delete/{id}','Admin\UserController@delete')->name('admin.users.delete');


});