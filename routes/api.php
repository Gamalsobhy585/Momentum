<?php

use Illuminate\Support\Facades\Route;


Route::middleware(["lang", "cors"])->group(function () {
    require __DIR__ . '/authentication.php';
    require __DIR__ . '/post.php';
});


