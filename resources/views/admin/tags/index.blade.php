@extends('settings.layout')
@section('title', 'Tags')
@section('settings-content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold">Tags</h1>
    <a href="{{ route('admin.tags.create') }}" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2 rounded-xl transition">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Nova tag
    </a>
</div>
<div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-6">
    <div class="flex flex-wrap gap-3">
        @foreach($tags as $tag)
        <div class="flex items-center gap-2 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl px-3 py-2">
            <div class="w-2.5 h-2.5 rounded-full flex-shrink-0" style="background-color: {{ $tag->color }}"></div>
            <span class="text-sm font-medium text-gray-800 dark:text-gray-200">{{ $tag->name }}</span>
            <span class="text-xs text-gray-400">({{ $tag->articles_count }})</span>
            <a href="{{ route('admin.tags.edit', $tag) }}" class="text-xs text-indigo-500 hover:underline ml-1">Editar</a>
            <form method="POST" action="{{ route('admin.tags.destroy', $tag) }}" onsubmit="return confirm('Remover tag?')" class="inline">
                @csrf @method('DELETE')
                <button type="submit" class="text-xs text-red-400 hover:underline">×</button>
            </form>
        </div>
        @endforeach
    </div>
</div>
@endsection
