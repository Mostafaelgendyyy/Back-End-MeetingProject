<?php

use App\Http\Controllers\adminController;
use Illuminate\Support\Facades\Auth;
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
    return view('welcome');
});

Route::get('/test1', function () {
    return "view('welcome')";
});

// Route Parameters (Sending Parameters while Routing)

Route::get('/test2/{id}', function ($id) { // id is required and Must be sent to Funtion ROute of test 2
    return $id ;
});

Route::get('/test3/{id?}', function () { // id is not required and Must be sent to Funtion ROute of test 2
    return "this is test 3 page" ;
});

// Routing Name (Name the Routing Methods to be used in another Place


Route::get('/test4/{id?}', function () { // id is not required and Must be sent to Funtion ROute of test 2
    return "this is test 4 page" ;
}) -> name("Routing#1 landing");

Route::get('/test5/{id?}', function () { // id is not required and Must be sent to Funtion ROute of test 2
    return "this is test 5 page" ;
}) -> name("Routing#2 of test#4");

//Route::get('/admin', [adminController::class,'index'])->name('admin')->middleware('admin');



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::prefix('admin')->middleware(['auth','admin'])->group(function (){
    Route::get('/Interface',[App\Http\Controllers\adminController::class, 'index']);
});
