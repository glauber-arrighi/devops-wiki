@extends('layouts.app')
@section('title', 'Editar artigo')
@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 mb-6">
        <a href="{{ route('articles.index') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition">Artigos</a>
        <span>/</span>
        <a href="{{ route('articles.show', $article) }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition truncate">{{ $article->title }}</a>
        <span>/</span><span>Editar</span>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-8">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Editar artigo</h1>
        <form method="POST" action="{{ route('articles.update', $article) }}" class="space-y-6">
            @csrf @method('PUT')
            @include('articles._form', ['groups' => $groups, 'tags' => $tags, 'article' => $article])
            <div class="flex items-center gap-3 pt-4 border-t border-gray-100 dark:border-gray-700">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-6 py-2 rounded-xl transition">Atualizar artigo</button>
                <a href="{{ route('articles.show', $article) }}" class="text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 transition">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
