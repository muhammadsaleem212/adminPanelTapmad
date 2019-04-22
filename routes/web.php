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
Route::get('UserManagementController', 'UserManagementController@index')->middleware('auth');
Route::get('UserManagementController/edit/{id?}', 'UserManagementController@edit')->middleware('auth');
Route::get('UserManagementController/update/{id?}', 'UserManagementController@update')->middleware('auth');
// Route::get('UserManagementController/create', 'UserManagementController@create')->middleware('auth');
Route::get('saveUserManagement', 'UserManagementController@create')->middleware('auth');
Route::post('UserManagementController/store', 'UserManagementController@store')->middleware('auth');
//user Management Routing

//user Roles Routing
Route::get('userRoles', 'userRoles@index')->middleware('auth');
Route::get('userRoles/edit/{id?}', 'userRoles@edit')->middleware('auth');
Route::get('userRoles/update/{id?}', 'userRoles@update')->middleware('auth');
Route::get('saveUserRoles', 'userRoles@create')->middleware('auth');
Route::post('userRoles/store', 'userRoles@store')->middleware('auth');
//user Roles Routing

//user Permission Routing
Route::get('userPermissions', 'userPermissions@index')->middleware('auth');
Route::get('userPermissions/edit/{id?}', 'userPermissions@edit')->middleware('auth');
Route::get('userPermissions/update/{id?}', 'userPermissions@update')->middleware('auth');
// Route::get('userPermissions/create', 'userPermissions@create')->middleware('auth');
Route::get('saveUserPermission', 'userPermissions@create')->middleware('auth');
Route::post('userPermissions/store', 'userPermissions@store')->middleware('auth');
//user Permission Routing


//user Screens Routing
Route::get('userScreens', 'userScreens@index')->middleware('auth');
Route::get('userScreens/edit/{id?}', 'userScreens@edit')->middleware('auth');
Route::get('userScreens/update/{id?}', 'userScreens@update')->middleware('auth');
Route::get('saveUserScreens', 'userScreens@create')->middleware('auth');
// Route::get('userScreens/create', 'userScreens@create')->middleware('auth');
Route::post('userScreens/store', 'userScreens@store')->middleware('auth');
//user Screens Routing

// Dynamic offer routing
Route::get('dynamicOffers', 'dynamicOffers@index')->middleware('auth');
Route::get('saveDynamicOffersbyCsv', 'dynamicOffers@create')->middleware('auth');
Route::get('saveDynamicOffersbyForm', 'dynamicOffers@createoffers')->middleware('auth');
// Route::get('dynamicOffers/createoffers', 'dynamicOffers@createoffers')->middleware('auth');
Route::get('dynamicOffers/edit/{id?}', 'dynamicOffers@edit')->middleware('auth');
Route::get('dynamicOffers/destroy/{id?}', 'dynamicOffers@destroy')->middleware('auth');
Route::post('dynamicOffers/storeFormData', 'dynamicOffers@storeFormData')->middleware('auth');
Route::post('dynamicOffers/store', 'dynamicOffers@store')->middleware('auth');
// Dynamic offer routing

// Promo Code routing
Route::get('promoCode', 'promoCode@index')->middleware('auth');
Route::get('savePromoCode', 'promoCode@create')->middleware('auth');
// Route::get('promoCode/create', 'promoCode@create')->middleware('auth');
Route::get('promoCode/edit/{id?}', 'promoCode@edit')->middleware('auth');
Route::post('promoCode/destroy/{id?}','promoCode@destroy')->middleware('auth');
Route::post('promoCode/store', 'promoCode@store')->middleware('auth');
// Promo Code routing

// User SUBSCRIPTION routing
Route::get('userSubscription', 'userSubscription@index')->middleware('auth');
Route::get('saveUserSubscription', 'userSubscription@create')->middleware('auth');
// Route::get('userSubscription/create', 'userSubscription@create')->middleware('auth');
Route::get('userSubscription/edit/{id?}', 'userSubscription@edit')->middleware('auth');
Route::post('userSubscription/destroy/{id?}','userSubscription@destroy')->middleware('auth');
Route::post('userSubscription/store', 'userSubscription@store')->middleware('auth');
Route::get('userSubscription/export', 'userSubscription@export');
Route::post('userSubscription/search', 'userSubscription@search')->name('userSubscription.search')->middleware('auth');
// User SUBSCRIPTION routing

// User SUBSCRIPTION routing
Route::get('TransactionLost', 'Transaction@index')->middleware('auth');
Route::get('TransactionLost/create', 'Transaction@create')->middleware('auth');
Route::get('TransactionLost/edit/{id?}', 'Transaction@edit')->middleware('auth');
Route::post('TransactionLost/destroy/{id?}','Transaction@destroy')->middleware('auth');
Route::post('TransactionLost/store', 'Transaction@store')->middleware('auth');
Route::post('TransactionLost/search', 'Transaction@search')->name('userSubscription.search')->middleware('auth');
// User SUBSCRIPTION routing

// Channel routing
Route::get('ChannelController', 'ChannelController@index')->middleware('auth');
Route::get('CategoriesController', 'CategoriesController@index')->middleware('auth');
Route::get('ChannelController/create', 'ChannelController@create')->middleware('auth');
Route::post('ChannelController/store', 'ChannelController@store')->middleware('auth');
Route::get("ChannelController/create","ChannelController@create")->middleware('auth');
//  Channel routing

// Failed Transaction routing
Route::get('TransactionFailed', 'TransactionFailed@index')->middleware('auth');
Route::get('TransactionFailed/index', 'TransactionFailed@index')->middleware('auth');
Route::get('TransactionFailed/export', 'TransactionFailed@export')->middleware('auth');
Route::post('TransactionFailed/index', 'TransactionFailed@index')->middleware('auth');
//  Failed Transaction

// Successful Transaction routing
Route::get('TransactionSuccessful',  'TransactionSuccessful@index')->middleware('auth');
Route::post('TransactionSuccessful', 'TransactionSuccessful@index')->middleware('auth');
Route::get('TransactionSuccessful/export', 'TransactionSuccessful@export')->middleware('auth');
Route::post('TransactionFailed/index', 'TransactionFailed@index')->middleware('auth');
//  Successful Transaction

// Payment Log Transaction routing
Route::get('PaymentLogs',  'PaymentLogs@index')->middleware('auth');
Route::get('PaymentLogs/index',  'PaymentLogs@index')->middleware('auth');
Route::post('PaymentLogs', 'PaymentLogs@index')->middleware('auth');
Route::get('PaymentLogs/export', 'PaymentLogs@export')->middleware('auth');
Route::post('TransactionFailed/index', 'TransactionFailed@index')->middleware('auth');
// Payment Log Transaction routing

// Bucket Users routing
Route::get('BucketUsers',  'BucketUsers@index')->middleware('auth');
Route::get('BucketUsers/index',  'BucketUsers@index')->middleware('auth');
Route::post('BucketUsers', 'BucketUsers@index')->middleware('auth');
Route::get('BucketUsers/export', 'BucketUsers@export')->middleware('auth');
// Bucket Users routing

// User OTP routing
Route::get('userOTP',  'userOTP@index')->middleware('auth');
Route::post('userOTPSearch', 'userOTP@index')->middleware('auth');
// User OTP routing


