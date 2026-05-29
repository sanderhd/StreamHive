const video = document.getElementById("video");
const toggleBtn = document.getElementById("toggle-play");
const centerBtn = document.getElementById("center-play");
const seek = document.getElementById("seek");
const time = document.getElementById("time");
const volume = document.getElementById("volume");
const volumeIcon = document.getElementById("volume-icon");

function togglePlay() {
    if (video.paused) {
        video.play();
    } else {
        video.pause();
    }
}

function updateToggleIcon() {
    const paused = video.paused;

    toggleBtn.innerHTML = paused
        ? `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960"><path d="M320-200v-560l440 280-440 280Z"/></svg>`
        : `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960"><path d="M520-200v-560h240v560H520Zm-320 0v-560h240v560H200Z"/></svg>`;

    centerBtn.innerHTML = paused
        ? `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960"><path d="M320-200v-560l440 280-440 280Z"/></svg>`
        : `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960"><path d="M520-200v-560h240v560H520Zm-320 0v-560h240v560H200Z"/></svg>`;

    centerBtn.classList.toggle("visible", paused);
}

toggleBtn.addEventListener("click", togglePlay);
centerBtn.addEventListener("click", togglePlay);

video.addEventListener("play", updateToggleIcon);
video.addEventListener("pause", updateToggleIcon);

video.addEventListener("click", togglePlay);

video.addEventListener("timeupdate", () => {
    if (!isNaN(video.duration)) {
        seek.value = (video.currentTime / video.duration * 100);
    }
    const min = Math.floor(video.currentTime / 60);
    const sec = Math.floor(video.currentTime % 60).toString().padStart(2, "0");
    time.textContent = `${min}:${sec}`;
});

seek.addEventListener("input", () => {
    video.currentTime = (seek.value / 100) * video.duration;
});

volume.addEventListener("input", () => {
    video.volume = volume.value;
    updateVolumeIcon();
})

function updateVolumeIcon() {
    const v = video.volume;

    if (v === 0) {
        volumeIcon.innerHTML = `
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#FFFFFF">
            <path d="M280-360v-240h160l200-200v640L440-360H280Zm80-80h114l86 86v-252l-86 86H360v80Zm100-40Z"/>
        </svg>`;
    }

    else if (v < 0.5) {
        volumeIcon.innerHTML = `
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#FFFFFF">
            <path d="M200-360v-240h160l200-200v640L360-360H200Zm440 40v-322q45 21 72.5 65t27.5 97q0 53-27.5 96T640-320ZM480-606l-86 86H280v80h114l86 86v-252ZM380-480Z"/>
        </svg>`;
    }

    else {
        volumeIcon.innerHTML = `
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#FFFFFF">
            <path d="M560-131v-82q90-26 145-100t55-168q0-94-55-168T560-749v-82q124 28 202 125.5T840-481q0 127-78 224.5T560-131ZM120-360v-240h160l200-200v640L280-360H120Zm440 40v-322q47 22 73.5 66t26.5 96q0 51-26.5 94.5T560-320ZM400-606l-86 86H200v80h114l86 86v-252ZM300-480Z"/>
        </svg>`;
    }
}

updateToggleIcon();
updateVolumeIcon();