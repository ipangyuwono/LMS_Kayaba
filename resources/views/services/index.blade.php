<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Layanan</title>
    <link rel="icon" href="{{ asset('images/kyb-remove.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/profile.js', 'resources/js/sidebar.js'])
</head>

<style>
    body {
        font-family: 'Inter', sans-serif;
        background: linear-gradient(135deg, #f3f2ec 0%, #e5e4db 100%);
        color: var(--text);
        min-height: 100vh;
    }
</style>

<body class="bg-[#F3F2EC] font-['Manrope',sans-serif]">
    <div class="flex min-h-screen relative overflow-visible">
        @include('components.sidebar')
        <main
            class="main-content flex-1 p-4 md:p-8 md:ml-[230px] transition-all duration-300 ease-[cubic-bezier(0.4,0,0.2,1)] w-full"
            id="mainContent">
            @include('components.header')

            {{-- Alert --}}
            @if(session('success'))
            <div class="flex items-center gap-3 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-5 text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 14l-4-4 1.41-1.41L10 13.17l6.59-6.59L18 8l-8 8z"/></svg>
                {{ session('success') }}
            </div>
            @endif

            <section
                class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200/60 transition-all duration-300 hover:shadow-xl group">
                {{-- Header section --}}
                <div
                    class="p-6 md:p-8 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-gradient-to-r from-gray-50 to-white">
                    <div class="flex items-center gap-4">
                        <div class="w-1 h-8 bg-[#E62727] rounded-full"></div>
                        <h3 class="text-xl md:text-xl font-bold text-gray-800">Data Layanan</h3>
                    </div>

                    <button onclick="openAddModal()"
                        class="flex items-center gap-2 px-5 py-2.5 bg-slate-800 hover:bg-slate-700 text-white font-medium rounded-xl shadow-md transition-all duration-200 hover:shadow-lg hover:scale-[1.02] active:scale-95 whitespace-nowrap">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                            stroke-linejoin="round">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                        Tambah Layanan
                    </button>
                </div>

                {{-- Table --}}
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse min-w-[900px]">
                        <thead>
                            <tr class="text-black">
                                <th class="p-5 pl-8 text-left text-xs font-semibold uppercase tracking-wide">No</th>
                                <th class="p-5 text-left text-xs font-semibold uppercase tracking-wide">Nama Layanan</th>
                                <th class="p-5 text-left text-xs font-semibold uppercase tracking-wide">Deskripsi</th>
                                <th class="p-5 text-left text-xs font-semibold uppercase tracking-wide">Harga</th>
                                <th class="p-5 text-left text-xs font-semibold uppercase tracking-wide">Durasi</th>
                                <th class="p-5 text-left text-xs font-semibold uppercase tracking-wide">Status</th>
                                <th class="p-5 pr-8 text-left text-xs font-semibold uppercase tracking-wide">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($services as $service)
                            <tr
                                class="hover:bg-red-50/50 transition-colors duration-150 {{ $loop->even ? 'bg-gray-50/40' : '' }}">
                                <td class="p-5 pl-8 text-sm font-bold text-[#E62727]">{{ $loop->iteration }}</td>
                                <td class="p-5 text-sm font-semibold text-gray-900">{{ $service->name }}</td>
                                <td class="p-5 text-sm text-gray-500 max-w-xs truncate">{{ $service->description ?? '-' }}</td>
                                <td class="p-5 text-sm font-bold text-[#E62727]">Rp {{ number_format($service->price, 0, ',', '.') }}</td>
                                <td class="p-5 text-sm text-gray-700">{{ $service->duration ?? '-' }}</td>
                                <td class="p-5 text-sm">
                                    @if($service->is_active)
                                        <span class="inline-flex items-center gap-1 bg-green-100 text-green-700 text-xs font-semibold px-2.5 py-1 rounded-full">
                                            <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span> Aktif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 bg-gray-100 text-gray-500 text-xs font-semibold px-2.5 py-1 rounded-full">
                                            <span class="w-1.5 h-1.5 bg-gray-400 rounded-full"></span> Nonaktif
                                        </span>
                                    @endif
                                </td>
                                <td class="p-5 pr-8">
                                    <div class="flex items-center gap-3">
                                        {{-- Pesan --}}
                                        <button
                                            onclick="openOrderModal({{ $service->id }}, '{{ addslashes($service->name) }}', '{{ addslashes($service->description ?? '') }}', {{ $service->price }}, '{{ addslashes($service->duration ?? '') }}')"
                                            class="w-9 h-9 flex items-center justify-center text-[#E62727] hover:bg-[#E62727]/10 rounded-lg transition-all hover:scale-110 border border-transparent hover:border-[#E62727]/30"
                                            title="Pesan">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <circle cx="9" cy="21" r="1"></circle>
                                                <circle cx="20" cy="21" r="1"></circle>
                                                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                                            </svg>
                                        </button>

                                        {{-- Edit --}}
                                        <button
                                            onclick="openEditModal({{ $service->id }}, '{{ addslashes($service->name) }}', '{{ addslashes($service->description ?? '') }}', {{ $service->price }}, '{{ addslashes($service->duration ?? '') }}', {{ $service->is_active ? 'true' : 'false' }})"
                                            class="w-9 h-9 flex items-center justify-center text-[#E62727] hover:bg-[#E62727]/10 rounded-lg transition-all hover:scale-110 border border-transparent hover:border-[#E62727]/30"
                                            title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                            </svg>
                                        </button>

                                        {{-- Delete --}}
                                        <form action="{{ route('services.destroy', $service) }}" method="POST"
                                            onsubmit="return confirm('Hapus layanan {{ addslashes($service->name) }}?')"
                                            class="m-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="w-9 h-9 flex items-center justify-center text-white bg-red-600 hover:bg-red-700 rounded-lg transition-all hover:scale-110 shadow-sm"
                                                title="Hapus">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <polyline points="3 6 5 6 21 6"></polyline>
                                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                    <line x1="10" y1="11" x2="10" y2="17"></line>
                                                    <line x1="14" y1="11" x2="14" y2="17"></line>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7">
                                    <div class="p-12 text-center text-gray-500">
                                        <p class="text-lg">Belum ada data layanan.</p>
                                        <button onclick="openAddModal()" class="mt-4 text-[#E62727] hover:underline">Tambah layanan pertama sekarang →</button>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($services->hasPages())
                <div class="px-8 py-4 border-t border-gray-100">
                    {{ $services->links() }}
                </div>
                @endif
            </section>
        </main>
    </div>

    {{-- Modal Edit Layanan --}}
    <div id="editModal" class="fixed inset-0 z-[1000] hidden items-center justify-center bg-black/60 backdrop-blur-sm">
        <div class="relative w-[90%] max-w-[520px] overflow-hidden rounded-2xl bg-white shadow-[0_32px_64px_rgba(0,0,0,0.2)]">

            {{-- Header --}}
            <div class="relative bg-black px-8 py-6">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2.5" class="text-white">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-white">Edit Layanan</h2>
                        <p class="text-white/60 text-xs mt-0.5">Perbarui data layanan</p>
                    </div>
                </div>
                <button onclick="closeEditModal()"
                    class="absolute top-5 right-5 w-8 h-8 rounded-lg bg-white/10 hover:bg-white/25 transition-all flex items-center justify-center text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Form --}}
            <form id="editForm" method="POST" class="px-8 py-6">
                @csrf
                @method('PUT')
                <div class="space-y-4">

                    {{-- Nama Layanan --}}
                    <div class="group">
                        <label for="edit_name"
                            class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1.5 group-focus-within:text-[#E62727] transition-colors">
                            Nama Layanan
                        </label>
                        <input type="text" id="edit_name" name="name" required placeholder="Masukkan nama layanan"
                            class="w-full h-11 bg-slate-50 border border-slate-200 rounded-xl px-4 text-sm text-slate-700 font-medium transition-all focus:bg-white focus:border-[#E62727] focus:ring-4 focus:ring-[#E62727]/10 outline-none placeholder:text-slate-300">
                    </div>

                    {{-- Deskripsi --}}
                    <div class="group">
                        <label for="edit_description"
                            class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1.5 group-focus-within:text-[#E62727] transition-colors">
                            Deskripsi
                        </label>
                        <textarea id="edit_description" name="description" rows="2" placeholder="Masukkan deskripsi layanan"
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-700 font-medium transition-all focus:bg-white focus:border-[#E62727] focus:ring-4 focus:ring-[#E62727]/10 outline-none placeholder:text-slate-300 resize-none"></textarea>
                    </div>

                    {{-- Harga & Durasi --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div class="group">
                            <label for="edit_price"
                                class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1.5 group-focus-within:text-[#E62727] transition-colors">
                                Harga (Rp)
                            </label>
                            <input type="number" id="edit_price" name="price" min="0" required placeholder="0"
                                class="w-full h-11 bg-slate-50 border border-slate-200 rounded-xl px-4 text-sm text-slate-700 font-medium transition-all focus:bg-white focus:border-[#E62727] focus:ring-4 focus:ring-[#E62727]/10 outline-none placeholder:text-slate-300">
                        </div>
                        <div class="group">
                            <label for="edit_duration"
                                class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1.5 group-focus-within:text-[#E62727] transition-colors">
                                Durasi
                            </label>
                            <input type="text" id="edit_duration" name="duration" placeholder="mis: 1 Hari"
                                class="w-full h-11 bg-slate-50 border border-slate-200 rounded-xl px-4 text-sm text-slate-700 font-medium transition-all focus:bg-white focus:border-[#E62727] focus:ring-4 focus:ring-[#E62727]/10 outline-none placeholder:text-slate-300">
                        </div>
                    </div>

                    {{-- Status Aktif --}}
                    <div class="flex items-center gap-3 py-1">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="edit_is_active" name="is_active" class="sr-only peer">
                            <div class="w-10 h-5 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-5 peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-[#E62727]"></div>
                        </label>
                        <span class="text-sm font-medium text-gray-700">Aktifkan layanan ini</span>
                    </div>

                </div>

                {{-- Footer --}}
                <div class="mt-6 flex gap-3">
                    <button type="button" onclick="closeEditModal()"
                        class="flex-1 h-11 bg-slate-100 text-slate-500 rounded-xl text-sm font-bold transition-all hover:bg-slate-200">
                        Batal
                    </button>
                    <button type="submit"
                        class="flex-1 h-11 bg-gradient-to-r from-[#8B0000] to-[#E62727] text-white rounded-xl text-sm font-bold shadow-[0_4px_15px_rgba(230,39,39,0.3)] transition-all hover:shadow-[0_6px_20px_rgba(230,39,39,0.4)] hover:scale-[1.02] active:scale-95">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Tambah Layanan --}}
    <div id="addModal" class="fixed inset-0 z-[1000] hidden items-center justify-center bg-black/60 backdrop-blur-sm">
        <div class="relative w-[90%] max-w-[520px] overflow-hidden rounded-2xl bg-white shadow-[0_32px_64px_rgba(0,0,0,0.2)]">

            {{-- Header --}}
            <div class="relative bg-black px-8 py-6">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2.5" class="text-white">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-white">Tambah Layanan</h2>
                        <p class="text-white/60 text-xs mt-0.5">Isi data layanan baru</p>
                    </div>
                </div>
                <button onclick="closeAddModal()"
                    class="absolute top-5 right-5 w-8 h-8 rounded-lg bg-white/10 hover:bg-white/25 transition-all flex items-center justify-center text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Form --}}
            <form action="{{ route('services.store') }}" method="POST" class="px-8 py-6">
                @csrf
                <div class="space-y-4">

                    {{-- Nama Layanan --}}
                    <div class="group">
                        <label
                            class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1.5 group-focus-within:text-[#E62727] transition-colors">
                            Nama Layanan
                        </label>
                        <input type="text" name="name" required placeholder="Masukkan nama layanan"
                            class="w-full h-11 bg-slate-50 border border-slate-200 rounded-xl px-4 text-sm text-slate-700 font-medium transition-all focus:bg-white focus:border-[#E62727] focus:ring-4 focus:ring-[#E62727]/10 outline-none placeholder:text-slate-300">
                    </div>

                    {{-- Deskripsi --}}
                    <div class="group">
                        <label
                            class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1.5 group-focus-within:text-[#E62727] transition-colors">
                            Deskripsi
                        </label>
                        <textarea name="description" rows="2" placeholder="Masukkan deskripsi layanan"
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-700 font-medium transition-all focus:bg-white focus:border-[#E62727] focus:ring-4 focus:ring-[#E62727]/10 outline-none placeholder:text-slate-300 resize-none"></textarea>
                    </div>

                    {{-- Harga & Durasi --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div class="group">
                            <label
                                class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1.5 group-focus-within:text-[#E62727] transition-colors">
                                Harga (Rp)
                            </label>
                            <input type="number" name="price" min="0" required placeholder="0"
                                class="w-full h-11 bg-slate-50 border border-slate-200 rounded-xl px-4 text-sm text-slate-700 font-medium transition-all focus:bg-white focus:border-[#E62727] focus:ring-4 focus:ring-[#E62727]/10 outline-none placeholder:text-slate-300">
                        </div>
                        <div class="group">
                            <label
                                class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1.5 group-focus-within:text-[#E62727] transition-colors">
                                Durasi
                            </label>
                            <input type="text" name="duration" placeholder="mis: 1 Hari"
                                class="w-full h-11 bg-slate-50 border border-slate-200 rounded-xl px-4 text-sm text-slate-700 font-medium transition-all focus:bg-white focus:border-[#E62727] focus:ring-4 focus:ring-[#E62727]/10 outline-none placeholder:text-slate-300">
                        </div>
                    </div>

                    {{-- Status Aktif --}}
                    <div class="flex items-center gap-3 py-1">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_active" class="sr-only peer" checked>
                            <div class="w-10 h-5 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-5 peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-[#E62727]"></div>
                        </label>
                        <span class="text-sm font-medium text-gray-700">Aktifkan layanan ini</span>
                    </div>

                </div>

                {{-- Footer --}}
                <div class="mt-6 flex gap-3">
                    <button type="button" onclick="closeAddModal()"
                        class="flex-1 h-11 bg-slate-100 text-slate-500 rounded-xl text-sm font-bold transition-all hover:bg-slate-200">
                        Batal
                    </button>
                    <button type="submit"
                        class="flex-1 h-11 bg-gradient-to-r from-[#8B0000] to-[#E62727] text-white rounded-xl text-sm font-bold shadow-[0_4px_15px_rgba(230,39,39,0.3)] transition-all hover:shadow-[0_6px_20px_rgba(230,39,39,0.4)] hover:scale-[1.02] active:scale-95">
                        Simpan Layanan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Pesan / Order --}}
    <div id="orderModal" class="fixed inset-0 z-[1000] hidden items-center justify-center bg-black/60 backdrop-blur-sm">
        <div class="relative w-[90%] max-w-[520px] overflow-hidden rounded-2xl bg-white shadow-[0_32px_64px_rgba(0,0,0,0.2)]">

            {{-- Header --}}
            <div class="relative bg-black px-8 py-6">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="text-white">
                            <circle cx="9" cy="21" r="1"></circle>
                            <circle cx="20" cy="21" r="1"></circle>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-white">Pesan Layanan</h2>
                        <p class="text-white/60 text-xs mt-0.5">Isi data diri untuk melanjutkan pembayaran</p>
                    </div>
                </div>
                <button onclick="closeOrderModal()"
                    class="absolute top-5 right-5 w-8 h-8 rounded-lg bg-white/10 hover:bg-white/25 transition-all flex items-center justify-center text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Info Layanan --}}
            <div class="bg-gradient-to-r from-[#8B0000] to-[#E62727] px-8 py-4">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <p class="text-red-200 text-xs font-semibold uppercase tracking-wider mb-0.5">Layanan Dipilih</p>
                        <h3 id="order_service_name" class="text-base font-bold text-white"></h3>
                        <p id="order_service_desc" class="text-red-100 text-xs mt-0.5 leading-relaxed"></p>
                        <span id="order_service_duration" class="inline-block mt-1 text-xs bg-white/20 text-white px-2 py-0.5 rounded-full"></span>
                    </div>
                    <div class="text-right ml-4 flex-shrink-0">
                        <p class="text-red-200 text-xs">Total</p>
                        <p id="order_service_price" class="text-xl font-bold text-white"></p>
                    </div>
                </div>
            </div>

            {{-- Form --}}
            <form id="orderForm" method="POST" class="px-8 py-6">
                @csrf
                <div class="space-y-4">

                    {{-- Nama Lengkap --}}
                    <div class="group">
                        <label
                            class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1.5 group-focus-within:text-[#E62727] transition-colors">
                            Nama Lengkap
                        </label>
                        <input type="text" name="customer_name" required placeholder="Nama lengkap pemesan"
                            class="w-full h-11 bg-slate-50 border border-slate-200 rounded-xl px-4 text-sm text-slate-700 font-medium transition-all focus:bg-white focus:border-[#E62727] focus:ring-4 focus:ring-[#E62727]/10 outline-none placeholder:text-slate-300">
                    </div>

                    {{-- Email --}}
                    <div class="group">
                        <label
                            class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1.5 group-focus-within:text-[#E62727] transition-colors">
                            Email
                        </label>
                        <input type="email" name="customer_email" required placeholder="email@kamu.com"
                            class="w-full h-11 bg-slate-50 border border-slate-200 rounded-xl px-4 text-sm text-slate-700 font-medium transition-all focus:bg-white focus:border-[#E62727] focus:ring-4 focus:ring-[#E62727]/10 outline-none placeholder:text-slate-300">
                    </div>

                    {{-- No. Telepon --}}
                    <div class="group">
                        <label
                            class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1.5 group-focus-within:text-[#E62727] transition-colors">
                            No. Telepon <span class="normal-case font-normal text-slate-300 ml-1">(opsional)</span>
                        </label>
                        <input type="text" name="customer_phone" placeholder="08xxxxxxxxxx"
                            class="w-full h-11 bg-slate-50 border border-slate-200 rounded-xl px-4 text-sm text-slate-700 font-medium transition-all focus:bg-white focus:border-[#E62727] focus:ring-4 focus:ring-[#E62727]/10 outline-none placeholder:text-slate-300">
                    </div>

                </div>

                {{-- Footer --}}
                <div class="mt-6 flex gap-3">
                    <button type="button" onclick="closeOrderModal()"
                        class="flex-1 h-11 bg-slate-100 text-slate-500 rounded-xl text-sm font-bold transition-all hover:bg-slate-200">
                        Batal
                    </button>
                    <button type="submit"
                        class="flex-1 h-11 bg-gradient-to-r from-[#8B0000] to-[#E62727] text-white rounded-xl text-sm font-bold shadow-[0_4px_15px_rgba(230,39,39,0.3)] transition-all hover:shadow-[0_6px_20px_rgba(230,39,39,0.4)] hover:scale-[1.02] active:scale-95 flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M20 4H4c-1.11 0-2 .89-2 2v12c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V6c0-1.11-.89-2-2-2zm0 14H4v-6h16v6zm0-10H4V6h16v2z"/></svg>
                        Lanjut ke Pembayaran
                    </button>
                </div>
            </form>
        </div>
    </div>

    @include('components.footer')
    @include('components.profile-modal')

    <script>
        // ── Add Modal ──
        function openAddModal() {
            const modal = document.getElementById('addModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
        function closeAddModal() {
            const modal = document.getElementById('addModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        // ── Edit Modal ──
        function openEditModal(id, name, description, price, duration, isActive) {
            const modal = document.getElementById('editModal');
            const form  = document.getElementById('editForm');
            form.action = `/services/${id}`;
            document.getElementById('edit_name').value        = name;
            document.getElementById('edit_description').value = description;
            document.getElementById('edit_price').value       = price;
            document.getElementById('edit_duration').value    = duration;
            document.getElementById('edit_is_active').checked = isActive;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
        function closeEditModal() {
            const modal = document.getElementById('editModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        // ── Order Modal ──
        function openOrderModal(serviceId, name, description, price, duration) {
            document.getElementById('order_service_name').textContent  = name;
            document.getElementById('order_service_price').textContent =
                'Rp ' + price.toLocaleString('id-ID');

            const descEl = document.getElementById('order_service_desc');
            descEl.textContent = description || '';
            descEl.style.display = description ? '' : 'none';

            const durEl = document.getElementById('order_service_duration');
            durEl.textContent = duration ? '⏱ ' + duration : '';
            durEl.style.display = duration ? '' : 'none';

            // Set action form ke route orders.store dengan service id
            document.getElementById('orderForm').action = `/order/${serviceId}`;

            const modal = document.getElementById('orderModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
        function closeOrderModal() {
            const modal = document.getElementById('orderModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        // Tutup modal saat klik di luar
        document.getElementById('addModal').addEventListener('click', function(e) {
            if (e.target === this) closeAddModal();
        });
        document.getElementById('editModal').addEventListener('click', function(e) {
            if (e.target === this) closeEditModal();
        });
        document.getElementById('orderModal').addEventListener('click', function(e) {
            if (e.target === this) closeOrderModal();
        });
    </script>
</body>

</html>
