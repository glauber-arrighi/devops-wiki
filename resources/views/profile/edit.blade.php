@extends('layouts.app')
@section('title', 'Meu perfil')
@section('content')
<div class="max-w-3xl mx-auto">
    <h1 class="text-2xl font-bold mb-6">Meu perfil</h1>

    {{-- Avatar + info --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-6 mb-5 flex items-center gap-6">
        <div class="relative group">
            <img src="{{ $user->avatarUrl() }}" alt="{{ $user->name }}"
                 class="w-20 h-20 rounded-full object-cover border-2 border-indigo-200 dark:border-indigo-700">
            <div class="absolute inset-0 bg-black/40 rounded-full opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
        </div>
        <div>
            <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $user->name }}</p>
            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $user->email }}</p>
            <div class="flex items-center gap-2 mt-2">
                @if($user->role)
                <span class="text-xs font-medium px-2 py-0.5 rounded-full
                    {{ $user->role->name === 'admin' ? 'bg-purple-100 text-purple-700 dark:bg-purple-900 dark:text-purple-300' :
                       ($user->role->name === 'editor' ? 'bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-300' :
                       'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300') }}">
                    {{ $user->role->label }}
                </span>
                @endif
                @foreach($user->groups as $group)
                <span class="text-xs px-2 py-0.5 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300">{{ $group->label }}</span>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Dados pessoais --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-6 mb-5">
        <h2 class="text-base font-semibold text-gray-900 dark:text-white mb-5">Dados pessoais</h2>
        @if(session('success'))
        <div class="bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-700 text-green-700 dark:text-green-300 px-4 py-3 rounded-xl text-sm mb-5">{{ session('success') }}</div>
        @endif
        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-5">
            @csrf @method('PATCH')

            {{-- Avatar upload --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Foto de perfil</label>
                <div class="flex items-center gap-4">
                    <img id="avatar-preview" src="{{ $user->avatarUrl() }}" class="w-12 h-12 rounded-full object-cover border border-gray-200 dark:border-gray-600">
                    <label class="cursor-pointer text-sm bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 hover:border-indigo-400 transition px-4 py-2 rounded-xl text-gray-600 dark:text-gray-300">
                        Escolher imagem
                        <input type="file" name="avatar" accept="image/*" class="hidden" onchange="previewAvatar(this)">
                    </label>
                    <span class="text-xs text-gray-400">JPG, PNG ou WebP — máx. 2MB</span>
                </div>
                @error('avatar')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nome *</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full text-sm bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">E-mail *</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full text-sm bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Cargo</label>
                    <input type="text" name="job_title" value="{{ old('job_title', $user->job_title) }}" placeholder="ex: DevOps Engineer" class="w-full text-sm bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Telefone</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="(51) 99999-9999" class="w-full text-sm bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Localização</label>
                    <input type="text" name="location" value="{{ old('location', $user->location) }}" placeholder="ex: Porto Alegre, RS" class="w-full text-sm bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Bio</label>
                <textarea name="bio" rows="3" placeholder="Conte um pouco sobre você..." class="w-full text-sm bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('bio', $user->bio) }}</textarea>
                <p class="text-xs text-gray-400 mt-1">Máximo 500 caracteres.</p>
            </div>

            <div class="pt-4 border-t border-gray-100 dark:border-gray-700">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-6 py-2 rounded-xl transition">Salvar perfil</button>
            </div>
        </form>
    </div>

    {{-- Alterar senha --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-6 mb-5">
        <h2 class="text-base font-semibold text-gray-900 dark:text-white mb-5">Alterar senha</h2>
        <form method="POST" action="{{ route('profile.password') }}" class="space-y-4">
            @csrf @method('PATCH')
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Senha atual *</label>
                <input type="password" name="current_password" required class="w-full text-sm bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                @error('current_password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nova senha *</label>
                    <input type="password" name="password" required class="w-full text-sm bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Confirmar senha *</label>
                    <input type="password" name="password_confirmation" required class="w-full text-sm bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>
            <p class="text-xs text-gray-400">Mínimo 8 caracteres com maiúsculas, minúsculas e números.</p>
            <div class="pt-4 border-t border-gray-100 dark:border-gray-700">
                <button type="submit" class="bg-gray-800 dark:bg-gray-600 hover:bg-gray-700 text-white font-medium px-6 py-2 rounded-xl transition">Alterar senha</button>
            </div>
        </form>
    </div>

    {{-- Zona de perigo --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-red-200 dark:border-red-800 p-6">
        <h2 class="text-base font-semibold text-red-600 dark:text-red-400 mb-2">Zona de perigo</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Ao deletar sua conta todos os seus dados serão removidos permanentemente.</p>
        <div x-data="{ open: false }">
            <button @click="open = true" class="text-sm text-red-600 dark:text-red-400 border border-red-300 dark:border-red-700 hover:bg-red-50 dark:hover:bg-red-900/30 px-4 py-2 rounded-xl transition">Deletar minha conta</button>
            <div x-show="open" class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center" @click.self="open = false">
                <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-6 max-w-sm w-full mx-4">
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Confirmar exclusão</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Digite sua senha para confirmar.</p>
                    <form method="POST" action="{{ route('profile.destroy') }}">
                        @csrf @method('DELETE')
                        <input type="password" name="password" required placeholder="Sua senha" class="w-full text-sm bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl px-3 py-2.5 mb-4 focus:outline-none focus:ring-2 focus:ring-red-500">
                        <div class="flex gap-3">
                            <button type="submit" class="flex-1 bg-red-600 hover:bg-red-700 text-white font-medium py-2 rounded-xl transition text-sm">Deletar conta</button>
                            <button type="button" @click="open = false" class="flex-1 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 font-medium py-2 rounded-xl transition text-sm">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function previewAvatar(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('avatar-preview').src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
