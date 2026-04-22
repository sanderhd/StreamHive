document.getElementById('sidebarButton').addEventListener('click', function()  {
    const sidebarContent = document.getElementById('sidebarContent');
    sidebarContent.style.display = sidebarContent.style.display === 'flex' ? 'none' : 'flex';
});

document.getElementById('sidebarClose').addEventListener('click', function() {
    const sidebarContent = document.getElementById('sidebarContent');
    sidebarContent.style.display = 'none';
});

document.addEventListener('click', function(event) {
    const sidebar = document.querySelector('.sidebar');
    const sidebarContent = document.querySelector('.sidebar-content');

    if (!sidebar.contains(event.target)) {
        sidebarContent.style.display = 'none';
    }
});