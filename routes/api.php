<?php

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CompanyController;

//public routes for registering and logging in diffirent users types 
Route::controller(AuthController::class)->group(function () {
    //register
    #admins 
    Route::post('/store-admin', 'storeAdmin')->name('admin.store');
    #companies
    Route::post('/store-company', 'storeCompany')->name('company.store');

    //login 
    #admin
    Route::post('/login-admin', 'loginAdmin')->name('admin.login');
    #companies
    Route::post('/login-company', 'loginCompany')->name('company.login');
    #users (employees)
    Route::post('/login-user', 'loginUser')->name('user.login');
    //logging out all kinds of users 
    Route::post('/logout', 'logout')->middleware('auth:sanctum');
});

//private routes protected by sanctum and guards
Route::middleware(['auth:sanctum'])->group(function () {
    //admin crud routes (guard is admin)
    Route::group(['prefix' => 'admin', 'controller' => AdminController::class, 'middleware' => 'auth:admin'], function () {
        //index detailes 
        Route::get('/' , 'index');
        #get all the companies 
        Route::get('companies', 'companies');
        #get detailes of a snigle specific company 
        Route::get('/company/{id}', 'company');
        #edit an existing companies info 
        Route::patch('edit-company/{id}', 'editCompany');
        #deleting an existing company recored
        Route::delete('destroy-company/{id}', 'destroyCompany');
        #get all the emplyees
        Route::get('/employees', 'employees');
        #edit an existing employee info
        Route::patch('/edit-employee/{id}', 'editEmployee');
        #deleting an existing employee recored
        Route::delete('/destroy-employee/{id}', 'destroyEmployee');
        #get detailes of a single employee
        Route::get('/employee/{id}', 'employee');
    });

    //company crud routes (guard is company)
    Route::group(['prefix' => 'company', 'controller' => CompanyController::class, 'middleware' => 'auth:company'], function () {
        #view compnay info 
        Route::get('/' , 'company');
        #editting company info 
        Route::patch('/edit-company' , 'editCompany');
        #deleting the account
        Route::delete('/destroy' , 'destroy');
        #create a new employee 
        Route::post('/create-employee' , 'createEmployee');
        #get all the employees for a company 
        Route::get('/employees' , 'employees');
        #edit an existing employee recored 
        Route::patch('/edit-employee/{id}' , 'editEmployee');
        #delet an eisting employee recored 
        Route::delete('/destroy-employee/{id}' , 'destroyEmployee');
    });
});
