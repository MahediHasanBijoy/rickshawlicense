<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\PrintReportController;
use App\Http\Controllers\ReceiptController;

Route::get('/', [ApplicantController::class, 'create'])->name('home');
Route::post('/apply', [ApplicantController::class, 'store'])->name('applicant.store');
Route::post('/applicant/search', [ApplicantController::class, 'search'])->name('applicant.search');
Route::get('/applicant/{id}/edit', [ApplicantController::class, 'edit'])
    ->name('applicant.edit');
Route::put('/applicant/{applicant}', [ApplicantController::class, 'update'])
    ->name('applicant.update');
Route::get('/application/print', [ApplicantController::class, 'print'])->name('applicant.print');


//Receipt Routes
Route::get('/print-receipt', [ReceiptController::class, 'PrintReceipt'])->name('applicant.receipt');

// Application Report Print Route
Route::get('/application-report/print', [PrintReportController::class, 'PrintApplicationReport'])
    ->name('application-report-print');

