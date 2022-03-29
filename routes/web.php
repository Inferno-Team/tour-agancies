<?php

use App\Http\Controllers\SpaController;
use Illuminate\Support\Facades\Route;



Route::get('/{any}', [SpaController::class,'index'])->where('any', '.*');
