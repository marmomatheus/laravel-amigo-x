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
Route::get('/demo', function () {
    $group = \App\Group::with('participants')->findOrFail(20);
    $participantModel = \App\User::select('email', 'name')
    ->where('id', 1)
    ->first();
    $friendModel = \App\User::with('gifts')
    ->where('id', 3)
    ->first();
    return new App\Mail\GameNotification($group, $participantModel, $friendModel, '21/04/2019');
});


Route::get('confirm-participation/{token}', 'Api\GroupController@confirmParticipation');

Route::get('/login', function () {
    if (Auth::check()) {
        return redirect('/');
    } else {
        return view('index');
    }
});

Route::get('/', function () {        
    if (Auth::check()) {
        return view('index');
    } else {
        return redirect('/login');
    }
});

Route::get('/{any}', function ($any) {
    if (Auth::check()) {
        return view('index');
    } else {
        return redirect('/login');
    }
})->where('any', '.*');