<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApplicantController;

Route::get('/', [ApplicantController::class, 'create'])->name('home');
Route::post('/apply', [ApplicantController::class, 'store'])->name('applicant.store');
