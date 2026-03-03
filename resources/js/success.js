const createdAt = new Date(window.orderCreatedAt).getTime();
    const expireAt  = createdAt + (5 * 60 * 1000);

    const display = document.getElementById('countdown-display');
    const wrap    = document.getElementById('countdown-wrap');
    const label   = document.getElementById('countdown-label');
    const icon    = document.getElementById('countdown-icon');

    function updateCountdown() {
        const diff = expireAt - Date.now();

        if (diff <= 0) {
            display.textContent = 'Kedaluwarsa';
            display.className   = 'font-mono text-sm font-bold text-red-600 bg-red-100 px-3 py-1.5 rounded-xl shrink-0 tabular-nums';
            wrap.className      = 'flex items-center gap-3 bg-red-50 border border-red-200 rounded-2xl px-4 py-3';
            label.className     = 'text-xs font-semibold text-red-800';
            label.textContent   = 'Pembayaran kedaluwarsa';
            icon.setAttribute('stroke', '#dc2626');
            icon.closest('div').className = 'w-8 h-8 rounded-xl bg-red-100 flex items-center justify-center shrink-0';
            clearInterval(timer);
            return;
        }

        const h = Math.floor(diff / 3600000);
        const m = Math.floor((diff % 3600000) / 60000);
        const s = Math.floor((diff % 60000) / 1000);

        display.textContent =
            String(h).padStart(2, '0') + ':' +
            String(m).padStart(2, '0') + ':' +
            String(s).padStart(2, '0');

        if (diff < 3600000) {
            display.className = 'font-mono text-sm font-bold text-red-600 bg-red-100 px-3 py-1.5 rounded-xl shrink-0 tabular-nums';
            wrap.className    = 'flex items-center gap-3 bg-red-50 border border-red-200 rounded-2xl px-4 py-3';
            label.className   = 'text-xs font-semibold text-red-800';
            icon.setAttribute('stroke', '#dc2626');
            icon.closest('div').className = 'w-8 h-8 rounded-xl bg-red-100 flex items-center justify-center shrink-0';
        }
    }

    updateCountdown();
const timer = setInterval(updateCountdown, 1000);
