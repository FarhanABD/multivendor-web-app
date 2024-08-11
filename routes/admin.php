<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\SliderController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\SubCategoryController;
use App\Http\Controllers\Backend\ChildCategoryController;

Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

//--------- PROFILE ROUTES -------------//
Route::get('profile',[ProfileController::class, 'index'])->name('profile');
Route::post('profile/update',[ProfileController::class, 'updateProfile'])->name('profile.update');

Route::post('profile/update/password',[ProfileController::class, 'updatePassword'])->name('password.update');

//------------- SLIDER ROUTE --------------//
Route::resource('slider', SliderController::class);

//------------- CATEGORY ROUTE ---------------//
Route::put('change-status', [CategoryController::class, 'changeStatus'])->name('category.change-status');
Route::resource('category',CategoryController::class);

//------------- SUBCATEGORY ROUTE ---------------//
Route::put('sub-category/change-status', [SubCategoryController::class, 'changeStatus'])->name('sub-category.change-status');
Route::resource('sub-category',SubCategoryController::class);

//------------- CHILD CATEGORY ROUTE ---------------//
Route::put('child-category/change-status', [ChildCategoryController::class, 'changeStatus'])->name('child-category.change-status');
Route::get('get-subcategories', [ChildCategoryController::class, 'getSubCategories'])->name('get-subcategories');
Route::resource('child-category',ChildCategoryController::class);