// Admin panel JS
document.addEventListener('DOMContentLoaded', () => {
    // Sidebar overlay click to close
    const overlay = document.getElementById('sidebar-overlay');
    const sidebar = document.getElementById('admin-sidebar');
    if (overlay) {
        overlay.addEventListener('click', () => {
            sidebar?.classList.remove('active');
            overlay.style.display = 'none';
            document.body.style.overflow = '';
        });
    }

    // Escape key closes sidebar
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            sidebar?.classList.remove('active');
            if (overlay) overlay.style.display = 'none';
            document.body.style.overflow = '';
        }
    });
});
