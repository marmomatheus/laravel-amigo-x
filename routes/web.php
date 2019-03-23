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
    $group = \App\Group::with(['creator', 'participants'])->first();
    $partipants = $group->participants->toArray();
    
    return new App\Mail\GroupConfirmation($partipants[0], $group);
});


Route::get('/confirm-particion/{token}', 'Api\GroupController@confirmParticipation');

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