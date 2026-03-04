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
});
