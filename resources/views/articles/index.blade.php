@extends('layouts.app')
@section('title', 'Artigos')
@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold">Artigos</h1>
    @if(auth()->user()->isEditor())
    <a href="{{ route('articles.create') }}" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2 rounded-xl transition">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Novo artigo
    </a>
    @endif
</div>

{{-- Filtros --}}
<form method="GET" class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-4 mb-6 flex flex-wrap gap-3">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar artigos..." class="flex-1 min-w-48 text-sm bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
    <select name="priority" class="text-sm bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
        <option value="">Prioridade</option>
        <option value="critical" @selected(request('priority')==='critical')>Crítica</option>
        <option value="high" @selected(request('priority')==='high')>Alta</option>
        <option value="medium" @selected(request('priority')==='medium')>Média</option>
        <option value="low" @selected(request('priority')==='low')>Baixa</option>
    </select>
    <select name="area" class="text-sm bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
        <option value="">Área</option>
        @foreach($areas as $area)
        <option value="{{ $area }}" @selected(request('area')===$area)>{{ $area }}</option>
        @endforeach
    </select>
    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2 rounded-xl transition">Filtrar</button>
    @if(request()->hasAny(['search','priority','area','tag']))
    <a href="{{ route('articles.index') }}" class="text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 px-3 py-2 transition">Limpar</a>
    @endif
</form>

{{-- Tags --}}
@if($tags->count())
<div class="flex flex-wrap gap-2 mb-6">
    @foreach($tags as $tag)
    <a href="{{ route('articles.index', ['tag' => $tag->slug]) }}"
       class="text-xs font-medium px-3 py-1 rounded-full transition {{ request('tag') === $tag->slug ? 'bg-indigo-600 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-indigo-100 dark:hover:bg-indigo-900' }}">
        {{ $tag->name }}
    </a>
    @endforeach
</div>
@endif

{{-- Grid de artigos --}}
@if($articles->count())
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
    @foreach($articles as $article)
    @php
    $priorityColors = ['critical'=>'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300','high'=>'bg-orange-100 text-orange-700 dark:bg-orange-900 dark:text-orange-300','medium'=>'bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-300','low'=>'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300'];
    $priorityLabels = ['critical'=>'Crítica','high'=>'Alta','medium'=>'Média','low'=>'Baixa'];
    @endphp
    <a href="{{ route('articles.show', $article) }}" class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-5 hover:border-indigo-400 dark:hover:border-indigo-500 hover:shadow-md transition group flex flex-col">
        <div class="flex items-start justify-between gap-2 mb-3">
            <span class="text-xs font-medium px-2 py-1 rounded-lg {{ $priorityColors[$article->priority] }}">{{ $priorityLabels[$article->priority] }}</span>
            @if($article->area)
            <span class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ $article->area }}</span>
            @endif
        </div>
        <h2 class="font-semibold text-gray-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition mb-2 line-clamp-2">{{ $article->title }}</h2>
        @if($article->excerpt)
        <p class="text-sm text-gray-500 dark:text-gray-400 line-clamp-2 mb-3 flex-1">{{ $article->excerpt }}</p>
        @endif
        <div class="flex flex-wrap gap-1 mt-auto pt-3 border-t border-gray-100 dark:border-gray-700">
            @foreach($article->tags->take(3) as $tag)
            <span class="text-xs bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 px-2 py-0.5 rounded-full">{{ $tag->name }}</span>
            @endforeach
        </div>
        <div class="flex items-center justify-between mt-2 text-xs text-gray-400 dark:text-gray-500">
            <span>{{ $article->author->name }}</span>
            <span>{{ $article->published_at->diffForHumans() }}</span>
        </div>
    </a>
    @endforeach
</div>
<div class="mt-6">{{ $articles->links() }}</div>
@else
<div class="text-center py-16 text-gray-500 dark:text-gray-400">
    <svg class="w-12 h-12 mx-auto mb-4 opacity-30" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
    <p class="font-medium">Nenhum artigo encontrado</p>
    @if(auth()->user()->isEditor())
    <a href="{{ route('articles.create') }}" class="mt-3 inline-block text-indigo-600 dark:text-indigo-400 hover:underline text-sm">Criar o primeiro artigo</a>
    @endif
</div>
@endif
@endsection
