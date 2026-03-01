<?php

use App\Http\Controllers\Frontend\ProjectController;
use Illuminate\Support\Facades\Route;


Route::get('/', [ProjectController::class, 'home'])->name('home');


// Route::get('/', [ProjectController::class, 'index'])->name('home');
Route::get('/projects/{slug}', [ProjectController::class, 'show'])->name('projects.show');
Route::get('/projects', [ProjectController::class, 'projects'])->name('projects.index');
Route::view('/about', 'frontend.about')->name('about');
Route::view('/contact', 'frontend.contact')->name('contact');

