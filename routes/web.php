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