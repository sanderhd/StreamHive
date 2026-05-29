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

const form = document.querySelector(".video-form");
const uploadBtn = form.querySelector("button");

form.addEventListener("submit", function(e) {
    e.preventDefault();

    const formData = new FormData(form);
    const xhr = new XMLHttpRequest();

    xhr.upload.addEventListener("progress", function (e) {
        if (e.lengthComputable) {
            const percent = Math.round((e.loaded / e.total) * 100);
            updateProgress(percent);
        }
    });

    xhr.addEventListener("load", function () {
        if (xhr.status === 200) {
            window.location.href = xhr.responseURL;
        }
    });

    xhr.open("POST", form.action);
    document.getElementById("progress-container").style.display = "flex";
    xhr.send(formData);

    uploadBtn.disabled = true;
    uploadBtn.textContent = "Uploading...";
})

function updateProgress(percent) {
    const bar = document.getElementById("progress-bar");
    const label = document.getElementById("progress-label");
    if (bar) bar.style.width = percent + "%";
    if (label) label.textContent = percent + "%";
}