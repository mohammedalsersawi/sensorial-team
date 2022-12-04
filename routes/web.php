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

Route::get('/', function () {
    return view('users.welcome');
})->middleware('auth:web');


Route::middleware('auth:admin')->prefix('admin/dashboard')->group(function () {
    Route::get('/', function () {
        return view('admin.empty');
    })->name('admin.dashboard');
});


Route::middleware('auth:instructor')->prefix('instructor/dashboard')->group(function () {
    Route::get('/', function () {
        return view('instructor.empty');
    })->name('instructor.dashboard');
});
