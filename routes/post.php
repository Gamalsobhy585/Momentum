<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;


Route::middleware('auth:sanctum')->group(function () 
{


    Route::apiResource('posts', PostController::class);
    Route::get('posts', [PostController::class, 'index']);
    Route::post('posts', [PostController::class, 'store']);
    Route::get('posts/{id}', [PostController::class, 'show']);
    Route::put('posts/{id}', [PostController::class, 'update']);
    Route::delete('posts/{id}', [PostController::class, 'destroy']);
    Route::post('posts/{id}/restore', [PostController::class, 'restore']);


});



?>