<?php
namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Group;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ArticleController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Article::with(['author', 'tags', 'groups'])
            ->published()
            ->visibleTo($user);

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', "%{$request->search}%")
                  ->orWhere('excerpt', 'like', "%{$request->search}%");
            });
        }

        if ($request->tag) {
            $query->whereHas('tags', fn($q) => $q->where('slug', $request->tag));
        }

        if ($request->priority) {
            $query->where('priority', $request->priority);
        }

        if ($request->area) {
            $query->where('area', $request->area);
        }

        $articles = $query->latest('published_at')->paginate(12)->withQueryString();
        $tags     = Tag::orderBy('name')->get();
        $areas    = Article::published()->visibleTo($user)->distinct()->pluck('area')->filter()->sort()->values();

        return view('articles.index', compact('articles', 'tags', 'areas'));
    }

    public function create()
    {
        $this->authorize('create', Article::class);
        $groups = Group::where('active', true)->orderBy('label')->get();
        $tags   = Tag::orderBy('name')->get();
        return view('articles.create', compact('groups', 'tags'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Article::class);

        $validated = $request->validate([
            'title'     => 'required|string|max:255',
            'content'   => 'required|string',
            'excerpt'   => 'nullable|string|max:500',
            'priority'  => 'required|in:low,medium,high,critical',
            'product'   => 'nullable|string|max:100',
            'area'      => 'nullable|string|max:100',
            'requester' => 'nullable|string|max:100',
            'status'    => 'required|in:draft,published,archived',
            'groups'    => 'nullable|array',
            'groups.*'  => 'exists:groups,id',
            'tags'      => 'nullable|array',
            'tags.*'    => 'exists:tags,id',
        ]);

        $article = Article::create([
            ...$validated,
            'slug'         => Str::slug($validated['title']) . '-' . Str::random(6),
            'author_id'    => Auth::id(),
            'published_at' => $validated['status'] === 'published' ? now() : null,
        ]);

        $article->groups()->sync($request->groups ?? []);
        $article->tags()->sync($request->tags ?? []);

        return redirect()->route('articles.show', $article)
            ->with('success', 'Artigo criado com sucesso!');
    }

    public function show(Article $article)
    {
        $this->authorize('view', $article);
        $article->increment('views');
        $article->load(['author', 'tags', 'groups', 'attachments']);
        return view('articles.show', compact('article'));
    }

    public function edit(Article $article)
    {
        $this->authorize('update', $article);
        $groups = Group::where('active', true)->orderBy('label')->get();
        $tags   = Tag::orderBy('name')->get();
        return view('articles.edit', compact('article', 'groups', 'tags'));
    }

    public function update(Request $request, Article $article)
    {
        $this->authorize('update', $article);

        $validated = $request->validate([
            'title'     => 'required|string|max:255',
            'content'   => 'required|string',
            'excerpt'   => 'nullable|string|max:500',
            'priority'  => 'required|in:low,medium,high,critical',
            'product'   => 'nullable|string|max:100',
            'area'      => 'nullable|string|max:100',
            'requester' => 'nullable|string|max:100',
            'status'    => 'required|in:draft,published,archived',
            'groups'    => 'nullable|array',
            'groups.*'  => 'exists:groups,id',
            'tags'      => 'nullable|array',
            'tags.*'    => 'exists:tags,id',
        ]);

        if ($validated['status'] === 'published' && !$article->published_at) {
            $validated['published_at'] = now();
        }

        $article->update($validated);
        $article->groups()->sync($request->groups ?? []);
        $article->tags()->sync($request->tags ?? []);

        return redirect()->route('articles.show', $article)
            ->with('success', 'Artigo atualizado com sucesso!');
    }

    public function destroy(Article $article)
    {
        $this->authorize('delete', $article);
        $article->delete();
        return redirect()->route('articles.index')
            ->with('success', 'Artigo removido.');
    }
}
