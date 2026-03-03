document.addEventListener('DOMContentLoaded', function () {
    const toggleBtn = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.querySelector('.main-content');

    // ── Buat overlay untuk mobile ──────────────────────────────────────
    let overlay = document.getElementById('sidebarOverlay');
    if (!overlay) {
        overlay = document.createElement('div');
        overlay.id = 'sidebarOverlay';
        overlay.className = 'fixed inset-0 bg-black/50 z-[940] hidden md:hidden';
        document.body.appendChild(overlay);
    }

    // ── Helper: cek apakah layar mobile ───────────────────────────────
    const isMobile = () => window.innerWidth < 768;

    // ── Buka sidebar ──────────────────────────────────────────────────
    function openSidebar() {
        sidebar.classList.remove('-translate-x-full');
        sidebar.classList.remove('collapsed');
        if (isMobile()) {
            overlay.classList.remove('hidden');
            document.body.classList.add('overflow-hidden'); // cegah scroll background
        } else {
            mainContent?.classList.remove('expanded');
        }
    }

    // ── Tutup sidebar ─────────────────────────────────────────────────
    function closeSidebar() {
        if (isMobile()) {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        } else {
            sidebar.classList.add('collapsed');
            mainContent?.classList.add('expanded');
        }
    }

    // ── Toggle sidebar ────────────────────────────────────────────────
    function toggleSidebar() {
        const isHidden = sidebar.classList.contains('-translate-x-full') ||
            sidebar.classList.contains('collapsed');
        isHidden ? openSidebar() : closeSidebar();
        toggleBtn?.classList.toggle('active');
    }

    // ── Pasang event listener ke tombol toggle ────────────────────────
    if (toggleBtn && sidebar) {
        const newToggleBtn = toggleBtn.cloneNode(true);
        toggleBtn.parentNode.replaceChild(newToggleBtn, toggleBtn);
        newToggleBtn.addEventListener('click', toggleSidebar);
    }

    // ── Tutup sidebar saat klik overlay (mobile) ──────────────────────
    overlay.addEventListener('click', closeSidebar);

    // ── Handle resize: reset state saat pindah breakpoint ────────────
    let resizeTimer;
    window.addEventListener('resize', function () {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(() => {
            if (!isMobile()) {
                // Desktop: pastikan sidebar muncul, hapus overlay
                overlay.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
                sidebar.classList.remove('-translate-x-full');
            } else {
                // Mobile: sembunyikan sidebar by default
                sidebar.classList.add('-translate-x-full');
                mainContent?.classList.remove('expanded');
            }
        }, 100);
    });

    // ── Inisialisasi state awal ────────────────────────────────────────
    if (isMobile()) {
        sidebar.classList.add('-translate-x-full');
    }

    // ── Profile dropdown ──────────────────────────────────────────────
    const profileTrigger = document.querySelector('.profile-trigger');
    const userProfile = document.querySelector('.user-profile');

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
