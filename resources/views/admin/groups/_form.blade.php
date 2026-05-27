@php $editing = isset($group); @endphp
<div>
    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Identificador * <span class="text-xs text-gray-400">(ex: devops, ti-geral)</span></label>
    <input type="text" name="name" value="{{ old('name', $editing ? $group->name : '') }}" required {{ $editing ? 'readonly' : '' }} class="w-full text-sm bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 {{ $editing ? 'opacity-60' : '' }}">
    @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
</div>
<div>
    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nome de exibição *</label>
    <input type="text" name="label" value="{{ old('label', $editing ? $group->label : '') }}" required class="w-full text-sm bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500">
    @error('label')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
</div>
<div>
    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Descrição</label>
    <input type="text" name="description" value="{{ old('description', $editing ? $group->description : '') }}" class="w-full text-sm bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500">
</div>
<div>
    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Cor do badge</label>
    <div class="flex items-center gap-3">
        <input type="color" name="color" value="{{ old('color', $editing ? $group->color : '#6366f1') }}" class="h-10 w-16 rounded-lg border border-gray-200 dark:border-gray-600 cursor-pointer">
        <span class="text-xs text-gray-500 dark:text-gray-400">Cor usada nos badges de grupo</span>
    </div>
</div>
<div>
    <label class="flex items-center gap-2 cursor-pointer">
        <input type="checkbox" name="active" value="1" class="rounded" @checked(old('active', $editing ? $group->active : true))>
        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Grupo ativo</span>
    </label>
</div>
