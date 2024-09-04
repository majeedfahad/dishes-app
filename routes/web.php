<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DishController;
use App\Http\Controllers\CompanyController;

Route::get('/', function () {
    return view('welcome');
});

// Category Routes
Route::resource('categories', CategoryController::class);
Route::post('categories/{category}/assign-dishes', [CategoryController::class, 'assignDishes'])->name('categories.assign.dishes');

// Dish Routes
Route::resource('dishes', DishController::class);
Route::get('companies/{company}/dishes', [DishController::class, 'listDishesForCompany'])->name('companies.dishes.list');

// Company Routes
Route::resource('companies', CompanyController::class);
Route::post('companies/{company}/assign-dishes', [CompanyController::class, 'assignDishes'])->name('companies.assign.dishes');
