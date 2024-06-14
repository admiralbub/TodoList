<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\TodoList;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use App\Contracts\Services\TodoListService\TodoListServiceInterface;
use App\Services\TodoListService\TodoListService;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->bind(
            TodoListServiceInterface::class,
            TodoListService::class
        );
        Gate::define('update-todo', function (User $user, TodoList $todolist) {
            return  $user->id === $todolist->user_id;
        });
        Gate::define('update-status', function (User $user, TodoList $todolist) {
            return  $user->id === $todolist->user_id;
        });
        Gate::define('delete-todo', function (User $user, TodoList $todolist) {
            return  $user->id === $todolist->user_id;
        });
    }
}
