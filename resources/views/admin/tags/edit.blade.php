@extends('settings.layout')
@section('title', 'Editar tag')
@section('settings-content')
<div class="max-w-sm mx-auto">
    <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 mb-6">
        <a href="{{ route('admin.tags.index') }}" class="hover:text-indigo-600 transition">Tags</a>
        <span>/</span><span>{{ $tag->name }}</span>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-8">
        <h1 class="text-2xl font-bold mb-6">Editar tag</h1>
        <form method="POST" action="{{ route('admin.tags.update', $tag) }}" class="space-y-5">
            @csrf @method('PUT')
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nome *</label>
                <input type="text" name="name" value="{{ old('name', $tag->name) }}" required class="w-full text-sm bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Cor</label>
                <input type="color" name="color" value="{{ old('color', $tag->color) }}" class="h-10 w-16 rounded-lg border border-gray-200 dark:border-gray-600 cursor-pointer">
            </div>
            <div class="flex gap-3 pt-4 border-t border-gray-100 dark:border-gray-700">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-6 py-2 rounded-xl transition">Salvar</button>
                <a href="{{ route('admin.tags.index') }}" class="text-sm text-gray-500 hover:text-gray-700 transition self-center">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
