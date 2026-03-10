document.addEventListener('DOMContentLoaded', function () {

    function updateClock() {
        const el = document.getElementById('liveClock');
        if (!el) return;
        el.textContent = new Date().toLocaleTimeString('id-ID', {
            hour: '2-digit', minute: '2-digit', second: '2-digit'
        });
    }
    updateClock();
    setInterval(updateClock, 1000);

    function pollNotifications() {
        fetch('/notifications/poll')
            .then(r => r.json())
            .then(data => {
                const badge = document.getElementById('notif-badge');
                const list  = document.getElementById('notif-list');
                if (!badge || !list) return;

                if (data.count > 0) {
                    badge.textContent = data.count;
                    badge.classList.remove('hidden');
                    list.innerHTML = data.notifications.map(n => `
                        <div class="px-4 py-3 hover:bg-slate-50 transition-all">
                            <p class="text-sm font-bold text-slate-700">${n.title}</p>
                            <p class="text-xs text-slate-500 mt-0.5">${n.message}</p>
                            <p class="text-[10px] text-slate-400 mt-1">${n.created_at}</p>
                        </div>
                    `).join('');
                } else {
                    badge.classList.add('hidden');
                    list.innerHTML = '<p class="text-xs text-slate-400 text-center py-6">Tidak ada notifikasi</p>';
                }
            })
            .catch(() => {});
    }

    function toggleNotif() {
        document.getElementById('notif-dropdown')?.classList.toggle('hidden');
    }

    function markAllRead() {
        fetch('/notifications/read', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
            }
        }).then(() => pollNotifications());
        document.getElementById('notif-dropdown')?.classList.add('hidden');
    }

    // Tutup dropdown kalau klik di luar
    document.addEventListener('click', function (e) {
        const wrapper = document.getElementById('notif-wrapper');
        if (wrapper && !wrapper.contains(e.target)) {
            document.getElementById('notif-dropdown')?.classList.add('hidden');
        }
    });

    // Expose ke global (dipanggil dari onclick di blade)
    window.toggleNotif  = toggleNotif;
    window.markAllRead  = markAllRead;

    pollNotifications();
    setInterval(pollNotifications, 10000);

});
