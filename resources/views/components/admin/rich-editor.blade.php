@props(['name', 'value' => '', 'rows' => 12, 'placeholder' => 'Write your content here...'])

<div class="rich-editor" id="{{ $name }}-editor">
    <div class="rich-editor__toolbar">
        <button type="button" class="rich-editor__btn" data-action="bold" title="Bold"><b>B</b></button>
        <button type="button" class="rich-editor__btn" data-action="italic" title="Italic"><i>I</i></button>
        <button type="button" class="rich-editor__btn" data-action="underline" title="Underline"><u>U</u></button>
        <span class="rich-editor__sep"></span>
        <button type="button" class="rich-editor__btn" data-action="h2" title="Heading 2">H2</button>
        <button type="button" class="rich-editor__btn" data-action="h3" title="Heading 3">H3</button>
        <span class="rich-editor__sep"></span>
        <button type="button" class="rich-editor__btn" data-action="ul" title="Bullet List">• List</button>
        <button type="button" class="rich-editor__btn" data-action="ol" title="Numbered List">1. List</button>
        <span class="rich-editor__sep"></span>
        <button type="button" class="rich-editor__btn" data-action="link" title="Insert Link">🔗</button>
        <button type="button" class="rich-editor__btn rich-editor__btn--accent" data-action="image" title="Upload & Insert Image">📷 Image</button>
        <button type="button" class="rich-editor__btn" data-action="code" title="Code Block">&lt;/&gt;</button>
        <button type="button" class="rich-editor__btn" data-action="quote" title="Blockquote">"</button>
    </div>
    <textarea class="rich-editor__textarea" name="{{ $name }}" rows="{{ $rows }}" placeholder="{{ $placeholder }}">{{ $value }}</textarea>
    <input type="file" class="rich-editor__file-input" accept="image/*" style="display:none;">
</div>

@once
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.rich-editor').forEach(editor => {
        const textarea = editor.querySelector('.rich-editor__textarea');
        const fileInput = editor.querySelector('.rich-editor__file-input');

        // Image upload
        editor.querySelector('[data-action="image"]').addEventListener('click', () => {
            fileInput.click();
        });

        fileInput.addEventListener('change', async (e) => {
            const file = e.target.files[0];
            if (!file) return;

            const formData = new FormData();
            formData.append('file', file);
            formData.append('_token', document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}');

            try {
                const btn = editor.querySelector('[data-action="image"]');
                btn.textContent = '⏳';
                btn.disabled = true;

                const response = await fetch('{{ route("admin.upload.image") }}', {
                    method: 'POST',
                    body: formData,
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });

                const data = await response.json();

                if (data.url) {
                    const tag = `<img src="${data.url}" alt="${file.name}" style="max-width:100%;height:auto;">`;
                    insertAtCursor(textarea, tag);
                } else {
                    alert('Upload failed: ' + (data.error || 'Unknown error'));
                }
            } catch (err) {
                alert('Upload failed: ' + err.message);
            } finally {
                const btn = editor.querySelector('[data-action="image"]');
                btn.textContent = '📷 Image';
                btn.disabled = false;
                fileInput.value = '';
            }
        });

        // Toolbar actions
        editor.querySelectorAll('.rich-editor__btn[data-action]').forEach(btn => {
            btn.addEventListener('click', () => {
                const action = btn.dataset.action;
                switch (action) {
                    case 'bold': wrapSelection(textarea, '**', '**'); break;
                    case 'italic': wrapSelection(textarea, '*', '*'); break;
                    case 'underline': wrapSelection(textarea, '<u>', '</u>'); break;
                    case 'h2': prefixLine(textarea, '## '); break;
                    case 'h3': prefixLine(textarea, '### '); break;
                    case 'ul': prefixLine(textarea, '- '); break;
                    case 'ol': prefixLine(textarea, '1. '); break;
                    case 'link':
                        const url = prompt('Enter URL:');
                        if (url) wrapSelection(textarea, '[', `](${url})`);
                        break;
                    case 'code': wrapSelection(textarea, '```\n', '\n```'); break;
                    case 'quote': prefixLine(textarea, '> '); break;
                }
                textarea.focus();
            });
        });
    });

    function insertAtCursor(textarea, text) {
        const start = textarea.selectionStart;
        const end = textarea.selectionEnd;
        textarea.value = textarea.value.substring(0, start) + text + textarea.value.substring(end);
        textarea.selectionStart = textarea.selectionEnd = start + text.length;
    }

    function wrapSelection(textarea, before, after) {
        const start = textarea.selectionStart;
        const end = textarea.selectionEnd;
        const selected = textarea.value.substring(start, end) || 'text';
        textarea.value = textarea.value.substring(0, start) + before + selected + after + textarea.value.substring(end);
        textarea.selectionStart = start + before.length;
        textarea.selectionEnd = start + before.length + selected.length;
    }

    function prefixLine(textarea, prefix) {
        const start = textarea.selectionStart;
        const lineStart = textarea.value.lastIndexOf('\n', start - 1) + 1;
        textarea.value = textarea.value.substring(0, lineStart) + prefix + textarea.value.substring(lineStart);
        textarea.selectionStart = textarea.selectionEnd = lineStart + prefix.length;
    }
});
</script>
@endpush
@endonce

@once
@push('head')
<style>
.rich-editor { border: 2px solid var(--border-color, #D4D4D4); }
.rich-editor__toolbar {
    display: flex;
    flex-wrap: wrap;
    gap: 2px;
    padding: 6px 8px;
    background: var(--bg-secondary, #F8F9FA);
    border-bottom: 1px solid var(--border-color, #D4D4D4);
}
.rich-editor__btn {
    padding: 4px 10px;
    border: 1px solid transparent;
    background: transparent;
    cursor: pointer;
    font-size: 0.8125rem;
    font-weight: 600;
    color: var(--text-secondary, #475569);
    transition: all 0.15s;
    font-family: inherit;
}
.rich-editor__btn:hover {
    background: var(--bg-primary, #fff);
    border-color: var(--border-color, #D4D4D4);
    color: var(--text-primary, #1e293b);
}
.rich-editor__btn--accent {
    color: var(--color-danger, #EF4444);
}
.rich-editor__btn--accent:hover {
    background: #FEE2E2;
    border-color: var(--color-danger, #EF4444);
}
.rich-editor__sep {
    width: 1px;
    background: var(--border-color, #D4D4D4);
    margin: 0 4px;
    align-self: stretch;
}
.rich-editor__textarea {
    width: 100%;
    min-height: 300px;
    padding: 16px;
    border: none;
    outline: none;
    resize: vertical;
    font-family: var(--font-mono, 'Courier New', monospace);
    font-size: 0.9375rem;
    line-height: 1.7;
    background: var(--bg-primary, #fff);
    color: var(--text-primary, #1e293b);
}
.rich-editor__textarea:focus {
    box-shadow: inset 0 0 0 2px var(--color-primary, #2563EB);
}
[data-theme="dark"] .rich-editor { border-color: var(--border-color, #334155); }
[data-theme="dark"] .rich-editor__toolbar { background: #1e293b; border-bottom-color: #334155; }
[data-theme="dark"] .rich-editor__btn { color: #94a3b8; }
[data-theme="dark"] .rich-editor__btn:hover { background: #334155; border-color: #475569; color: #f1f5f9; }
[data-theme="dark"] .rich-editor__sep { background: #334155; }
[data-theme="dark"] .rich-editor__textarea { background: #0f172a; color: #f1f5f9; }
</style>
@endpush
@endonce
