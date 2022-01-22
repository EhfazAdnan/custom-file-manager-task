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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard.home');
Route::get('/recents', [App\Http\Controllers\HomeController::class, 'recents'])->name('dashboard.recents');
Route::get('/trash', [App\Http\Controllers\HomeController::class, 'trash'])->name('dashboard.trash');

Route::post('create-folder/{parent_id}/{serial}', [App\Http\Controllers\FilesController::class,'store'])->name('folder.create');

Route::post('upload-files/{id}', [App\Http\Controllers\FilesController::class,'storeFiles'])->name('files.create');

Route::get('folder/{id}',[App\Http\Controllers\FilesController::class,'index'])->name('folder-details');