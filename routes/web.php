<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\FizzBuzzController;
use App\Http\Controllers\HotelController;
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

Route::get('fizz-buzz', [FizzBuzzController::class, 'getFizzBuzz'])->name('fizzbuzz.index');
Route::post('fizz-buzz', [FizzBuzzController::class, 'fizzbuzz'])->name('fizzbuzz');

Route::get('images', [ImageUploadController::class, 'getFiles'])->name('upload.image');
Route::post('image/upload/store',[ImageUploadController::class, 'fileStore']);
Route::post('image/delete',[ImageUploadController::class, 'fileDestroy']);

Route::get('hotel', [HotelController::class, 'index'])->name('hotel.index');
Route::post('hotel', [HotelController::class, 'store'])->name('hotel.store');
