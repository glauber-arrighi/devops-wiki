<?php
namespace App\Providers;

use App\Models\Article;
use App\Policies\ArticlePolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Gate::policy(Article::class, ArticlePolicy::class);

        // Admin tem acesso a tudo
        Gate::before(function ($user, $ability) {
            if ($user->isAdmin()) return true;
        });
    }
}
