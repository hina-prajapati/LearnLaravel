<?php

use App\Http\Controllers\FileUplaodController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::any('/uploads/create', [FileUplaodController::class, 'create'])->name('uploads.create');
Route::get('/uploads/list/', [FileUplaodController::class, 'list'])->name('uploads.list');
Route::get('/uploads/edit/{id}', [FileUplaodController::class, 'edit'])->name('uploads.edit');
Route::put('/update/{id}', [FileUplaodController::class, 'update']);
Route::delete('/delete/{id}', [FileUplaodController::class, 'destroy']);
Route::delete('/deleteimage/{id}', [FileUplaodController::class, 'deleteimage']);



Route::any('/post/add', [PostController::class, 'add'])->name('post.add');
Route::any('/post/list', [PostController::class, 'list'])->name('post.list');
Route::get('/post/edit/{id}', [PostController::class, 'edit'])->name('post.edit');
Route::put('/update/{id}', [PostController::class, 'update']);
Route::delete('/delete/{id}', [PostController::class, 'destroy']);
Route::delete('/deleteimage/{id}', [PostController::class, 'deleteimage']);