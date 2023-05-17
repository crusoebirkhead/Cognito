<?php

use \App\Http\Controllers\CognitoFormController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', function () {
    return Inertia::render('CSRF');
});

Route::get('/csrf-token', function () {
    return response()->json(['csrfToken' => csrf_token()]);
});


// Route::get('/load-form', '\App\Http\Controllers\CognitoFormController@load');

Route::post('/load-form', [CognitoFormController::class, 'load']);






