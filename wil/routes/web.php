<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ProjectController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


// go to home page 
Route::view('login','login')->name('login');
Route::view('register','register');
Route::post('login', [UserController::class,'login']);
Route::post('register', [UserController::class,'register']);


// these routes are protected by the middleware that make sure only logged in users can access the following routes 
Route::group(['middleware' => 'auth'], function () {
    Route::get('/',[MainController::class,'homePage']);
    Route::get('logout', [UserController::class,'logout']);
    Route::get('inp-detail/{id}', [UserController::class,'inpDetail']);
    Route::post('add-project',[ProjectController::class,'createProject']);
    Route::get('project-detail/{id}',[ProjectController::class,'projectDetail']);
    Route::get('project-edit/{id}',[ProjectController::class,'projectEdit']);
    Route::get('project-delete/{id}',[ProjectController::class,'projectDelete']);
    Route::get('project-list',[ProjectController::class,'projectsList']);
    Route::post('update-project',[ProjectController::class,'updateProject']);
    Route::post('project-application',[ProjectController::class,'projectApplication']);
    Route::post('student-profile-update', [UserController::class,'updateStudentProfile']);
    Route::get('student-profile/{id}', [UserController::class,'showProfile']);
    Route::get('inp-approve/{id}', [UserController::class,'approveInp']);
    Route::post('auto-assignment', [MainController::class,'autoAssign']);
});
