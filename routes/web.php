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

// update folder name
Route::post('update-folder/{id}', [App\Http\Controllers\FilesController::class,'update'])->name('folder.update');

// soft-delete folder
Route::delete('delete-folder/{id}', [App\Http\Controllers\FilesController::class,'destroy'])->name('folder.delete');

// soft-delete files
Route::delete('delete-file/{id}', [App\Http\Controllers\FilesController::class,'destroyFiles'])->name('file.delete');

// download
Route::get('/download/{id}', [App\Http\Controllers\FilesController::class, 'download_public'])->name('download');

// search
Route::get('/search-web', [App\Http\Controllers\FilesController::class, 'search'])->name('web.search');


// admin routes
Route::get('/admin/home', [App\Http\Controllers\SuperAdminController::class, 'index'])->name('admin.home')->middleware('is_admin');

Route::post('/admin/update-user/{id}', [App\Http\Controllers\SuperAdminController::class, 'update'])->name('user.update')->middleware('is_admin');
