@extends('settings.layout')
@section('title', 'Usuários')
@section('settings-content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold">Usuários</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Gerencie usuários, roles e grupos de acesso.</p>
    </div>
    <a href="{{ route('admin.users.create') }}" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2 rounded-xl transition">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Novo usuário
    </a>
</div>

<div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 dark:bg-gray-700/50 border-b border-gray-200 dark:border-gray-700">
            <tr>
                <th class="text-left px-5 py-3 font-medium text-gray-600 dark:text-gray-300">Usuário</th>
                <th class="text-left px-5 py-3 font-medium text-gray-600 dark:text-gray-300">Role</th>
                <th class="text-left px-5 py-3 font-medium text-gray-600 dark:text-gray-300">Grupos</th>
                <th class="text-left px-5 py-3 font-medium text-gray-600 dark:text-gray-300">Status</th>
                <th class="px-5 py-3"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
            @foreach($users as $user)
            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition">
                <td class="px-5 py-3">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center text-indigo-600 dark:text-indigo-400 font-bold text-xs flex-shrink-0">
                            {{ substr($user->name, 0, 2) }}
                        </div>
                        <div>
                            <p class="font-medium text-gray-900 dark:text-white">{{ $user->name }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $user->email }}</p>
                        </div>
                    </div>
                </td>
                <td class="px-5 py-3">
                    @if($user->role)
                    <span class="text-xs font-medium px-2 py-1 rounded-lg
                        {{ $user->role->name === 'admin' ? 'bg-purple-100 text-purple-700 dark:bg-purple-900 dark:text-purple-300' :
                           ($user->role->name === 'editor' ? 'bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-300' :
                           'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300') }}">
                        {{ $user->role->label }}
                    </span>
                    @else
                    <span class="text-xs text-gray-400">—</span>
                    @endif
                </td>
                <td class="px-5 py-3">
                    <div class="flex flex-wrap gap-1">
                        @foreach($user->groups as $group)
                        <span class="text-xs px-2 py-0.5 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300">{{ $group->label }}</span>
                        @endforeach
                    </div>
                </td>
                <td class="px-5 py-3">
                    <span class="text-xs font-medium px-2 py-1 rounded-lg {{ $user->active ? 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300' : 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300' }}">
                        {{ $user->active ? 'Ativo' : 'Inativo' }}
                    </span>
                </td>
                <td class="px-5 py-3 text-right">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('admin.users.edit', $user) }}" class="text-xs text-indigo-600 dark:text-indigo-400 hover:underline">Editar</a>
                        @if($user->id !== auth()->id())
                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Remover {{ $user->name }}?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-xs text-red-500 hover:underline">Remover</button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="px-5 py-4 border-t border-gray-100 dark:border-gray-700">{{ $users->links() }}</div>
</div>
@endsection
