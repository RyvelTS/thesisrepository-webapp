<?php

use App\Http\Controllers\SchoolController;
use App\Http\Controllers\UserController;
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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/my-profile', [App\Http\Controllers\HomeController::class, 'show'])->name('profile');
Route::patch('/my-profile', [App\Http\Controllers\HomeController::class, 'update'])->name('profile_update');

Route::get('/create', [App\Http\Controllers\ThesisController::class, 'create'])->name('thesis_create');
Route::post('/create', [App\Http\Controllers\ThesisController::class, 'store'])->name('thesis_store');

Route::get('/thesis', [App\Http\Controllers\ThesisController::class, 'index'])->name('thesis_search');
Route::get('/thesis/{thesis_id}', [App\Http\Controllers\ThesisController::class, 'show'])->name('thesis_show');
Route::get('/thesis/{thesis_id}/edit', [App\Http\Controllers\ThesisController::class, 'edit'])->name('thesis_edit');
Route::patch('/thesis/{thesis_id}/edit', [App\Http\Controllers\ThesisController::class, 'update'])->name('thesis_update');
Route::delete('/thesis/delete', [App\Http\Controllers\ThesisController::class, 'destroy'])->name('thesis_destroy');
Route::get('/my-thesis', [App\Http\Controllers\ThesisController::class, 'indexMyThesis'])->name('user_thesis_index');

Route::resource('/administrator/school',SchoolController::class)->except('create','show','edit');
Route::resource('/administrator/user',UserController::class)->except('create','show','edit');

Route::get('/search', [App\Http\Controllers\GuestPageController::class, 'index'])->name('search');
Route::get('/view/{thesis_id}', [App\Http\Controllers\GuestPageController::class, 'show'])->name('show');
