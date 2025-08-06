<?php

use App\Http\Controllers\Api\ChatController;
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
Route::middleware(['jwt.auth'])->group(function () {
    Route::post("userupdate", [UserController::class, "updateUser"])->name("update user");
    Route::post("add contant", [UserController::class, "addContact"])->name("add contact");
    Route::get("add convs/{contact_id}", [UserController::class, "addContactToConversation"])->name("add convs");
    Route::get("user contacts", [ChatController::class, "userContacts"])->name("user contacts");
    Route::get("current chat/{id}", [ChatController::class, "currentChat"])->name("current chat");
    Route::get("chat messages/{id}", [ChatController::class, "getMessages"])->name("chat message");
    Route::post("send msg", [ChatController::class, "sendMessage"])->name("send msg");
    Route::get("user-conversations/{id?}", [ChatController::class, "getConversations"])->name("user conversations");
});

