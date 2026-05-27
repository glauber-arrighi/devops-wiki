@extends('settings.layout')
@section('title', 'Editar grupo')
@section('settings-content')
<div class="max-w-lg mx-auto">
    <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 mb-6">
        <a href="{{ route('admin.groups.index') }}" class="hover:text-indigo-600 transition">Grupos</a>
        <span>/</span><span>{{ $group->label }}</span>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-8">
        <h1 class="text-2xl font-bold mb-6">Editar grupo</h1>
        <form method="POST" action="{{ route('admin.groups.update', $group) }}" class="space-y-5">
            @csrf @method('PUT')
            @include('admin.groups._form')
            <div class="flex gap-3 pt-4 border-t border-gray-100 dark:border-gray-700">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-6 py-2 rounded-xl transition">Salvar</button>
                <a href="{{ route('admin.groups.index') }}" class="text-sm text-gray-500 hover:text-gray-700 transition self-center">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
