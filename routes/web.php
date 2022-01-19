<?php

use Illuminate\Foundation\Http\FormRequest;
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

Route::get('/test', function () {
    return view('chart');
});

Route::get('/', function () {
    return view('two-chart');
});

Route::get('/getData', function () {
    // dd(1);
    $database = app('firebase.database');
    $value = $database->getReference('data')->getValue();
    return response()->json($value);
});

Route::get('/setHot', function () {
    // dd(intval($_GET['t']));
    $database = app('firebase.database');
    $database->getReference('data/record1')
        ->update(['HotBound' => intval($_GET['t'])]);
    return response('ok', 204);
});

Route::get('/setCold', function () {
    // dd($_GET);
    $database = app('firebase.database');
    $database->getReference('data/record1')
        ->update(['ColdBound' => intval($_GET['t'])]);
    return response('ok', 204);
});
