<?php

use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::middleware(['jwt.auth'])->group(function () {
//     Route::get('/user', function () {
//         return auth()->user(); // Now this will work
//     });
// });

Route::post("/login", [LoginController::class, "login"])->name("api login");

Route::apiResources([
    'user' => UserController::class,
]);
Route::post("add contant",[UserController::class, "addContact"])->name("add contact");
// Route::post("add contant by username",[UserController::class, "addContactByUserName"])->name("add contact by username");
Route::middleware(['jwt.auth'])->group(function () {
});
