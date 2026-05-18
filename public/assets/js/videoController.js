const video = document.getElementById("video");
const playButton = document.getElementById("play");
const pauseButton = document.getElementById("pause");
const seek = document.getElementById("seek");
const time = document.getElementById("time");

playButton.addEventListener("click", () => {
    video.play();
});

pauseButton.addEventListener("click", () => {
    video.pause();
});

video.addEventListener("timeupdate", () => {
    seek.value = (video.currentTime / video.duration) * 100;

    const min = Math.floor(video.currentTime / 60);
    const sec = Math.floor(video.currentTime % 60).toString().padStart(2, "0");
    time.textContent = `${min}:${sec}`;
});

seek.addEventListener("input", () => {
    video.currentTime = (seek.value / 100) * video.duration;
});