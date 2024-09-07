<?php

namespace App\Providers;

use App\Services\AuthServiceInterface;
use App\Services\PostServiceInterface;
use App\Services\UserServiceInterface;
use App\Repositories\CommentRepository;
use App\Repositories\CommentRepositoryInterface;
use App\Repositories\PostRepository;
use App\Repositories\PostRepositoryInterface;
use App\Repositories\UserRepository;
use App\Repositories\UserRepositoryInterface;
use App\Services\AuthService;
use App\Services\PostService;
use App\Services\UserService;
use Illuminate\Database\Connection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Bind services interfaces to implementations
        $this->app->bind(AuthServiceInterface::class, AuthService::class);
        $this->app->bind(UserServiceInterface::class, UserService::class);
        $this->app->bind(PostServiceInterface::class, PostService::class);

        // Bind repository interfaces to implementations
        $this->app->bind(PostRepositoryInterface::class, PostRepository::class);
        $this->app->bind(CommentRepositoryInterface::class, CommentRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Config rate limiting
        $this->configRateLimiting();

        // Everything strict, all the time.
        Model::shouldBeStrict();

        // Log a warning if we spend more than a total of 2000ms querying.
        DB::whenQueryingForLongerThan(2000, function (Connection $connection) {
            Log::warning("Database queries exceeded 2 seconds on {$connection->getName()}");
        });
    }

    /**
     * Configure the rate limiters for the application.
     */
    protected function configRateLimiting()
    {
        // Default rate limiter for the 'api' routes, allowing 60 requests per minute.
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(30)->by(optional($request->user())->id ?: $request->ip());
        });

        // Custom rate limiter for 'test' route, with different limits per second and per minute.
        RateLimiter::for('test', function (Request $request) {
            return [
                Limit::perSecond(1)->by($request->ip()), // Limit to 1 request per second by IP address.
                Limit::perMinute(10)->by($request->ip()), // Limit to 10 requests per minute by IP address.
            ];
        });
    }
}
