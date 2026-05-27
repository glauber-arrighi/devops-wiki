@php $editing = isset($article); @endphp

@error('title')<p class="text-red-500 text-sm mb-2">{{ $message }}</p>@enderror
<div>
    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Título *</label>
    <input type="text" name="title" value="{{ old('title', $editing ? $article->title : '') }}" required class="w-full text-sm bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500">
</div>

<div>
    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Conteúdo *</label>
    <textarea name="content" rows="12" required class="w-full text-sm bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 font-mono">{{ old('content', $editing ? $article->content : '') }}</textarea>
    <p class="text-xs text-gray-400 mt-1">Suporte a Markdown. Imagens e tabelas aceitas.</p>
</div>

<div>
    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Resumo</label>
    <textarea name="excerpt" rows="2" class="w-full text-sm bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('excerpt', $editing ? $article->excerpt : '') }}</textarea>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Prioridade *</label>
        <select name="priority" class="w-full text-sm bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            <option value="low" @selected(old('priority', $editing ? $article->priority : 'medium')==='low')>Baixa</option>
            <option value="medium" @selected(old('priority', $editing ? $article->priority : 'medium')==='medium')>Média</option>
            <option value="high" @selected(old('priority', $editing ? $article->priority : 'medium')==='high')>Alta</option>
            <option value="critical" @selected(old('priority', $editing ? $article->priority : 'medium')==='critical')>Crítica</option>
        </select>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Produto</label>
        <input type="text" name="product" value="{{ old('product', $editing ? $article->product : '') }}" placeholder="ex: intranet, n8n, nexus" class="w-full text-sm bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Área</label>
        <input type="text" name="area" value="{{ old('area', $editing ? $article->area : '') }}" placeholder="ex: infraestrutura, ci-cd" class="w-full text-sm bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500">
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Solicitante</label>
        <input type="text" name="requester" value="{{ old('requester', $editing ? $article->requester : '') }}" class="w-full text-sm bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status *</label>
        <select name="status" class="w-full text-sm bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            <option value="draft" @selected(old('status', $editing ? $article->status : 'draft')==='draft')>Rascunho</option>
            <option value="published" @selected(old('status', $editing ? $article->status : 'draft')==='published')>Publicado</option>
            <option value="archived" @selected(old('status', $editing ? $article->status : 'draft')==='archived')>Arquivado</option>
        </select>
    </div>
</div>

<div>
    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Grupos de acesso</label>
    <div class="flex flex-wrap gap-2">
        @foreach($groups as $group)
        <label class="flex items-center gap-2 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl px-3 py-2 cursor-pointer hover:border-indigo-400 transition has-[:checked]:border-indigo-500 has-[:checked]:bg-indigo-50 dark:has-[:checked]:bg-indigo-900">
            <input type="checkbox" name="groups[]" value="{{ $group->id }}" class="rounded" @checked(in_array($group->id, old('groups', $editing ? $article->groups->pluck('id')->toArray() : [])))>
            <span class="text-sm text-gray-700 dark:text-gray-300">{{ $group->label }}</span>
        </label>
        @endforeach
    </div>
</div>

<div>
    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tags</label>
    <div class="flex flex-wrap gap-2">
        @foreach($tags as $tag)
        <label class="flex items-center gap-2 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl px-3 py-2 cursor-pointer hover:border-indigo-400 transition has-[:checked]:border-indigo-500 has-[:checked]:bg-indigo-50 dark:has-[:checked]:bg-indigo-900">
            <input type="checkbox" name="tags[]" value="{{ $tag->id }}" class="rounded" @checked(in_array($tag->id, old('tags', $editing ? $article->tags->pluck('id')->toArray() : [])))>
            <span class="text-sm text-gray-700 dark:text-gray-300">{{ $tag->name }}</span>
        </label>
        @endforeach
    </div>
</div>
