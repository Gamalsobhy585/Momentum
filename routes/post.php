<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;


Route::middleware('auth:sanctum')->group(function () 
{


    Route::prefix('posts')->group(function () 
    {
        Route::get('/', [PostController::class, 'index']);
        Route::post('/', [PostController::class, 'store']);
        Route::get('/{id}', [PostController::class, 'show']);
        Route::put('/{id}', [PostController::class, 'update']);
        Route::delete('/{id}', [PostController::class, 'destroy']);
        Route::post('/{id}/restore', [PostController::class, 'restore']);
    });

});



?>