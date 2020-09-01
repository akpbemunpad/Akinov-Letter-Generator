<?php

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

Route::get('/', 'LetterController@index');

Route::get('/sign/{letterType}/{id}', 'LetterController@hodValidation')->middleware('kadep');  

Route::get('/unlegitimate', function() {
    return view('unlegitimate');
});

Route::group(['prefix' => 'sign', 'middleware' => 'kadep'], function () {   
    Route::post('/basic', 'LetterController@basicSign');  
    Route::post('/invitation/internal', 'LetterController@internalInvSign');  
    Route::post('/invitation/external', 'LetterController@externalInvSign');  
    Route::post('/other', 'LetterController@otherSign');  
});

Route::group(['prefix' => 'basic', 'middleware' => 'akinov'], function () {   
    Route::delete('/', 'BasicLetterController@destroy');
    Route::get('/delete/{id}', 'BasicLetterController@delete');      
    Route::get('/create', 'BasicLetterController@create');    
    Route::post('/create', 'BasicLetterController@store');
    Route::get('/custom', 'BasicLetterController@createCustom');
    Route::post('/custom', 'BasicLetterController@storeCustom');
    Route::get('/edit/{id}', 'BasicLetterController@edit');    
    Route::post('/edit', 'BasicLetterController@update');  
});

Route::group(['prefix' => 'invitation/internal', 'middleware' => 'kadep'], function () {  
    Route::delete('/', 'InvitationLetterController@destroyInternal');
    Route::get('/delete/{id}', 'InvitationLetterController@deleteInternal');  
    Route::get('/create', 'InvitationLetterController@createInternal');    
    Route::post('/create', 'InvitationLetterController@storeInternal');
    Route::get('/custom', 'InvitationLetterController@createCustomInternal');
    Route::post('/custom', 'InvitationLetterController@storeCustomInternal');
    Route::get('/edit/{id}', 'InvitationLetterController@editInternal');    
    Route::post('/edit', 'InvitationLetterController@updateInternal'); 
});

Route::group(['prefix' => 'invitation/external', 'middleware' => 'kadep'], function () {   
    Route::delete('/', 'InvitationLetterController@destroyExternal');
    Route::get('/delete/{id}', 'InvitationLetterController@deleteExternal');  
    Route::get('/create', 'InvitationLetterController@createExternal');    
    Route::post('/create', 'InvitationLetterController@storeExternal');
    Route::get('/custom', 'InvitationLetterController@createCustomExternal');
    Route::post('/custom', 'InvitationLetterController@storeCustomExternal');
    Route::get('/edit/{id}', 'InvitationLetterController@editExternal');    
    Route::post('/edit', 'InvitationLetterController@updateExternal');    
});

Route::group(['prefix' => 'other', 'middleware' => 'kadep'], function () {   
    Route::delete('/', 'OtherLetterController@destroy');
    Route::get('/delete/{id}', 'OtherLetterController@delete'); 
    Route::get('/create', 'OtherLetterController@create');    
    Route::post('/create', 'OtherLetterController@store');
    Route::get('/custom', 'OtherLetterController@createCustom');
    Route::post('/custom', 'OtherLetterController@storeCustom');
    Route::get('/edit/{id}', 'OtherLetterController@edit');    
    Route::post('/edit', 'OtherLetterController@update'); 
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
