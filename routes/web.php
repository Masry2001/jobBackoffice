<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\JobVacancyController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\JobCategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SettingsController;





// Shared Routes (Company-Owner, Admin)
Route::middleware(['auth', 'role:Admin,Company-Owner'])->group(function () {

    Route::get('/', DashboardController::class)->name('dashboard');


    // job-vacancies route
    Route::resource('/job-vacancies', JobVacancyController::class);
    Route::PUT('/job-vacancies/{jobVacancy}/restore', [JobVacancyController::class, 'restore'])->name('job-vacancies.restore');


    //job applications route
    Route::resource('/job-applications', JobApplicationController::class);
    Route::PUT('/job-applications/{jobApplication}/restore', [JobApplicationController::class, 'restore'])->name('job-applications.restore');


    // settings route
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');

    // profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



// Company-Owner Routes
Route::middleware(['auth', 'role:Company-Owner'])->group(function () {

    Route::get('/my-company', [CompanyController::class, 'show'])->name('my-company.show');
    Route::get('/my-company/edit', [CompanyController::class, 'edit'])->name('my-company.edit');
    Route::put('/my-company', [CompanyController::class, 'update'])->name('my-company.update');
});



// Admin Routes
Route::middleware(['auth', 'role:Admin'])->group(function () {


    // job categories route
    Route::resource('/job-categories', JobCategoryController::class);
    Route::PUT('/job-categories/{jobCategory}/restore', [JobCategoryController::class, 'restore'])->name('job-categories.restore');

    // users route
    Route::resource('/users', UserController::class);
    Route::PUT('/users/{user}/restore', [UserController::class, 'restore'])->name('users.restore');


    // compenies route
    Route::resource('/companies', CompanyController::class);
    Route::PUT('/companies/{company}/restore', [CompanyController::class, 'restore'])->name('companies.restore');
});



require __DIR__ . '/auth.php';
