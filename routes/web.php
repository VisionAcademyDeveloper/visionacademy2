<?php
use App\Events\NewUserHasRegisteredEvent;
use App\Jobs\SendWelcomeEmailJob;
use App\User;

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
   

    $user = User::where('id', 1)->first();
   
    dispatch(new SendWelcomeEmailJob($user));
    return "hi";
});


Route::get('/pusher',function(){

    return view('pusher');
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
