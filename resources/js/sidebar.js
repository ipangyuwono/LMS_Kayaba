document.addEventListener('DOMContentLoaded', function () {
    const toggleBtn   = document.getElementById('sidebarToggle');
    const sidebar     = document.getElementById('sidebar');
    const mainContent = document.querySelector('.main-content');
    const overlay     = document.getElementById('sidebarOverlay');

    const isMobile = () => window.innerWidth < 768;

    function initSidebar() {
        if (isMobile()) {
            sidebar.classList.add('-translate-x-full');
        } else {
            sidebar.classList.remove('-translate-x-full');
        }
    }

    function openSidebar() {
        sidebar.classList.remove('-translate-x-full');
        if (isMobile()) {
            overlay.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }
    }

    function closeSidebar() {
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    function toggleSidebar() {
        sidebar.classList.contains('-translate-x-full') ? openSidebar() : closeSidebar();
    }

    if (toggleBtn) {
        toggleBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            toggleSidebar();
        });
    }

    if (overlay) {
        overlay.addEventListener('click', closeSidebar);
    }

    let resizeTimer;
    window.addEventListener('resize', function () {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(() => {
            if (!isMobile()) {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            }
        }, 100);
    });

    initSidebar();

    // Profile dropdown
    const profileTrigger = document.querySelector('.profile-trigger');
    const userProfile    = document.querySelector('.user-profile');

    if (profileTrigger && userProfile) {
        profileTrigger.addEventListener('click', function (e) {
            e.stopPropagation();
            userProfile.classList.toggle('active');
        });

        window.addEventListener('click', function (e) {
            if (!userProfile.contains(e.target)) {
                userProfile.classList.remove('active');
            }
        });
    }
});
