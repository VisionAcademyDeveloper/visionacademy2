<?php

use App\Events\NewUserHasRegisteredEvent;
use App\Jobs\SendWelcomeEmailJob;
use App\User;
use App\Chapter;

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


    if (Auth::check())
        return Auth::user();
    else {
        return 'no';
    }
});


Route::get('/pusher', function () {

    return view('pusher');
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
