<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\TransferController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/* USER ROUTES */

Route::get('/users', [UserController::class, 'index']);

Route::post('/user/select', [UserController::class, 'showOne']);

Route::post('/user/login', [UserController::class, 'show']);

Route::post('/user/signup', [UserController::class, 'store']);

Route::patch('/user/update', [UserController::class, 'update']);

Route::delete('/user/delete', [UserController::class, 'delete']);

Route::get('/account', [AccountController::class, 'generateCardNo']);

/* ACCOUNT ROUTES */
Route::post('/account/create', [AccountController::class, 'store']);

Route::get('/account/get_details/', [AccountController::class, 'show']);

Route::patch('/account/update_details', [AccountController::class, 'update']);

Route::delete('/account/delete_account', [AccountController::class, 'destroy']);

/* DEPOSIT  ROUTES */
Route::get('/account/deposit', [DepositController::class, 'show']);

Route::post('/account/deposit/create', [DepositController::class, 'create']);

/* TRASNSFER ROUTES */
Route::get('/account/transfer', [TransferController::class, 'show']);

Route::post('/account/transfer', [TransferController::class, 'store']);

/* CHANGR THRMES */
Route::post('/dashboard/settings/themes', [SettingsController::class, 'store']);