<?php

use App\Http\Controllers\ApiPostController;
use Illuminate\Support\Facades\Route;

Route::get('/listes_postes',[ApiPostController::class,'index']);