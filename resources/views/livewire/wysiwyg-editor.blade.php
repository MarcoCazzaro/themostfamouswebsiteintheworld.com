<div wire:ignore class="ssnail-wysiwyg-editor">
    <link rel="stylesheet" href="https://unpkg.com/trix@2.0.0/dist/trix.css" />

    <input id="{{ $editorId }}" type="hidden" name="{{ $fieldName }}" value="{{ $value }}">
    <trix-editor wire:ignore input="{{ $editorId }}" class="trix-content"></trix-editor>

    <script src="https://unpkg.com/trix@2.0.0/dist/trix.umd.min.js"></script>

    <script>
        var wysiwygEditor = document.getElementById("{{ $editorId }}")

        addEventListener("trix-blur", function(event) {
            @this.set('value', wysiwygEditor.getAttribute('value'))
        })

        addEventListener("trix-before-initialize", () => {
            console.log(Trix.config);
            Trix.config.attachments = false;
        })
    </script>
</div>
