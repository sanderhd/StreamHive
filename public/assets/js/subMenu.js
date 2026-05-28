document.addEventListener("DOMContentLoaded", () => {
    const profile = document.querySelector(".profile");
    const subMenu = document.querySelector(".sub-menu-wrap");

    if (!profile || !subMenu) return;

    profile.addEventListener("click", (e) => {
        e.stopPropagation();
        subMenu.classList.toggle("open-menu");
    });

    document.addEventListener("click", (e) => {
        if (!subMenu.contains(e.target) && !profile.contains(e.target)) {
            subMenu.classList.remove("open-menu");
        }
    });
});