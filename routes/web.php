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
// PREVIEW
Route::get('/', 'homepageController@index');
Route::get('/hydraulic-dump-truck', 'homepageController@shop1');
Route::get('/sparepart-truck', 'homepageController@shop2');
Route::get('/ajax-product/{itemId}', 'homepageController@quickview');
Route::get('/dapatkan-penawaran/{itemId}', 'homepageController@penawaran');
Route::post('/kirim-penawaran', 'homepageController@kirimpenawaran');
Route::post('/kirimpesan', 'homepageController@kirimpesan');
Route::get('/about', 'homepageController@about');
Route::get('/contact', 'homepageController@contact');

// DASHBOARD LOGIN
Route::get('/tools', 'AuthenController@tools')->name('signin');
Route::post('/proses-login', 'AuthenController@auth');
Route::get('logout', 'AuthenController@logout');
Route::post('/registrasiproses', 'AuthenController@registrasi');

// NEED AUTH
// Route::group(['middleware' => 'auth'], function (
// {}));
// DASHBOARD

Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', 'dashboardController@index');
    Route::get('/utility-item', 'dashboardController@utility');
    Route::post('/tambah-data-kategori', 'dashboardController@kategoriadd');
    Route::post('/tambah-data-item', 'dashboardController@itemadd');
    Route::get('/messages', 'dashboardController@messages');
    Route::get('/messages/read/{message_id}', 'dashboardController@readmessage');
    Route::get('/user-config', 'dashboardController@userconf');
    Route::post('/tambah-data-user', 'dashboardController@tambahuser');
    // VIEW EDIT FORM
    Route::get('/update-kategori/{id}', 'dashboardController@updatekategori');
    Route::get('/delete-kategori/{id}', 'dashboardController@deletekategori');
    Route::get('/update-item/{id}', 'dashboardController@updateitem');
    Route::get('/delete-item/{id}', 'dashboardController@deleteitem');
    Route::get('/update-user/{id}', 'dashboardController@updateuser');
    Route::get('/delete-user/{id}', 'dashboardController@deleteuser');
    // PROSES EDIT FORM
    Route::post('/proses-kategori/{id}', 'dashboardController@prosesupdatekategori');
    Route::post('/proses-item/{itemId}', 'dashboardController@prosesupdateitem');
    Route::post('/proses-user/{id}', 'dashboardController@prosesuser');
});
