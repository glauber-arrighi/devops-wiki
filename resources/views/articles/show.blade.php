@extends('layouts.app')
@section('title', $article->title)
@section('content')
@php
$priorityColors = ['critical'=>'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300','high'=>'bg-orange-100 text-orange-700 dark:bg-orange-900 dark:text-orange-300','medium'=>'bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-300','low'=>'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300'];
$priorityLabels = ['critical'=>'Crítica','high'=>'Alta','medium'=>'Média','low'=>'Baixa'];
@endphp

<div class="max-w-4xl mx-auto">
    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 mb-6">
        <a href="{{ route('articles.index') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition">Artigos</a>
        <span>/</span>
        <span class="truncate text-gray-700 dark:text-gray-200">{{ $article->title }}</span>
    </div>

    {{-- Header --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-8 mb-6">
        <div class="flex flex-wrap items-center gap-2 mb-4">
            <span class="text-xs font-medium px-2 py-1 rounded-lg {{ $priorityColors[$article->priority] }}">{{ $priorityLabels[$article->priority] }}</span>
            @if($article->area)
            <span class="text-xs bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 px-2 py-1 rounded-lg">{{ $article->area }}</span>
            @endif
            @if($article->product)
            <span class="text-xs bg-indigo-100 dark:bg-indigo-900 text-indigo-600 dark:text-indigo-400 px-2 py-1 rounded-lg">{{ $article->product }}</span>
            @endif
        </div>

        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">{{ $article->title }}</h1>

        <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500 dark:text-gray-400 pb-4 border-b border-gray-100 dark:border-gray-700">
            <span class="flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                {{ $article->author->name }}
            </span>
            <span class="flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                {{ $article->published_at->format('d/m/Y') }}
            </span>
            <span class="flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                {{ $article->views }} visualizações
            </span>
            @if($article->requester)
            <span>Solicitante: <strong>{{ $article->requester }}</strong></span>
            @endif
        </div>

        {{-- Tags --}}
        @if($article->tags->count())
        <div class="flex flex-wrap gap-2 mt-4">
            @foreach($article->tags as $tag)
            <a href="{{ route('articles.index', ['tag' => $tag->slug]) }}" class="text-xs bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-indigo-100 dark:hover:bg-indigo-900 px-2 py-1 rounded-full transition">{{ $tag->name }}</a>
            @endforeach
        </div>
        @endif
    </div>

    {{-- Conteúdo --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-8 mb-6 prose prose-gray dark:prose-invert max-w-none">
        {!! nl2br(e($article->content)) !!}
    </div>

    {{-- Anexos --}}
    @if($article->attachments->count())
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-6 mb-6">
        <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Anexos</h3>
        <div class="space-y-2">
            @foreach($article->attachments as $attachment)
            <a href="{{ Storage::url($attachment->path) }}" target="_blank" class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-gray-700 rounded-xl hover:bg-indigo-50 dark:hover:bg-indigo-900 transition">
                <svg class="w-5 h-5 text-indigo-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                <span class="text-sm text-gray-700 dark:text-gray-300 truncate">{{ $attachment->filename }}</span>
                <span class="text-xs text-gray-400 ml-auto">{{ number_format($attachment->size / 1024, 1) }} KB</span>
            </a>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Ações --}}
    <div class="flex items-center gap-3">
        <a href="{{ route('articles.index') }}" class="text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition">← Voltar</a>
        @can('update', $article)
        <a href="{{ route('articles.edit', $article) }}" class="ml-auto inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2 rounded-xl transition">Editar</a>
        @endcan
        @can('delete', $article)
        <form method="POST" action="{{ route('articles.destroy', $article) }}" onsubmit="return confirm('Remover este artigo?')">
            @csrf @method('DELETE')
            <button type="submit" class="text-sm text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 transition">Remover</button>
        </form>
        @endcan
    </div>
</div>
@endsection
