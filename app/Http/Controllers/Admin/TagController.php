<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TagController extends Controller
{
    public function index() {
        $tags = Tag::withCount('articles')->orderBy('name')->get();
        return view('admin.tags.index', compact('tags'));
    }
    public function create() { return view('admin.tags.create'); }
    public function store(Request $request) {
        $request->validate(['name' => 'required|string|max:50|unique:tags,name', 'color' => 'required|string|max:7']);
        Tag::create(['name' => $request->name, 'slug' => Str::slug($request->name), 'color' => $request->color]);
        return redirect()->route('admin.tags.index')->with('success', 'Tag criada!');
    }
    public function edit(Tag $tag) { return view('admin.tags.edit', compact('tag')); }
    public function update(Request $request, Tag $tag) {
        $request->validate(['name' => "required|string|max:50|unique:tags,name,{$tag->id}", 'color' => 'required|string|max:7']);
        $tag->update(['name' => $request->name, 'slug' => Str::slug($request->name), 'color' => $request->color]);
        return redirect()->route('admin.tags.index')->with('success', 'Tag atualizada!');
    }
    public function destroy(Tag $tag) {
        $tag->delete();
        return redirect()->route('admin.tags.index')->with('success', 'Tag removida.');
    }
}
