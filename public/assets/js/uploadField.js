function addFilePreview(inputId, previewId) {
    const input = document.getElementById(inputId);
    const preview = document.getElementById(previewId);

    if (!input || !preview) return;

    input.addEventListener("change", function() {
        const file = this.files?.[0];

        if (file) {
            preview.innerText = file.name
        }
    });
}

addFilePreview("thumbnail-upload", "thumbnail-preview");
addFilePreview("video-upload", "video-preview");
addFilePreview("thumbnail-replace-upload", "thumbnail-replace");