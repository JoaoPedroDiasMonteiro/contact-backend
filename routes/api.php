<?php

use App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('users', Controllers\UserController::class)->names('users');
Route::apiResource('users.contacts', Controllers\ContactController::class)->scoped()->names('contacts');
