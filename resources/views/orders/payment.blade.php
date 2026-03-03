@extends('layouts.app')
@section('title', 'Pembayaran')
@section('content')
@stack('scripts')

<div class="p-6">
    <div class="max-w-lg mx-auto">

        {{-- Card Pembayaran --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

            {{-- Top Banner --}}
            <div class="bg-gradient-to-r from-pink-700 to-pink-500 px-6 py-8 text-white text-center">
                <div class="w-14 h-14 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" viewBox="0 0 24 24"><path d="M20 4H4c-1.11 0-2 .89-2 2v12c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V6c0-1.11-.89-2-2-2zm0 14H4v-6h16v6zm0-10H4V6h16v2z"/></svg>
                </div>
                <p class="text-pink-200 text-xs uppercase tracking-widest font-semibold mb-1">Total Pembayaran</p>
                <p class="text-3xl font-bold">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
            </div>

            {{-- Detail --}}
            <div class="px-6 py-5 space-y-3 border-b border-gray-100">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Layanan</span>
                    <span class="font-semibold text-gray-800">{{ $service->name }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Pemesan</span>
                    <span class="font-semibold text-gray-800">{{ $order->customer_name }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Email</span>
                    <span class="font-semibold text-gray-800">{{ $order->customer_email }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Order ID</span>
                    <span class="font-mono text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded-lg">{{ $order->order_id }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Status</span>
                    <span class="inline-flex items-center gap-1 bg-yellow-100 text-yellow-700 text-xs font-semibold px-2.5 py-1 rounded-full">
                        <span class="w-1.5 h-1.5 bg-yellow-500 rounded-full animate-pulse"></span>
                        Menunggu Pembayaran
                    </span>
                </div>
            </div>

            <div class="px-6 py-5">
                <button id="pay-button"
                    class="w-full bg-pink-700 hover:bg-pink-800 active:scale-95 text-white font-bold py-3.5 rounded-xl shadow-md transition-all duration-200 hover:shadow-lg flex items-center justify-center gap-2 text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M11 17h2v-1h1c.55 0 1-.45 1-1v-3c0-.55-.45-1-1-1h-3v-1h4V9h-2V8h-2v1h-1c-.55 0-1 .45-1 1v3c0 .55.45 1 1 1h3v1H9v1h2v1zm9-13H4c-1.11 0-2 .89-2 2v14c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V6c0-1.11-.89-2-2-2zm0 16H4V6h16v14z"/></svg>
                    Bayar Sekarang
                </button>
                <p class="text-center text-xs text-gray-400 mt-3">
                    Pembayaran aman diproses oleh <span class="font-semibold text-gray-500">Midtrans</span>
                </p>
            </div>
        </div>

    </div>
</div>

@push('scripts')
<script src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}">
</script>
<script>
    window.snapToken  = "{{ $snapToken }}";
    window.orderId    = "{{ $order->order_id }}";
    window.successUrl = "{{ route('orders.success') }}";
</script>
@vite(['resources/js/payment.js'])
@endpush
@endsection
