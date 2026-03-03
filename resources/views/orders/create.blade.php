@extends('layouts.app')
@section('title', 'Form Pemesanan')

@section('content')
<div class="p-6">
    <div class="max-w-2xl mx-auto">

        {{-- Header --}}
        <div class="flex items-center gap-3 mb-6">
            <a href="{{ route('services.index') }}"
                class="p-2 rounded-xl hover:bg-pink-50 text-gray-400 hover:text-pink-700 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/></svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Form Pemesanan</h1>
                <p class="text-sm text-gray-500 mt-0.5">Isi data diri untuk melanjutkan pembayaran</p>
            </div>
        </div>

        {{-- Info Layanan --}}
        <div class="bg-gradient-to-r from-pink-700 to-pink-500 rounded-2xl p-5 mb-5 text-white shadow-md">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-pink-200 text-xs font-semibold uppercase tracking-wider mb-1">Layanan Dipilih</p>
                    <h2 class="text-xl font-bold">{{ $service->name }}</h2>
                    @if($service->description)
                        <p class="text-pink-100 text-sm mt-1 leading-relaxed">{{ $service->description }}</p>
                    @endif
                    @if($service->duration)
                        <span class="inline-block mt-2 text-xs bg-white/20 text-white px-2.5 py-1 rounded-full">
                            ⏱ {{ $service->duration }}
                        </span>
                    @endif
                </div>
                <div class="text-right ml-4 flex-shrink-0">
                    <p class="text-pink-200 text-xs">Total</p>
                    <p class="text-2xl font-bold">Rp {{ number_format($service->price, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        {{-- Form --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-base font-bold text-gray-800 mb-5">Data Pemesan</h3>
            <form action="{{ route('orders.store', $service) }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Lengkap <span class="text-pink-500">*</span></label>
                    <input type="text" name="customer_name"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-pink-300 focus:border-pink-400 text-sm transition @error('customer_name') border-red-400 @enderror"
                        value="{{ old('customer_name') }}" placeholder="Nama lengkap kamu" required>
                    @error('customer_name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Email <span class="text-pink-500">*</span></label>
                    <input type="email" name="customer_email"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-pink-300 focus:border-pink-400 text-sm transition @error('customer_email') border-red-400 @enderror"
                        value="{{ old('customer_email') }}" placeholder="email@kamu.com" required>
                    @error('customer_email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">No. Telepon <span class="text-gray-400 font-normal">(opsional)</span></label>
                    <input type="text" name="customer_phone"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-pink-300 focus:border-pink-400 text-sm transition"
                        value="{{ old('customer_phone') }}" placeholder="08xxxxxxxxxx">
                </div>

                {{-- Summary --}}
                <div class="bg-pink-50 rounded-xl p-4 border border-pink-100">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">{{ $service->name }}</span>
                        <span class="font-semibold text-gray-800">Rp {{ number_format($service->price, 0, ',', '.') }}</span>
                    </div>
                    <div class="border-t border-pink-200 mt-3 pt-3 flex justify-between">
                        <span class="font-bold text-gray-800">Total Pembayaran</span>
                        <span class="font-bold text-pink-700 text-lg">Rp {{ number_format($service->price, 0, ',', '.') }}</span>
                    </div>
                </div>

                <button type="submit"
                    class="w-full bg-pink-700 hover:bg-pink-800 text-white font-bold text-sm py-3 rounded-xl shadow transition-all duration-200 hover:shadow-lg flex items-center justify-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M20 4H4c-1.11 0-2 .89-2 2v12c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V6c0-1.11-.89-2-2-2zm0 14H4v-6h16v6zm0-10H4V6h16v2z"/></svg>
                    Lanjut ke Pembayaran
                </button>
            </form>
        </div>

    </div>
</div>
@endsection
