@extends('layouts.app')
@section('title', $order->status === 'paid' ? 'Pembayaran Berhasil' : 'Menunggu Pembayaran')

@section('content')
<div class="min-h-screen flex items-start justify-center p-6">
    <div class="w-full max-w-md">

        {{-- Card --}}
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">

            {{-- Status Banner --}}
            @if($order && $order->status === 'paid')
            <div class="relative bg-gradient-to-br from-emerald-500 to-teal-500 px-6 pt-10 pb-14 text-center overflow-hidden">
                <div class="absolute inset-0 opacity-10">
                    <div class="absolute top-2 left-8 w-24 h-24 rounded-full bg-white"></div>
                    <div class="absolute bottom-0 right-4 w-32 h-32 rounded-full bg-white"></div>
                </div>
                <div class="relative">
                    <div class="w-16 h-16 bg-white/20 backdrop-blur rounded-2xl flex items-center justify-center mx-auto mb-4 border border-white/30">
                        <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                    </div>
                    <h2 class="text-xl font-bold text-white mb-1">Pembayaran Berhasil!</h2>
                    <p class="text-emerald-100 text-sm">Transaksi kamu telah dikonfirmasi</p>
                </div>
            </div>
            @else
            <div class="relative bg-gradient-to-br from-amber-400 to-orange-500 px-6 pt-10 pb-14 text-center overflow-hidden">
                <div class="absolute inset-0 opacity-10">
                    <div class="absolute top-2 left-8 w-24 h-24 rounded-full bg-white"></div>
                    <div class="absolute bottom-0 right-4 w-32 h-32 rounded-full bg-white"></div>
                </div>
                <div class="relative">
                    <div class="w-16 h-16 bg-white/20 backdrop-blur rounded-2xl flex items-center justify-center mx-auto mb-4 border border-white/30">
                        <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    </div>
                    <h2 class="text-xl font-bold text-white mb-1">Menunggu Pembayaran</h2>
                    <p class="text-amber-100 text-sm">Selesaikan sebelum waktu habis</p>
                </div>
            </div>
            @endif

            {{-- Floating badge overlap --}}
            <div class="relative -mt-5 flex justify-center">
                @if($order && $order->status === 'paid')
                <span class="inline-flex items-center gap-1.5 bg-white border border-emerald-100 text-emerald-600 text-xs font-bold px-4 py-1.5 rounded-full shadow-sm">
                    <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                    PAID
                </span>
                @elseif($order && $order->status === 'pending')
                <span class="inline-flex items-center gap-1.5 bg-white border border-amber-100 text-amber-600 text-xs font-bold px-4 py-1.5 rounded-full shadow-sm">
                    <span class="w-1.5 h-1.5 bg-amber-400 rounded-full animate-pulse"></span>
                    PENDING
                </span>
                @else
                <span class="inline-flex items-center gap-1.5 bg-white border border-red-100 text-red-600 text-xs font-bold px-4 py-1.5 rounded-full shadow-sm">
                    <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span>
                    {{ strtoupper($order->status) }}
                </span>
                @endif
            </div>

            {{-- Countdown (pending only) --}}
            @if($order && $order->status === 'pending')
            <div class="mx-6 mt-4">
                <div id="countdown-wrap" class="flex items-center gap-3 bg-amber-50 border border-amber-200 rounded-2xl px-4 py-3">
                    <div class="w-8 h-8 rounded-xl bg-amber-100 flex items-center justify-center shrink-0">
                        <svg id="countdown-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#d97706" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p id="countdown-label" class="text-xs font-semibold text-amber-800">Batas waktu pembayaran</p>
                        <p class="text-xs text-amber-600 mt-0.5">Selesaikan sebelum waktu habis</p>
                    </div>
                    <span id="countdown-display" class="font-mono text-sm font-bold text-amber-700 bg-amber-100 px-3 py-1.5 rounded-xl shrink-0 tabular-nums">
                        --:--:--
                    </span>
                </div>
            </div>
            @endif

            {{-- Detail Order --}}
            @if($order)
            <div class="mx-6 mt-5 bg-slate-50 rounded-2xl overflow-hidden">
                <div class="flex justify-between items-center px-4 py-3 border-b border-slate-100">
                    <span class="text-xs text-slate-400 font-medium uppercase tracking-wide">Nama</span>
                    <span class="text-sm font-semibold text-slate-700">{{ $order->customer_name }}</span>
                </div>
                <div class="flex justify-between items-center px-4 py-3 border-b border-slate-100">
                    <span class="text-xs text-slate-400 font-medium uppercase tracking-wide">Layanan</span>
                    <span class="text-sm font-semibold text-slate-700 text-right max-w-[60%]">{{ $order->service->name }}</span>
                </div>
                <div class="flex justify-between items-center px-4 py-3 border-b border-slate-100">
                    <span class="text-xs text-slate-400 font-medium uppercase tracking-wide">Total</span>
                    <span class="text-sm font-bold text-slate-800">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between items-center px-4 py-3">
                    <span class="text-xs text-slate-400 font-medium uppercase tracking-wide">Order ID</span>
                    <span class="font-mono text-xs bg-white border border-slate-200 text-slate-500 px-2.5 py-1 rounded-lg">{{ $order->order_id }}</span>
                </div>
            </div>
            @endif

            {{-- Actions --}}
            <div class="px-6 py-6 flex flex-col gap-2.5">
                @if($order && $order->status === 'pending')
                <a href="{{ route('orders.create', $order->service_id) }}"
                    class="w-full text-center bg-amber-500 hover:bg-amber-600 active:scale-95 text-white text-sm font-bold py-3.5 rounded-2xl transition-all duration-150 shadow-sm hover:shadow-md">
                    Bayar Sekarang
                </a>
                @endif
                <a href="{{ route('services.index') }}"
                    class="w-full text-center bg-pink-700 hover:bg-pink-800 active:scale-95 text-white text-sm font-bold py-3.5 rounded-2xl transition-all duration-150 shadow-sm hover:shadow-md">
                    Kembali ke Layanan
                </a>
                <a href="{{ route('orders.index') }}"
                    class="w-full text-center bg-slate-100 hover:bg-slate-200 active:scale-95 text-slate-600 hover:text-slate-800 text-sm font-semibold py-3.5 rounded-2xl transition-all duration-150">
                    Lihat Semua Order
                </a>
            </div>

        </div>

    </div>
</div>

@if($order && $order->status === 'pending')
<script>
    window.orderCreatedAt = "{{ $order->created_at->toIso8601String() }}";

    // ── Polling status hingga berubah dari 'pending' ──
    (function pollStatus() {
        const orderId = {{ $order->id }};
        const interval = setInterval(function () {
            fetch(`/orders/${orderId}/check-status`)
                .then(res => res.json())
                .then(data => {
                    if (data.status && data.status !== 'pending') {
                        clearInterval(interval);
                        // Reload halaman agar status terupdate
                        window.location.reload();
                    }
                })
                .catch(() => {}); // abaikan error jaringan
        }, 3000); // cek setiap 3 detik

        // Berhenti polling setelah 10 menit
        setTimeout(() => clearInterval(interval), 10 * 60 * 1000);
    })();
</script>
@vite(['resources/js/success.js'])
@endif

@endsection
