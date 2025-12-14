<?php

use App\Http\Controllers\ApiPostController;
use Illuminate\Support\Facades\Route;

Route::get('/allPostes',[ApiPostController::class,'AllPostes']);


Route::post('/postes',[ApiPostController::class,'savePostes']);
Route::get('/postes/{id}',[ApiPostController::class,'getPosteById']);
Route::put('/postes/{id}',[ApiPostController::class,'updatePostes']);
Route::delete('/postes/{id}',[ApiPostController::class,'deletePostes']);