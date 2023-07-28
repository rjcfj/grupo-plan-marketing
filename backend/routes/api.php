<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EletrodomesticoController;
use App\Http\Controllers\MarcaController;

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

Route::get('/',  function () {
    return response()->json([
        "project" => "API Grupo Plan Marketing",
        "version" => "1.0.0",
        "license" => "MIT",
        "author" =>
        [
            "name" => "Ricardo Junior",
            "email" => "ricardojcfj@gmail.com"
        ]
    ]);
});

Route::apiResource('eletrodomestico', EletrodomesticoController::class);
Route::apiResource('marca', MarcaController::class);
