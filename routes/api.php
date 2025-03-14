<?php

use App\Http\Controllers\TextController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/text/process', [TextController::class, 'process']);
