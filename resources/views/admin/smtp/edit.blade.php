@extends('settings.layout')
@section('title', 'Configuração SMTP')
@section('settings-content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold mb-2">Configuração de e-mail</h1>
    <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">Configure o servidor SMTP para envio de e-mails e reset de senha.</p>

    @if(session('success'))
    <div class="bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-700 text-green-700 dark:text-green-300 px-4 py-3 rounded-xl text-sm mb-6">{{ session('success') }}</div>
    @endif
    @if($errors->any())
    <div class="bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-700 text-red-700 dark:text-red-300 px-4 py-3 rounded-xl text-sm mb-6">{{ $errors->first('error') ?? $errors->first() }}</div>
    @endif

    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-8 mb-4">
        <form method="POST" action="{{ route('admin.smtp.update') }}" class="space-y-5">
            @csrf
            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2 md:col-span-1">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Host SMTP *</label>
                    <input type="text" name="host" value="{{ old('host', $smtp?->host) }}" placeholder="smtp.gmail.com" required class="w-full text-sm bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Porta *</label>
                    <input type="number" name="port" value="{{ old('port', $smtp?->port ?? 587) }}" required class="w-full text-sm bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Protocolo</label>
                <select name="encryption" class="w-full text-sm bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="tls" @selected(old('encryption', $smtp?->encryption ?? 'tls')==='tls')>TLS (porta 587)</option>
                    <option value="ssl" @selected(old('encryption', $smtp?->encryption)==='ssl')>SSL (porta 465)</option>
                    <option value="none" @selected(old('encryption', $smtp?->encryption)==='none')>Nenhum</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Usuário / E-mail *</label>
                <input type="text" name="username" value="{{ old('username', $smtp?->username) }}" placeholder="seuemail@gmail.com" required class="w-full text-sm bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Senha / App Password <span class="text-xs text-gray-400">(deixe em branco para manter)</span></label>
                <input type="password" name="password" class="w-full text-sm bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <p class="text-xs text-gray-400 mt-1">Para Gmail use uma App Password gerada em myaccount.google.com → Segurança → Senhas de app.</p>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">E-mail remetente *</label>
                    <input type="email" name="from_address" value="{{ old('from_address', $smtp?->from_address) }}" required class="w-full text-sm bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nome remetente *</label>
                    <input type="text" name="from_name" value="{{ old('from_name', $smtp?->from_name ?? 'DevOps Wiki') }}" required class="w-full text-sm bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>
            <div class="flex items-center gap-3 pt-4 border-t border-gray-100 dark:border-gray-700">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-6 py-2 rounded-xl transition">Salvar configurações</button>
                @if($smtp)
                <form method="POST" action="{{ route('admin.smtp.test') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-sm text-gray-600 dark:text-gray-300 border border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 px-4 py-2 rounded-xl transition">Testar conexão</button>
                </form>
                @if($smtp->tested_at)
                <span class="text-xs {{ $smtp->last_test_ok ? 'text-green-500' : 'text-red-500' }}">
                    {{ $smtp->last_test_ok ? '✓ Último teste OK' : '✗ Último teste falhou' }} — {{ $smtp->tested_at->diffForHumans() }}
                </span>
                @endif
                @endif
            </div>
        </form>
    </div>
</div>
@endsection
