document.getElementById('pay-button').onclick = function () {
    this.disabled = true;
    this.innerHTML = `<svg class="animate-spin w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path></svg> Membuka Pembayaran...`;

    window.snap.pay(window.snapToken, {
        onSuccess: function (result) {
            // Setelah sukses bayar, langsung redirect ke halaman sukses
            // Status akan di-polling dari halaman success
            window.location.href = window.successUrl + '?order_id=' + window.orderId;
        },
        onPending: function (result) {
            window.location.href = window.successUrl + '?order_id=' + window.orderId;
        },
        onError: function (result) {
            const btn = document.getElementById('pay-button');
            btn.disabled = false;
            btn.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M11 17h2v-1h1c.55 0 1-.45 1-1v-3c0-.55-.45-1-1-1h-3v-1h4V9h-2V8h-2v1h-1c-.55 0-1 .45-1 1v3c0 .55.45 1 1 1h3v1H9v1h2v1zm9-13H4c-1.11 0-2 .89-2 2v14c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V6c0-1.11-.89-2-2-2zm0 16H4V6h16v14z"/></svg> Coba Lagi`;
            alert('Pembayaran gagal. Silakan coba lagi.');
        },
        onClose: function () {
            const btn = document.getElementById('pay-button');
            btn.disabled = false;
            btn.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M11 17h2v-1h1c.55 0 1-.45 1-1v-3c0-.55-.45-1-1-1h-3v-1h4V9h-2V8h-2v1h-1c-.55 0-1 .45-1 1v3c0 .55.45 1 1 1h3v1H9v1h2v1zm9-13H4c-1.11 0-2 .89-2 2v14c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V6c0-1.11-.89-2-2-2zm0 16H4V6h16v14z"/></svg> Bayar Sekarang`;
        }
    });
};
