<?php

use App\Http\Controllers\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::get('student', [StudentController:: class, 'index']);
Route::post('student', [StudentController:: class, 'store']);
Route::get('student/{id}', [StudentController:: class, 'show']);
Route::put('student/{id}', [StudentController:: class, 'update']);
Route::patch('student/{id}', [StudentController:: class, 'updatePatch']);
Route::delete('student/{id}', [StudentController:: class, 'destroy']);

