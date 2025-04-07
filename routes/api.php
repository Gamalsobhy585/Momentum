<?php

use Illuminate\Support\Facades\Route;


Route::middleware(["lang", "cors"])->group(function () {
    require __DIR__ . '/api/authentication.php';
    require __DIR__ . '/api/post.php';
});

















