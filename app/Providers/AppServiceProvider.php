<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Interface\IPost;
use App\Repositories\Implementation\PostRepository;
use App\Repositories\Implementation\UserRepository;
use App\Repositories\Interface\IUser;
use App\Services\Interface\IAuthService;
use App\Services\Interface\IPostService;
use App\Services\AuthService;
use App\Services\PostService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(IPost::class, PostRepository::class);
        $this->app->bind(IUser::class,UserRepository::class);
        $this->app->bind(IAuthService::class,AuthService::class);
        $this->app->bind(IPostService::class,PostService::class);
    

    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        //
    }
}
