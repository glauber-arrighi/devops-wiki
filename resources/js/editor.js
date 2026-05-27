import { Editor } from '@tiptap/core'
import StarterKit from '@tiptap/starter-kit'
import Placeholder from '@tiptap/extension-placeholder'
import CharacterCount from '@tiptap/extension-character-count'
import { Table } from '@tiptap/extension-table'
import { TableRow } from '@tiptap/extension-table-row'
import { TableCell } from '@tiptap/extension-table-cell'
import { TableHeader } from '@tiptap/extension-table-header'
import Image from '@tiptap/extension-image'
import Link from '@tiptap/extension-link'

window.initEditor = function(elementId, inputId, content = '') {
    const editorEl = document.getElementById(elementId)
    const inputEl  = document.getElementById(inputId)
    if (!editorEl || !inputEl) return

    const editor = new Editor({
        element: editorEl,
        extensions: [
            StarterKit,
            Placeholder.configure({ placeholder: 'Escreva o conteúdo do artigo...' }),
            CharacterCount,
            Table.configure({ resizable: true }),
            TableRow, TableCell, TableHeader,
            Image.configure({ inline: false, allowBase64: true }),
            Link.configure({ openOnClick: false }),
        ],
        content: content,
        onUpdate({ editor }) {
            inputEl.value = editor.getHTML()
        },
        editorProps: {
            attributes: {
                class: 'prose prose-gray dark:prose-invert max-w-none min-h-64 focus:outline-none px-4 py-3',
            },
        },
    })

    // Botões da toolbar
    document.querySelectorAll('[data-editor-action]').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault()
            const action = btn.dataset.editorAction
            const chain  = editor.chain().focus()

            const actions = {
                bold:            () => chain.toggleBold().run(),
                italic:          () => chain.toggleItalic().run(),
                strike:          () => chain.toggleStrike().run(),
                code:            () => chain.toggleCode().run(),
                h1:              () => chain.toggleHeading({ level: 1 }).run(),
                h2:              () => chain.toggleHeading({ level: 2 }).run(),
                h3:              () => chain.toggleHeading({ level: 3 }).run(),
                bulletList:      () => chain.toggleBulletList().run(),
                orderedList:     () => chain.toggleOrderedList().run(),
                blockquote:      () => chain.toggleBlockquote().run(),
                codeBlock:       () => chain.toggleCodeBlock().run(),
                horizontalRule:  () => chain.setHorizontalRule().run(),
                undo:            () => chain.undo().run(),
                redo:            () => chain.redo().run(),
                table:           () => chain.insertTable({ rows: 3, cols: 3, withHeaderRow: true }).run(),
                link: () => {
                    const url = prompt('URL do link:')
                    if (url) chain.setLink({ href: url }).run()
                },
                image: () => {
                    const url = prompt('URL da imagem:')
                    if (url) chain.setImage({ src: url }).run()
                },
            }

            if (actions[action]) actions[action]()
        })
    })

    // Atualiza estado ativo dos botões
    editor.on('selectionUpdate', () => updateToolbar(editor))
    editor.on('transaction', () => updateToolbar(editor))

    function updateToolbar(editor) {
        document.querySelectorAll('[data-editor-action]').forEach(btn => {
            const action = btn.dataset.editorAction
            const activeMap = {
                bold: editor.isActive('bold'),
                italic: editor.isActive('italic'),
                strike: editor.isActive('strike'),
                code: editor.isActive('code'),
                h1: editor.isActive('heading', { level: 1 }),
                h2: editor.isActive('heading', { level: 2 }),
                h3: editor.isActive('heading', { level: 3 }),
                bulletList: editor.isActive('bulletList'),
                orderedList: editor.isActive('orderedList'),
                blockquote: editor.isActive('blockquote'),
                codeBlock: editor.isActive('codeBlock'),
            }
            if (activeMap[action] !== undefined) {
                btn.classList.toggle('bg-indigo-100', activeMap[action])
                btn.classList.toggle('dark:bg-indigo-900', activeMap[action])
                btn.classList.toggle('text-indigo-700', activeMap[action])
                btn.classList.toggle('dark:text-indigo-300', activeMap[action])
            }
        })
    }

    return editor
}
