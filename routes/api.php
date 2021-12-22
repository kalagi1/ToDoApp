<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\ToDoItemController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::apiResources([
    "to_do_item" => ToDoItemController::class,
]);

Route::post("/login",[AccountController::class,'login']);

Route::post("/register",[AccountController::class,'register']);
