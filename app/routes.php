<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', 'HomeController@index');
Route::get('/place/{place}', 'PlaceController@showPlace');
Route::post('/place', 'PlaceController@getPlace');
Route::post('/image/callback', 'CallbackController@imageCallback');

Route::post('/tweets', 'TwitterController@getTweets');
Route::post('/instagrams', 'InstagramController@getInstagrams');
Route::post('/venues', 'FoursquareController@getVenues');