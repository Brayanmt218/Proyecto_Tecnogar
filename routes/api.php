<?php

use App\Http\Controllers\Admin\ClienteController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/users', [UserController::class, 'index']);
Route::get('/clientes', [ClienteController::class, 'apiIndex']);


