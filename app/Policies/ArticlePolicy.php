<?php
namespace App\Policies;

use App\Models\Article;
use App\Models\User;

class ArticlePolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Article $article): bool
    {
        if ($user->isAdmin()) return true;
        if ($article->status !== 'published') {
            return $article->author_id === $user->id;
        }
        // Verifica se usuário pertence a algum grupo do artigo
        $articleGroupIds = $article->groups->pluck('id');
        if ($articleGroupIds->isEmpty()) return true;
        return $user->groups->pluck('id')->intersect($articleGroupIds)->isNotEmpty();
    }

    public function create(User $user): bool
    {
        return $user->isEditor();
    }

    public function update(User $user, Article $article): bool
    {
        if ($user->isAdmin()) return true;
        return $user->isEditor() && $article->author_id === $user->id;
    }

    public function delete(User $user, Article $article): bool
    {
        if ($user->isAdmin()) return true;
        return $article->author_id === $user->id;
    }
}
