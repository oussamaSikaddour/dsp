<div wire:ignore>
    <textarea id="{{ $htmlId }}"></textarea>
</div>

@script
<script>
(() => {

    const getLang = () => {
        const storedLang = localStorage.getItem('language');

        switch (storedLang) {
            case 'Ar': return 'ar';
            case 'En': return 'en';
            case 'Fr': return 'fr_FR';
            default:   return 'fr_FR';
        }
    };

    /**
     * Destroy existing editor safely
     */
    const destroyEditor = (editorId) => {
        const existing = tinymce.get(editorId);
        if (existing) {
            existing.off();
            existing.remove();
        }
    };

    /**
     * Init TinyMCE safely
     */
    const initializeTinyMCE = (editorId, initialContent, viewOnly) => {

        // ✅ always clean previous instance (fix modal reopen bug)
        destroyEditor(editorId);

        tinymce.init({
            selector: `#${editorId}`,
            disabled: viewOnly == 1 || viewOnly === true,

            menubar: !viewOnly,
            statusbar: !viewOnly,

            toolbar: viewOnly ? false :
                'undo redo | blocks | bold italic | alignleft aligncenter alignright | bullist numlist | code | table',

            plugins: viewOnly ? '' : 'code table lists',
            language: getLang(),

            setup: function (editor) {

                editor.on('init', function () {
                    editor.setContent(initialContent ?? '');
                    editor.save();
                });

                if (!viewOnly) {
                    editor.on('change keyup blur', () => {
                        const content = editor.getContent() ?? '';
                        @this.call('setContent', content);
                    });
                }
            },
        });
    };

    /**
     * Livewire event: init editor
     */
    $wire.on('initialize-tiny-mce', () => {
        initializeTinyMCE(
            @js($htmlId),
            @js($content),
            @js($viewOnly)
        );
    });

    /**
     * External destroy event (safe modal cleanup)
     */
    window.addEventListener('tinymce-destroy-all', (event) => {
        const editorId = event.detail?.id ?? @js($htmlId);
        destroyEditor(editorId);
    });

})();
</script>
@endscript
