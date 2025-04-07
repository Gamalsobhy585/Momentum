<?php

namespace app\Providers;

use Illuminate\Support\ServiceProvider;
use app\Repositories\Interface\IPost;
use app\Repositories\Implementation\PostRepository;
use app\Repositories\Implementation\UserRepository;
use app\Repositories\Interface\IUser;
use app\Services\Interface\IAuthService;
use app\Services\Interface\IPostService;
use app\Services\AuthService;
use app\Services\PostService;

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
