@extends('layouts.app')
@section('title', 'Tambah Service')

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
                <h1 class="text-2xl font-bold text-gray-800">Tambah Service</h1>
                <p class="text-sm text-gray-500 mt-0.5">Tambah Service baru yang tersedia</p>
            </div>
        </div>

        {{-- Form Card --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <form action="{{ route('services.store') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Service <span class="text-pink-500">*</span></label>
                    <input type="text" name="name"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-pink-300 focus:border-pink-400 text-sm transition @error('name') border-red-400 ring-2 ring-red-100 @enderror"
                        value="{{ old('name') }}" placeholder="Nama Service" required>
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Deskripsi</label>
                    <textarea name="description" rows="3"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-pink-300 focus:border-pink-400 text-sm transition resize-none"
                        placeholder="Deskripsi singkat Service (opsional)">{{ old('description') }}</textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Harga (Rp) <span class="text-pink-500">*</span></label>
                        <input type="number" name="price" min="0"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-pink-300 focus:border-pink-400 text-sm transition @error('price') border-red-400 ring-2 ring-red-100 @enderror"
                            value="{{ old('price') }}" placeholder="0" required>
                        @error('price')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Durasi</label>
                        <input type="text" name="duration"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-pink-300 focus:border-pink-400 text-sm transition"
                            value="{{ old('duration') }}" placeholder="mis. 1 jam, per bulan">
                    </div>
                </div>

                <div class="flex items-center gap-3 py-1">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_active" class="sr-only peer" checked>
                        <div class="w-10 h-5 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-5 peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-pink-600"></div>
                    </label>
                    <span class="text-sm font-medium text-gray-700">Aktifkan Service ini</span>
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <button type="submit"
                        class="bg-pink-700 hover:bg-pink-800 text-white font-semibold text-sm px-6 py-2.5 rounded-xl shadow transition-all duration-200 hover:shadow-md">
                        Simpan Service
                    </button>
                    <a href="{{ route('services.index') }}"
                        class="text-gray-500 hover:text-gray-700 font-medium text-sm px-4 py-2.5 rounded-xl hover:bg-gray-100 transition-colors">
                        Batal
                    </a>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection
