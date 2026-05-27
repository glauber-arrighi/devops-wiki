@props(['name' => 'content', 'value' => ''])

<div x-data class="border border-gray-200 dark:border-gray-600 rounded-xl overflow-hidden bg-white dark:bg-gray-700">

    {{-- Toolbar --}}
    <div class="flex flex-wrap items-center gap-0.5 px-2 py-2 bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-600">

        {{-- Texto --}}
        <button data-editor-action="bold"        title="Negrito (Ctrl+B)"    class="editor-btn font-bold">B</button>
        <button data-editor-action="italic"      title="Itálico (Ctrl+I)"    class="editor-btn italic">I</button>
        <button data-editor-action="strike"      title="Tachado"             class="editor-btn line-through">S</button>
        <button data-editor-action="code"        title="Código inline"       class="editor-btn font-mono">&#96;</button>

        <div class="w-px h-5 bg-gray-300 dark:bg-gray-600 mx-1"></div>

        {{-- Headings --}}
        <button data-editor-action="h1" title="Título 1" class="editor-btn text-xs font-bold">H1</button>
        <button data-editor-action="h2" title="Título 2" class="editor-btn text-xs font-bold">H2</button>
        <button data-editor-action="h3" title="Título 3" class="editor-btn text-xs font-bold">H3</button>

        <div class="w-px h-5 bg-gray-300 dark:bg-gray-600 mx-1"></div>

        {{-- Listas --}}
        <button data-editor-action="bulletList"  title="Lista"          class="editor-btn">• —</button>
        <button data-editor-action="orderedList" title="Lista numerada" class="editor-btn">1.</button>
        <button data-editor-action="blockquote"  title="Citação"        class="editor-btn">❝</button>
        <button data-editor-action="codeBlock"   title="Bloco de código" class="editor-btn font-mono text-xs">&lt;/&gt;</button>

        <div class="w-px h-5 bg-gray-300 dark:bg-gray-600 mx-1"></div>

        {{-- Tabela e mídia --}}
        <button data-editor-action="table"          title="Inserir tabela" class="editor-btn text-xs">⊞</button>
        <button data-editor-action="link"           title="Inserir link"   class="editor-btn text-xs">🔗</button>
        <button data-editor-action="image"          title="Inserir imagem" class="editor-btn text-xs">🖼</button>
        <button data-editor-action="horizontalRule" title="Linha horizontal" class="editor-btn text-xs">—</button>

        <div class="w-px h-5 bg-gray-300 dark:bg-gray-600 mx-1"></div>

        {{-- Undo/Redo --}}
        <button data-editor-action="undo" title="Desfazer (Ctrl+Z)" class="editor-btn text-xs">↩</button>
        <button data-editor-action="redo" title="Refazer (Ctrl+Y)"  class="editor-btn text-xs">↪</button>
    </div>

    {{-- Área do editor --}}
    <div id="tiptap-editor" class="min-h-64"></div>

    {{-- Input hidden com o HTML --}}
    <input type="hidden" name="{{ $name }}" id="tiptap-input" value="{{ old($name, $value) }}">
</div>

@once
<style>
.editor-btn {
    padding: 4px 8px;
    border-radius: 6px;
    font-size: 13px;
    color: rgb(75 85 99);
    transition: background 0.15s;
    cursor: pointer;
    border: none;
    background: transparent;
    line-height: 1.4;
}
.dark .editor-btn { color: rgb(209 213 219); }
.editor-btn:hover { background: rgb(229 231 235); }
.dark .editor-btn:hover { background: rgb(55 65 81); }

/* Estilos do editor TipTap */
.tiptap { outline: none; }
.tiptap p.is-editor-empty:first-child::before {
    color: #9ca3af;
    content: attr(data-placeholder);
    float: left;
    height: 0;
    pointer-events: none;
}
.tiptap table { border-collapse: collapse; width: 100%; }
.tiptap td, .tiptap th { border: 1px solid #d1d5db; padding: 6px 12px; }
.tiptap th { background: #f9fafb; font-weight: 600; }
.dark .tiptap td, .dark .tiptap th { border-color: #4b5563; }
.dark .tiptap th { background: #374151; }
.tiptap pre { background: #1e293b; color: #e2e8f0; padding: 1rem; border-radius: 8px; overflow-x: auto; }
.tiptap code { background: #f1f5f9; padding: 2px 6px; border-radius: 4px; font-size: 0.875em; }
.dark .tiptap code { background: #374151; }
.tiptap blockquote { border-left: 4px solid #6366f1; padding-left: 1rem; color: #6b7280; margin: 1rem 0; }
.tiptap img { max-width: 100%; border-radius: 8px; margin: 1rem 0; }
.tiptap h1 { font-size: 1.75rem; font-weight: 700; margin: 1rem 0 0.5rem; }
.tiptap h2 { font-size: 1.4rem; font-weight: 600; margin: 1rem 0 0.5rem; }
.tiptap h3 { font-size: 1.15rem; font-weight: 600; margin: 0.75rem 0 0.5rem; }
.tiptap ul { list-style: disc; padding-left: 1.5rem; }
.tiptap ol { list-style: decimal; padding-left: 1.5rem; }
.tiptap a { color: #6366f1; text-decoration: underline; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const raw = document.getElementById('tiptap-input')?.value || ''
    if (typeof initEditor === 'function') {
        initEditor('tiptap-editor', 'tiptap-input', raw)
    }
})
</script>
@endonce
