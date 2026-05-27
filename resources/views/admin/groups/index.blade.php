@extends('settings.layout')
@section('title', 'Grupos')
@section('settings-content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold">Grupos de atuação</h1>
    <a href="{{ route('admin.groups.create') }}" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2 rounded-xl transition">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Novo grupo
    </a>
</div>
<div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 dark:bg-gray-700/50 border-b border-gray-200 dark:border-gray-700">
            <tr>
                <th class="text-left px-5 py-3 font-medium text-gray-600 dark:text-gray-300">Grupo</th>
                <th class="text-left px-5 py-3 font-medium text-gray-600 dark:text-gray-300">Identificador</th>
                <th class="text-left px-5 py-3 font-medium text-gray-600 dark:text-gray-300">Usuários</th>
                <th class="text-left px-5 py-3 font-medium text-gray-600 dark:text-gray-300">Status</th>
                <th class="px-5 py-3"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
            @foreach($groups as $group)
            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition">
                <td class="px-5 py-3">
                    <div class="flex items-center gap-3">
                        <div class="w-3 h-3 rounded-full flex-shrink-0" style="background-color: {{ $group->color }}"></div>
                        <div>
                            <p class="font-medium text-gray-900 dark:text-white">{{ $group->label }}</p>
                            @if($group->description)<p class="text-xs text-gray-500 dark:text-gray-400">{{ $group->description }}</p>@endif
                        </div>
                    </div>
                </td>
                <td class="px-5 py-3"><code class="text-xs bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded">{{ $group->name }}</code></td>
                <td class="px-5 py-3 text-gray-600 dark:text-gray-300">{{ $group->users_count }}</td>
                <td class="px-5 py-3">
                    <span class="text-xs font-medium px-2 py-1 rounded-lg {{ $group->active ? 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300' : 'bg-gray-100 text-gray-500 dark:bg-gray-700 dark:text-gray-400' }}">
                        {{ $group->active ? 'Ativo' : 'Inativo' }}
                    </span>
                </td>
                <td class="px-5 py-3 text-right">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('admin.groups.edit', $group) }}" class="text-xs text-indigo-600 dark:text-indigo-400 hover:underline">Editar</a>
                        <form method="POST" action="{{ route('admin.groups.destroy', $group) }}" onsubmit="return confirm('Remover grupo {{ $group->label }}?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-xs text-red-500 hover:underline">Remover</button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
