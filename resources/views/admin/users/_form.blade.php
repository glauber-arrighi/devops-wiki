@php $editing = isset($editing) && $editing; @endphp

<div>
    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nome *</label>
    <input type="text" name="name" value="{{ old('name', $editing ? $user->name : '') }}" required class="w-full text-sm bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500">
    @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
</div>

<div>
    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">E-mail *</label>
    <input type="email" name="email" value="{{ old('email', $editing ? $user->email : '') }}" required class="w-full text-sm bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500">
    @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
</div>

<div>
    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
        Senha {{ $editing ? '(deixe em branco para manter)' : '*' }}
    </label>
    <input type="password" name="password" {{ $editing ? '' : 'required' }} class="w-full text-sm bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500">
    <p class="text-xs text-gray-400 mt-1">Mínimo 8 caracteres, letras maiúsculas, minúsculas e números.</p>
    @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
</div>

<div>
    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Role *</label>
    <select name="role_id" required class="w-full text-sm bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500">
        <option value="">Selecione...</option>
        @foreach($roles as $role)
        <option value="{{ $role->id }}" @selected(old('role_id', $editing ? $user->role_id : '') == $role->id)>{{ $role->label }}</option>
        @endforeach
    </select>
    @error('role_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
</div>

<div>
    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Grupos de acesso</label>
    <div class="flex flex-wrap gap-2">
        @foreach($groups as $group)
        <label class="flex items-center gap-2 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl px-3 py-2 cursor-pointer hover:border-indigo-400 transition has-[:checked]:border-indigo-500 has-[:checked]:bg-indigo-50 dark:has-[:checked]:bg-indigo-900">
            <input type="checkbox" name="groups[]" value="{{ $group->id }}" class="rounded" @checked(in_array($group->id, old('groups', $editing ? $user->groups->pluck('id')->toArray() : [])))>
            <span class="text-sm text-gray-700 dark:text-gray-300">{{ $group->label }}</span>
        </label>
        @endforeach
    </div>
</div>

<div class="flex items-center gap-3">
    <label class="flex items-center gap-2 cursor-pointer">
        <input type="checkbox" name="active" value="1" class="rounded" @checked(old('active', $editing ? $user->active : true))>
        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Usuário ativo</span>
    </label>
</div>
