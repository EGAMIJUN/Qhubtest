<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Category;
use App\Models\Post;
use App\Models\TransCategory;
use App\Models\Report;
use Illuminate\Support\Facades\Auth;

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
        View::composer('*', function ($view) {
            $view->with('all_categories', Category::all());
            $view->with('all_trans_categories', TransCategory::all());
        });

        // View::composer('layouts.app', function ($view) {
        //     $latestWarning = Report::whereHas('post.user', function ($query) {
        //             $query->where('id', Auth::id());
        //         })
        //         ->whereNotNull('message') // messageがNULLでない
        //         ->where('message', '!=', '') // 空文字でない
        //         ->where('active', true) // activeがtrue
        //         ->latest()
        //         ->first();

        //     $view->with('latestWarning', $latestWarning);
        // });

    }
}
