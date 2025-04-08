<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;


Route::middleware('auth:sanctum')->group(function () 
{


    Route::prefix('posts')->group(function () 
    {
        Route::get('/', [PostController::class, 'index']);
        Route::get('/deleted', [PostController::class, 'getDeletedPosts']);
        Route::post('/', [PostController::class, 'store']);
    
        Route::delete('/bulk-delete', [PostController::class, 'bulkDelete']);
        Route::post('/bulk-restore', [PostController::class, 'bulkRestore']);
        Route::delete('/bulk-force-delete', [PostController::class, 'bulkForceDelete']);
    
        Route::post('/{id}/restore', [PostController::class, 'restore']);
        Route::delete('/force/{post}', [PostController::class, 'forceDelete']);
        
        Route::get('/{post}', [PostController::class, 'show']);
        Route::patch('/{post}', [PostController::class, 'update']);
        Route::delete('/{post}', [PostController::class, 'destroy']);
    });
    

});



?>