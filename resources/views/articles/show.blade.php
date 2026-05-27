@extends('layouts.app')
@section('title', $article->title)
@section('content')
@php
$priorityColors = ['critical'=>'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300','high'=>'bg-orange-100 text-orange-700 dark:bg-orange-900 dark:text-orange-300','medium'=>'bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-300','low'=>'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300'];
$priorityLabels = ['critical'=>'Crítica','high'=>'Alta','medium'=>'Média','low'=>'Baixa'];
$mimeIcons = ['application/pdf'=>'ti-file-type-pdf','image/png'=>'ti-photo','image/jpeg'=>'ti-photo','image/gif'=>'ti-photo','image/webp'=>'ti-photo','application/zip'=>'ti-file-zip','text/plain'=>'ti-file-text','application/json'=>'ti-file-code'];
@endphp

<div class="max-w-4xl mx-auto">
    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 mb-6">
        <a href="{{ route('articles.index') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition">Artigos</a>
        <span>/</span>
        <span class="truncate text-gray-700 dark:text-gray-200">{{ $article->title }}</span>
    </div>

    {{-- Header --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-8 mb-6">
        <div class="flex flex-wrap items-center gap-2 mb-4">
            <span class="text-xs font-medium px-2 py-1 rounded-lg {{ $priorityColors[$article->priority] }}">{{ $priorityLabels[$article->priority] }}</span>
            @if($article->area)
            <span class="text-xs bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 px-2 py-1 rounded-lg">{{ $article->area }}</span>
            @endif
            @if($article->product)
            <span class="text-xs bg-indigo-100 dark:bg-indigo-900 text-indigo-600 dark:text-indigo-400 px-2 py-1 rounded-lg">{{ $article->product }}</span>
            @endif
        </div>

        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">{{ $article->title }}</h1>

        <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500 dark:text-gray-400 pb-4 border-b border-gray-100 dark:border-gray-700">
            <span class="flex items-center gap-1">
                <i class="ti ti-user text-base" aria-hidden="true"></i>
                {{ $article->author->name }}
            </span>
            <span class="flex items-center gap-1">
                <i class="ti ti-calendar text-base" aria-hidden="true"></i>
                {{ $article->published_at->format('d/m/Y') }}
            </span>
            <span class="flex items-center gap-1">
                <i class="ti ti-eye text-base" aria-hidden="true"></i>
                {{ $article->views }} visualizações
            </span>
            @if($article->requester)
            <span>Solicitante: <strong>{{ $article->requester }}</strong></span>
            @endif
        </div>

        @if($article->tags->count())
        <div class="flex flex-wrap gap-2 mt-4">
            @foreach($article->tags as $tag)
            <a href="{{ route('articles.index', ['tag' => $tag->slug]) }}" class="text-xs bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-indigo-100 dark:hover:bg-indigo-900 px-2 py-1 rounded-full transition">{{ $tag->name }}</a>
            @endforeach
        </div>
        @endif
    </div>

    {{-- Conteúdo --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-8 mb-6 prose prose-gray dark:prose-invert max-w-none">
        {!! $article->contentHtml() !!}
    </div>

    {{-- Anexos --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-6 mb-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                <i class="ti ti-paperclip text-base text-gray-400" aria-hidden="true"></i>
                Anexos
                @if($article->attachments->count())
                <span class="text-xs bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400 px-2 py-0.5 rounded-full">{{ $article->attachments->count() }}</span>
                @endif
            </h3>
        </div>

        {{-- Lista de anexos --}}
        @if($article->attachments->count())
        <div class="space-y-2 mb-5">
            @foreach($article->attachments as $att)
            <div class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl group">
                <i class="ti {{ $mimeIcons[$att->mime_type] ?? 'ti-file' }} text-xl text-indigo-500 flex-shrink-0" aria-hidden="true"></i>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-800 dark:text-gray-200 truncate">{{ $att->filename }}</p>
                    <p class="text-xs text-gray-400">{{ number_format($att->size / 1024, 1) }} KB · {{ $att->created_at->format('d/m/Y') }} · {{ $att->uploader->name }}</p>
                </div>
                <a href="{{ Storage::url($att->path) }}" target="_blank"
                   class="text-xs text-indigo-600 dark:text-indigo-400 hover:underline flex-shrink-0">
                    Baixar
                </a>
                @if(auth()->user()->isAdmin() || $att->uploaded_by === auth()->id())
                <form method="POST" action="{{ route('attachments.destroy', [$article, $att]) }}" onsubmit="return confirm('Remover anexo?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-xs font-medium text-red-400 hover:text-red-600 transition ml-2 px-2 py-1 rounded hover:bg-red-50 dark:hover:bg-red-900/20">
                        Excluir
                    </button>
                </form>
                @endif
            </div>
            @endforeach
        </div>
        @else
        <p class="text-sm text-gray-400 dark:text-gray-500 mb-4">Nenhum anexo ainda.</p>
        @endif

        {{-- Upload --}}
        @can('update', $article)
        <form method="POST" action="{{ route('attachments.store', $article) }}"
              enctype="multipart/form-data"
              x-data="{ files: [], dragging: false }"
              @dragover.prevent="dragging = true"
              @dragleave.prevent="dragging = false"
              @drop.prevent="dragging = false; files = Array.from($event.dataTransfer.files); $refs.input.files = $event.dataTransfer.files">
            @csrf

            <div :class="dragging ? 'border-indigo-500 bg-indigo-50 dark:bg-indigo-900/20' : 'border-gray-200 dark:border-gray-600 hover:border-indigo-400'"
                 class="border-2 border-dashed rounded-xl p-5 text-center transition cursor-pointer"
                 @click="$refs.input.click()">
                <i class="ti ti-cloud-upload text-2xl text-gray-400 mb-2" aria-hidden="true"></i>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    <span class="text-indigo-600 dark:text-indigo-400 font-medium">Clique para selecionar</span>
                    ou arraste arquivos aqui
                </p>
                <p class="text-xs text-gray-400 mt-1">PDF, Word, Excel, imagens, ZIP — máx. 10MB por arquivo (até 5)</p>
                <input type="file" name="files[]" multiple x-ref="input" class="hidden"
                       @change="files = Array.from($event.target.files)"
                       accept=".pdf,.doc,.docx,.xls,.xlsx,.png,.jpg,.jpeg,.gif,.webp,.txt,.md,.yaml,.yml,.json,.sh,.zip">
            </div>

            <template x-if="files.length">
                <div class="mt-3 space-y-1">
                    <template x-for="f in files" :key="f.name">
                        <div class="flex items-center gap-2 text-xs text-gray-600 dark:text-gray-300 bg-gray-50 dark:bg-gray-700 px-3 py-2 rounded-lg">
                            <i class="ti ti-file text-base text-indigo-400" aria-hidden="true"></i>
                            <span x-text="f.name" class="flex-1 truncate"></span>
                            <span x-text="(f.size/1024).toFixed(1) + ' KB'" class="text-gray-400"></span>
                        </div>
                    </template>
                    <button type="submit" class="mt-2 w-full bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium py-2 rounded-xl transition">
                        Enviar @{{ files.length }} arquivo(s)
                    </button>
                </div>
            </template>
        </form>
        @endcan
    </div>

    {{-- Ações --}}
    <div class="flex items-center gap-3">
        <a href="{{ route('articles.index') }}" class="text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition">← Voltar</a>
        @can('update', $article)
        <a href="{{ route('articles.edit', $article) }}" class="ml-auto inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2 rounded-xl transition">Editar</a>
        @endcan
        @can('delete', $article)
        <form method="POST" action="{{ route('articles.destroy', $article) }}" onsubmit="return confirm('Remover este artigo?')">
            @csrf @method('DELETE')
            <button type="submit" class="text-sm text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 transition">Remover</button>
        </form>
        @endcan
    </div>
</div>
@endsection
