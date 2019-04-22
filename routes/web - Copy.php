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
    return view('dashboard');
})->middleware('auth');

Auth::routes();

Route::get('/Admin', 'DashboardController@index');
Route::get('/dashboard', 'DashboardController@index');
Route::get('/profile', 'ProfileController@index');

//user Management Routing
Route::get('Admin/Users/UserManagementController', 'UserManagementController@index')->middleware('auth');
Route::get('Admin/Users/UserManagementController/edit/{id?}', 'UserManagementController@edit')->middleware('auth');
Route::get('Admin/Users/UserManagementController/update/{id?}', 'UserManagementController@update')->middleware('auth');
Route::get('Admin/Users/UserManagementController/create', 'UserManagementController@create')->middleware('auth');
Route::post('Admin/Users/UserManagementController/store', 'UserManagementController@store')->middleware('auth');
//user Management Routing

//user Roles Routing
Route::get('Admin/Users/userRoles', 'userRoles@index')->middleware('auth');
Route::get('Admin/Users/userRoles/edit/{id?}', 'userRoles@edit')->middleware('auth');
Route::get('Admin/Users/userRoles/update/{id?}', 'userRoles@update')->middleware('auth');
Route::get('Admin/Users/userRoles/create', 'userRoles@create')->middleware('auth');
Route::post('Admin/Users/userRoles/store', 'userRoles@store')->middleware('auth');
//user Roles Routing

//user Permission Routing
Route::get('Admin/Users/userPermissions', 'userPermissions@index')->middleware('auth');
Route::get('Admin/Users/userPermissions/edit/{id?}', 'userPermissions@edit')->middleware('auth');
Route::get('Admin/Users/userPermissions/update/{id?}', 'userPermissions@update')->middleware('auth');
Route::get('Admin/Users/userPermissions/create', 'userPermissions@create')->middleware('auth');
Route::post('Admin/Users/userPermissions/store', 'userPermissions@store')->middleware('auth');
//user Permission Routing


//user Screens Routing
Route::get('Admin/Users/userScreens', 'userScreens@index')->middleware('auth');
Route::get('Admin/Users/userScreens/edit/{id?}', 'userScreens@edit')->middleware('auth');
Route::get('Admin/Users/userScreens/update/{id?}', 'userScreens@update')->middleware('auth');
Route::get('Admin/Users/userScreens/create', 'userScreens@create')->middleware('auth');
Route::post('Admin/Users/userScreens/store', 'userScreens@store')->middleware('auth');
//user Screens Routing

// Dynamic offer routing
Route::get('Admin/Marketing/dynamicOffers', 'dynamicOffers@index')->middleware('auth');
Route::get('Admin/Marketing/dynamicOffers/create', 'dynamicOffers@create')->middleware('auth');
Route::get('Admin/Marketing/dynamicOffers/createoffers', 'dynamicOffers@createoffers')->middleware('auth');
Route::get('Admin/Marketing/dynamicOffers/edit/{id?}', 'dynamicOffers@edit')->middleware('auth');
Route::get('Admin/Marketing/dynamicOffers/destroy/{id?}', 'dynamicOffers@destroy')->middleware('auth');
Route::post('Admin/Marketing/dynamicOffers/storeFormData', 'dynamicOffers@storeFormData')->middleware('auth');
Route::post('Admin/Marketing/dynamicOffers/store', 'dynamicOffers@store')->middleware('auth');
// Dynamic offer routing

// Promo Code routing
Route::get('Admin/Marketing/promoCode', 'promoCode@index')->middleware('auth');
Route::get('Admin/Marketing/promoCode/create', 'promoCode@create')->middleware('auth');
Route::get('Admin/Marketing/promoCode/edit/{id?}', 'promoCode@edit')->middleware('auth');
Route::post('/Admin/Marketing/promoCode/destroy/{id?}','promoCode@destroy')->middleware('auth');
Route::post('Admin/Marketing/promoCode/store', 'promoCode@store')->middleware('auth');
// Promo Code routing

// User SUBSCRIPTION routing
Route::get('Admin/Marketing/userSubscription', 'userSubscription@index')->middleware('auth');
Route::get('Admin/Marketing/userSubscription/create', 'userSubscription@create')->middleware('auth');
Route::get('Admin/Marketing/userSubscription/edit/{id?}', 'userSubscription@edit')->middleware('auth');
Route::post('/Admin/Marketing/userSubscription/destroy/{id?}','userSubscription@destroy')->middleware('auth');
Route::post('Admin/Marketing/userSubscription/store', 'userSubscription@store')->middleware('auth');
Route::post('Admin/Marketing/userSubscription/search', 'userSubscription@search')->name('userSubscription.search')->middleware('auth');
// User SUBSCRIPTION routing

// User SUBSCRIPTION routing
Route::get('Admin/Transaction/TransactionLost', 'Transaction@index')->middleware('auth');
Route::get('Admin/Transaction/TransactionLost/create', 'Transaction@create')->middleware('auth');
Route::get('Admin/Transaction/TransactionLost/edit/{id?}', 'Transaction@edit')->middleware('auth');
Route::post('/Admin/Transaction/TransactionLost/destroy/{id?}','Transaction@destroy')->middleware('auth');
Route::post('Admin/Transaction/TransactionLost/store', 'Transaction@store')->middleware('auth');
Route::post('Admin/Transaction/TransactionLost/search', 'Transaction@search')->name('userSubscription.search')->middleware('auth');
// User SUBSCRIPTION routing
Route::get('Marketing/userSubscription', 'userSubscription@index')->middleware('auth');
Route::get('Marketing/promoCode', 'promoCode@index')->middleware('auth');


