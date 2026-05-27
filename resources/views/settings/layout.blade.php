@extends('layouts.app')
@section('content')
<div class="flex gap-8">

    {{-- Sidebar --}}
    <aside class="w-56 flex-shrink-0">
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-4 sticky top-24">
            <p class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider px-2 mb-3">Configurações</p>
            <nav class="space-y-1">
                @php
                $links = [
                    ['route' => 'admin.users.index',  'label' => 'Usuários',  'icon' => 'ti-users'],
                    ['route' => 'admin.groups.index', 'label' => 'Grupos',    'icon' => 'ti-layout-grid'],
                    ['route' => 'admin.tags.index',   'label' => 'Tags',      'icon' => 'ti-tag'],
                    ['route' => 'admin.smtp.edit',    'label' => 'E-mail',    'icon' => 'ti-mail'],
                ];
                @endphp
                @foreach($links as $link)
                @php $active = request()->routeIs(str_replace('.index','',$link['route']).'*') || request()->routeIs($link['route']); @endphp
                <a href="{{ route($link['route']) }}"
                   class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-sm transition
                   {{ $active ? 'bg-indigo-50 dark:bg-indigo-900/40 text-indigo-600 dark:text-indigo-400 font-medium' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }}">
                    <i class="ti {{ $link['icon'] }} text-base" aria-hidden="true"></i>
                    {{ $link['label'] }}
                </a>
                @endforeach
            </nav>
        </div>
    </aside>

    {{-- Conteúdo --}}
    <div class="flex-1 min-w-0">
        @yield('settings-content')
    </div>

</div>
@endsection
