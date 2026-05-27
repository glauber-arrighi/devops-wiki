@extends('settings.layout')
@section('title', 'Editar usuário')
@section('settings-content')
<div class="max-w-2xl mx-auto">
    <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 mb-6">
        <a href="{{ route('admin.users.index') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition">Usuários</a>
        <span>/</span><span>{{ $user->name }}</span>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-8">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Editar usuário</h1>
        <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-5">
            @csrf @method('PUT')
            @include('admin.users._form', ['editing' => true])
            <div class="flex items-center gap-3 pt-4 border-t border-gray-100 dark:border-gray-700">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-6 py-2 rounded-xl transition">Salvar alterações</button>
                <a href="{{ route('admin.users.index') }}" class="text-sm text-gray-500 hover:text-gray-700 transition">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
