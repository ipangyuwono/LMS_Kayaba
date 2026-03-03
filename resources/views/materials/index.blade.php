<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Materi</title>
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

{{-- Modal Preview Materi --}}
<div id="previewModal" class="fixed inset-0 z-[1100] hidden items-center justify-center bg-black/70 backdrop-blur-sm">
    <div
        class="relative w-[95%] max-w-[800px] max-h-[90vh] rounded-2xl bg-white shadow-[0_32px_64px_rgba(0,0,0,0.3)] flex flex-col overflow-hidden">
        {{-- Header --}}
        <div class="bg-black px-6 py-4 flex items-center justify-between flex-shrink-0">
            <div class="flex items-center gap-3">
                <span id="previewIcon" class="text-xl"></span>
                <div>
                    <h2 id="previewTitle" class="text-sm font-bold text-white"></h2>
                    <p id="previewType" class="text-white/50 text-xs mt-0.5"></p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <a id="previewOpenLink" href="#" target="_blank"
                    class="flex items-center gap-1.5 bg-white/10 hover:bg-white/20 text-white text-xs font-semibold px-3 py-1.5 rounded-lg transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                    Buka di tab baru
                </a>
                <button onclick="closePreviewModal()"
                    class="w-8 h-8 rounded-lg bg-white/10 hover:bg-white/25 transition-all flex items-center justify-center text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        {{-- Content --}}
        <div id="previewContent" class="flex-1 overflow-auto min-h-[400px] bg-gray-50">
            {{-- Diisi via JS --}}
        </div>
    </div>
</div>

<body class="bg-[#F3F2EC] font-['Manrope',sans-serif]">
    <div class="flex min-h-screen relative overflow-visible">
        @include('components.sidebar')
        <main
            class="main-content flex-1 p-4 md:p-8 md:ml-[230px] transition-all duration-300 ease-[cubic-bezier(0.4,0,0.2,1)] w-full"
            id="mainContent">
            @include('components.header')

            {{-- Alert --}}
            @if (session('success'))
                <div
                    class="flex items-center gap-3 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-5 text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                        viewBox="0 0 24 24">
                        <path
                            d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 14l-4-4 1.41-1.41L10 13.17l6.59-6.59L18 8l-8 8z" />
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div
                    class="flex items-center gap-3 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-5 text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                        viewBox="0 0 24 24">
                        <path
                            d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z" />
                    </svg>
                    {{ $errors->first() }}
                </div>
            @endif

            {{-- Stats Cards --}}
            @php
                $totalMat = \App\Models\Material::count();
                $activeMat = \App\Models\Material::where('is_active', true)->count();
                $videoCount = \App\Models\Material::where('type', 'video')->count();
                $pdfCount = \App\Models\Material::where('type', 'pdf')->count();
            @endphp
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                <div
                    class="bg-white rounded-xl border border-gray-200/60 shadow-lg px-5 py-4 hover:shadow-xl transition-all duration-300">
                    <p class="text-xs text-gray-500 font-semibold uppercase tracking-wide">Total Materi</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">{{ $totalMat }}</p>
                </div>
                <div
                    class="bg-white rounded-xl border border-gray-200/60 shadow-lg px-5 py-4 hover:shadow-xl transition-all duration-300">
                    <p class="text-xs text-green-600 font-semibold uppercase tracking-wide">Aktif</p>
                    <p class="text-2xl font-bold text-green-600 mt-1">{{ $activeMat }}</p>
                </div>
                <div
                    class="bg-white rounded-xl border border-gray-200/60 shadow-lg px-5 py-4 hover:shadow-xl transition-all duration-300">
                    <p class="text-xs text-blue-600 font-semibold uppercase tracking-wide">Video</p>
                    <p class="text-2xl font-bold text-blue-600 mt-1">{{ $videoCount }}</p>
                </div>
                <div
                    class="bg-white rounded-xl border border-gray-200/60 shadow-lg px-5 py-4 hover:shadow-xl transition-all duration-300">
                    <p class="text-xs text-red-500 font-semibold uppercase tracking-wide">PDF</p>
                    <p class="text-2xl font-bold text-red-500 mt-1">{{ $pdfCount }}</p>
                </div>
            </div>

            <section
                class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200/60 transition-all duration-300 hover:shadow-xl group">
                {{-- Header --}}
                <div
                    class="p-6 md:p-8 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-gradient-to-r from-gray-50 to-white">
                    <div class="flex items-center gap-4">
                        <div class="w-1 h-8 bg-[#E62727] rounded-full"></div>
                        <h3 class="text-xl font-bold text-gray-800">Data Materi</h3>
                    </div>
                    <button onclick="openAddModal()"
                        class="flex items-center gap-2 bg-gradient-to-r from-[#8B0000] to-[#E62727] text-white px-5 py-2.5 rounded-xl text-sm font-bold shadow-[0_4px_15px_rgba(230,39,39,0.3)] hover:shadow-[0_6px_20px_rgba(230,39,39,0.4)] hover:scale-[1.02] active:scale-95 transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2.5">
                            <line x1="12" y1="5" x2="12" y2="19" />
                            <line x1="5" y1="12" x2="19" y2="12" />
                        </svg>
                        Tambah Materi
                    </button>
                </div>

                {{-- Table --}}
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse min-w-[800px]">
                        <thead>
                            <tr class="text-black">
                                <th class="p-5 pl-8 text-left text-xs font-semibold uppercase tracking-wide w-10">No
                                </th>
                                <th class="p-5 text-left text-xs font-semibold uppercase tracking-wide">Layanan</th>
                                <th class="p-5 text-left text-xs font-semibold uppercase tracking-wide">Judul</th>
                                <th class="p-5 text-left text-xs font-semibold uppercase tracking-wide">Tipe</th>
                                <th class="p-5 text-left text-xs font-semibold uppercase tracking-wide">Urutan</th>
                                <th class="p-5 text-left text-xs font-semibold uppercase tracking-wide">Status</th>
                                <th class="p-5 pr-8 text-left text-xs font-semibold uppercase tracking-wide">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($materials as $mat)
                                <tr
                                    class="hover:bg-red-50/50 transition-colors duration-150 {{ $loop->even ? 'bg-gray-50/40' : '' }}">
                                    <td class="p-5 pl-8 text-sm text-gray-500">
                                        {{ $loop->iteration + ($materials->currentPage() - 1) * $materials->perPage() }}
                                    </td>
                                    <td class="p-5 text-sm">
                                        <span
                                            class="bg-gray-100 text-gray-700 text-xs font-semibold px-2.5 py-1 rounded-lg">{{ $mat->service->name }}</span>
                                    </td>
                                    <td class="p-5 text-sm font-semibold text-gray-900">{{ $mat->title }}</td>
                                    <td class="p-5 text-sm">
                                        @php
                                            $typeColors = [
                                                'video' => 'bg-blue-100 text-blue-700',
                                                'pdf' => 'bg-red-100 text-red-600',
                                                'document' => 'bg-amber-100 text-amber-700',
                                                'link' => 'bg-purple-100 text-purple-700',
                                            ];
                                            $typeIcons = [
                                                'video' => '🎬',
                                                'pdf' => '📄',
                                                'document' => '📝',
                                                'link' => '🔗',
                                            ];
                                        @endphp
                                        {{-- <span class="inline-flex items-center gap-1 {{ $typeColors[$mat->type] ?? 'bg-gray-100 text-gray-500' }} text-xs font-semibold px-2.5 py-1 rounded-full">
                                        {{ $typeIcons[$mat->type] ?? '' }} {{ strtoupper($mat->type) }}
                                    </span> --}}

                                        @php
                                            $previewTarget =
                                                $mat->type === 'link'
                                                    ? $mat->url ?? '#'
                                                    : ($mat->file_path
                                                        ? asset('storage/' . $mat->file_path)
                                                        : null);
                                        @endphp
                                        @if ($previewTarget)
                                            <button
                                                onclick="openPreviewModal('{{ $mat->type }}', '{{ $previewTarget }}', '{{ addslashes($mat->title) }}')"
                                                class="inline-flex items-center gap-1 {{ $typeColors[$mat->type] ?? 'bg-gray-100 text-gray-500' }} text-xs font-semibold px-2.5 py-1 rounded-full hover:opacity-80 hover:scale-105 transition-all cursor-pointer border border-transparent hover:border-current/30"
                                                title="Klik untuk preview">
                                                {{ $typeIcons[$mat->type] ?? '' }} {{ strtoupper($mat->type) }}
                                            </button>
                                        @else
                                            <span
                                                class="inline-flex items-center gap-1 {{ $typeColors[$mat->type] ?? 'bg-gray-100 text-gray-500' }} text-xs font-semibold px-2.5 py-1 rounded-full opacity-50">
                                                {{ $typeIcons[$mat->type] ?? '' }} {{ strtoupper($mat->type) }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="p-5 text-sm text-gray-500 font-mono">{{ $mat->position }}</td>
                                    <td class="p-5 text-sm">
                                        @if ($mat->is_active)
                                            <span
                                                class="inline-flex items-center gap-1 bg-green-100 text-green-700 text-xs font-semibold px-2.5 py-1 rounded-full">
                                                <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span> Aktif
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center gap-1 bg-gray-100 text-gray-500 text-xs font-semibold px-2.5 py-1 rounded-full">
                                                <span class="w-1.5 h-1.5 bg-gray-400 rounded-full"></span> Nonaktif
                                            </span>
                                        @endif
                                    </td>
                                    <td class="p-5 pr-8">
                                        <div class="flex items-center gap-3">
                                            <button onclick='openEditModal(@json($mat))'
                                                class="w-9 h-9 flex items-center justify-center text-[#E62727] hover:bg-[#E62727]/10 rounded-lg transition-all hover:scale-110 border border-transparent hover:border-[#E62727]/30"
                                                title="Edit">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path
                                                        d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                                                </svg>
                                            </button>
                                            <form action="{{ route('materials.destroy', $mat) }}" method="POST"
                                                onsubmit="return confirm('Yakin hapus materi ini?')">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    class="w-9 h-9 flex items-center justify-center text-red-400 hover:bg-red-50 rounded-lg transition-all hover:scale-110 border border-transparent hover:border-red-200"
                                                    title="Hapus">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="18"
                                                        height="18" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <polyline points="3 6 5 6 21 6" />
                                                        <path
                                                            d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
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
                                            <p class="text-lg">Belum ada data materi.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($materials->hasPages())
                    <div class="px-8 py-4 border-t border-gray-100">{{ $materials->links() }}</div>
                @endif
            </section>
        </main>
    </div>

    {{-- Modal Tambah Materi --}}
    <div id="addModal"
        class="fixed inset-0 z-[1000] hidden items-center justify-center bg-black/60 backdrop-blur-sm">
        <div
            class="relative w-[90%] max-w-[520px] max-h-[90vh] overflow-y-auto rounded-2xl bg-white shadow-[0_32px_64px_rgba(0,0,0,0.2)]">
            <div class="relative bg-black px-8 py-6">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2.5" class="text-white">
                            <line x1="12" y1="5" x2="12" y2="19" />
                            <line x1="5" y1="12" x2="19" y2="12" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-white">Tambah Materi</h2>
                        <p class="text-white/60 text-xs mt-0.5">Isi data materi baru</p>
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
            <form action="{{ route('materials.store') }}" method="POST" enctype="multipart/form-data"
                class="px-8 py-6 space-y-4">
                @csrf
                <div class="group">
                    <label
                        class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1.5 group-focus-within:text-[#E62727] transition-colors">Layanan</label>
                    <select name="service_id" required
                        class="w-full h-11 bg-slate-50 border border-slate-200 rounded-xl px-4 text-sm text-slate-700 font-medium transition-all focus:bg-white focus:border-[#E62727] focus:ring-4 focus:ring-[#E62727]/10 outline-none">
                        <option value="">Pilih layanan...</option>
                        @foreach ($services as $svc)
                            <option value="{{ $svc->id }}">{{ $svc->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="group">
                    <label
                        class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1.5 group-focus-within:text-[#E62727] transition-colors">Judul
                        Materi</label>
                    <input type="text" name="title" required placeholder="Judul materi pelatihan"
                        class="w-full h-11 bg-slate-50 border border-slate-200 rounded-xl px-4 text-sm text-slate-700 font-medium transition-all focus:bg-white focus:border-[#E62727] focus:ring-4 focus:ring-[#E62727]/10 outline-none placeholder:text-slate-300">
                </div>
                <div class="group">
                    <label
                        class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1.5 group-focus-within:text-[#E62727] transition-colors">Deskripsi</label>
                    <textarea name="description" rows="2" placeholder="Deskripsi singkat materi"
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-700 font-medium transition-all focus:bg-white focus:border-[#E62727] focus:ring-4 focus:ring-[#E62727]/10 outline-none resize-none placeholder:text-slate-300"></textarea>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="group">
                        <label
                            class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1.5 group-focus-within:text-[#E62727] transition-colors">Tipe</label>
                        <select name="type" id="addType" onchange="toggleFileUrl('add')" required
                            class="w-full h-11 bg-slate-50 border border-slate-200 rounded-xl px-4 text-sm text-slate-700 font-medium transition-all focus:bg-white focus:border-[#E62727] focus:ring-4 focus:ring-[#E62727]/10 outline-none">
                            <option value="pdf">PDF</option>
                            <option value="link">Link</option>
                        </select>
                    </div>
                    <div class="group">
                        <label
                            class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1.5 group-focus-within:text-[#E62727] transition-colors">Urutan</label>
                        <input type="number" name="position" value="0" min="0"
                            class="w-full h-11 bg-slate-50 border border-slate-200 rounded-xl px-4 text-sm text-slate-700 font-medium transition-all focus:bg-white focus:border-[#E62727] focus:ring-4 focus:ring-[#E62727]/10 outline-none">
                    </div>
                </div>
                <div id="addFileWrap" class="group">
                    <label
                        class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1.5 group-focus-within:text-[#E62727] transition-colors">Upload
                        File</label>
                    <input type="file" name="file"
                        class="w-full h-11 bg-slate-50 border border-slate-200 rounded-xl px-4 text-sm text-slate-700 font-medium transition-all focus:bg-white focus:border-[#E62727] focus:ring-4 focus:ring-[#E62727]/10 outline-none file:mr-3 file:border-0 file:bg-transparent file:text-sm file:font-semibold file:text-[#E62727]">
                </div>
                <div id="addUrlWrap" class="group hidden">
                    <label
                        class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1.5 group-focus-within:text-[#E62727] transition-colors">URL</label>
                    <input type="url" name="url" placeholder="https://..."
                        class="w-full h-11 bg-slate-50 border border-slate-200 rounded-xl px-4 text-sm text-slate-700 font-medium transition-all focus:bg-white focus:border-[#E62727] focus:ring-4 focus:ring-[#E62727]/10 outline-none placeholder:text-slate-300">
                </div>
                <div class="flex items-center gap-3 py-1">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" checked class="sr-only peer">
                        <div
                            class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#E62727]">
                        </div>
                    </label>
                    <span class="text-sm text-slate-500 font-medium">Aktifkan materi ini</span>
                </div>
                <div class="mt-2 flex gap-3">
                    <button type="button" onclick="closeAddModal()"
                        class="flex-1 h-11 bg-slate-100 text-slate-500 rounded-xl text-sm font-bold transition-all hover:bg-slate-200">Batal</button>
                    <button type="submit"
                        class="flex-1 h-11 bg-gradient-to-r from-[#8B0000] to-[#E62727] text-white rounded-xl text-sm font-bold shadow-[0_4px_15px_rgba(230,39,39,0.3)] transition-all hover:shadow-[0_6px_20px_rgba(230,39,39,0.4)] hover:scale-[1.02] active:scale-95">Simpan
                        Materi</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Edit Materi --}}
    <div id="editModal"
        class="fixed inset-0 z-[1000] hidden items-center justify-center bg-black/60 backdrop-blur-sm">
        <div
            class="relative w-[90%] max-w-[520px] max-h-[90vh] overflow-y-auto rounded-2xl bg-white shadow-[0_32px_64px_rgba(0,0,0,0.2)]">
            <div class="relative bg-black px-8 py-6">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2.5" class="text-white">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-white">Edit Materi</h2>
                        <p class="text-white/60 text-xs mt-0.5">Perbarui data materi</p>
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
            <form id="editForm" method="POST" enctype="multipart/form-data" class="px-8 py-6 space-y-4">
                @csrf @method('PUT')
                <div class="group">
                    <label
                        class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1.5">Layanan</label>
                    <select id="edit_service_id" name="service_id" required
                        class="w-full h-11 bg-slate-50 border border-slate-200 rounded-xl px-4 text-sm text-slate-700 font-medium transition-all focus:bg-white focus:border-[#E62727] focus:ring-4 focus:ring-[#E62727]/10 outline-none">
                        @foreach ($services as $svc)
                            <option value="{{ $svc->id }}">{{ $svc->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="group">
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1.5">Judul
                        Materi</label>
                    <input type="text" id="edit_title" name="title" required
                        class="w-full h-11 bg-slate-50 border border-slate-200 rounded-xl px-4 text-sm text-slate-700 font-medium transition-all focus:bg-white focus:border-[#E62727] focus:ring-4 focus:ring-[#E62727]/10 outline-none">
                </div>
                <div class="group">
                    <label
                        class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1.5">Deskripsi</label>
                    <textarea id="edit_description" name="description" rows="2"
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-700 font-medium transition-all focus:bg-white focus:border-[#E62727] focus:ring-4 focus:ring-[#E62727]/10 outline-none resize-none"></textarea>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="group">
                        <label
                            class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1.5">Tipe</label>
                        <select id="edit_type" name="type" onchange="toggleFileUrl('edit')" required
                            class="w-full h-11 bg-slate-50 border border-slate-200 rounded-xl px-4 text-sm text-slate-700 font-medium transition-all focus:bg-white focus:border-[#E62727] focus:ring-4 focus:ring-[#E62727]/10 outline-none">
                            <option value="pdf">PDF</option>
                            <option value="link">Link</option>
                        </select>
                    </div>
                    <div class="group">
                        <label
                            class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1.5">Urutan</label>
                        <input type="number" id="edit_position" name="position" min="0"
                            class="w-full h-11 bg-slate-50 border border-slate-200 rounded-xl px-4 text-sm text-slate-700 font-medium transition-all focus:bg-white focus:border-[#E62727] focus:ring-4 focus:ring-[#E62727]/10 outline-none">
                    </div>
                </div>
                <div id="editFileWrap" class="group">
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1.5">Upload File
                        <span class="normal-case font-normal text-slate-300">(kosongkan jika tidak
                            ganti)</span></label>
                    <input type="file" name="file"
                        class="w-full h-11 bg-slate-50 border border-slate-200 rounded-xl px-4 text-sm text-slate-700 font-medium transition-all focus:bg-white focus:border-[#E62727] focus:ring-4 focus:ring-[#E62727]/10 outline-none file:mr-3 file:border-0 file:bg-transparent file:text-sm file:font-semibold file:text-[#E62727]">
                </div>
                <div id="editUrlWrap" class="group hidden">
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1.5">URL</label>
                    <input type="url" id="edit_url" name="url" placeholder="https://..."
                        class="w-full h-11 bg-slate-50 border border-slate-200 rounded-xl px-4 text-sm text-slate-700 font-medium transition-all focus:bg-white focus:border-[#E62727] focus:ring-4 focus:ring-[#E62727]/10 outline-none placeholder:text-slate-300">
                </div>
                <div class="flex items-center gap-3 py-1">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" id="edit_is_active" name="is_active" value="1"
                            class="sr-only peer">
                        <div
                            class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#E62727]">
                        </div>
                    </label>
                    <span class="text-sm text-slate-500 font-medium">Aktifkan materi ini</span>
                </div>
                <div class="mt-2 flex gap-3">
                    <button type="button" onclick="closeEditModal()"
                        class="flex-1 h-11 bg-slate-100 text-slate-500 rounded-xl text-sm font-bold transition-all hover:bg-slate-200">Batal</button>
                    <button type="submit"
                        class="flex-1 h-11 bg-gradient-to-r from-[#8B0000] to-[#E62727] text-white rounded-xl text-sm font-bold shadow-[0_4px_15px_rgba(230,39,39,0.3)] transition-all hover:shadow-[0_6px_20px_rgba(230,39,39,0.4)] hover:scale-[1.02] active:scale-95">Simpan
                        Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    @include('components.footer')
    @include('components.profile-modal')

    <script>
        function toggleFileUrl(prefix) {
            const typeEl = document.getElementById(prefix + 'Type') ?? document.getElementById(prefix + '_type');
            const type = typeEl.value;
            const fileWrap = document.getElementById(prefix + 'FileWrap');
            const urlWrap = document.getElementById(prefix + 'UrlWrap');

            const fileInput = fileWrap.querySelector('input[type="file"]');
            const acceptMap = {
                'pdf': '.pdf',
                'video': 'video/*',
                'document': '.doc,.docx,.ppt,.pptx,.xls,.xlsx',
            };
            if (fileInput) fileInput.accept = acceptMap[type] ?? '';

            if (type === 'link') {
                fileWrap.classList.add('hidden');
                urlWrap.classList.remove('hidden');
            } else {
                fileWrap.classList.remove('hidden');
                urlWrap.classList.add('hidden');
            }
        }

        function openAddModal() {
            const m = document.getElementById('addModal');
            m.classList.remove('hidden');
            m.classList.add('flex');
            toggleFileUrl('add'); // set accept saat modal pertama dibuka
        }

        function closeAddModal() {
            const m = document.getElementById('addModal');
            m.classList.add('hidden');
            m.classList.remove('flex');
        }

        function openEditModal(mat) {
            document.getElementById('editForm').action = `/materials/${mat.id}`;
            document.getElementById('edit_service_id').value = mat.service_id;
            document.getElementById('edit_title').value = mat.title;
            document.getElementById('edit_description').value = mat.description || '';
            document.getElementById('edit_type').value = mat.type;
            document.getElementById('edit_position').value = mat.position;
            document.getElementById('edit_url').value = mat.url || '';
            document.getElementById('edit_is_active').checked = mat.is_active;
            toggleFileUrl('edit');

            const m = document.getElementById('editModal');
            m.classList.remove('hidden');
            m.classList.add('flex');
        }

        function closeEditModal() {
            const m = document.getElementById('editModal');
            m.classList.add('hidden');
            m.classList.remove('flex');
        }

        // ── Preview Modal ──────────────────────────────────────────────

        const typeIconsMap = {
            video: '🎬',
            pdf: '📄',
            document: '📝',
            link: '🔗'
        };

        function buildPreviewContent(type, url, title) {
            const ytMatch = url.match(/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&\s]+)/);
            const vimeoMatch = url.match(/vimeo\.com\/(\d+)/);
            const isDoc = /\.(doc|docx)$/i.test(url);

            if (type === 'pdf') {
                return `<iframe src="${url}" class="w-full border-0" style="height:70vh;"></iframe>`;
            }

            if (type === 'video' || (type === 'link' && (ytMatch || vimeoMatch))) {
                if (ytMatch) {
                    return `
                    <div class="relative w-full bg-black" style="padding-bottom:56.25%">
                        <iframe class="absolute inset-0 w-full h-full"
                            src="https://www.youtube.com/embed/${ytMatch[1]}"
                            frameborder="0" allowfullscreen
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture">
                        </iframe>
                    </div>`;
                }
                if (vimeoMatch) {
                    return `
                    <div class="relative w-full" style="padding-bottom:56.25%">
                        <iframe class="absolute inset-0 w-full h-full"
                            src="https://player.vimeo.com/video/${vimeoMatch[1]}"
                            frameborder="0" allowfullscreen>
                        </iframe>
                    </div>`;
                }
                return `<video controls class="w-full max-h-[70vh]">
                        <source src="${url}">Browser Anda tidak mendukung video ini.
                    </video>`;
            }

            if (type === 'document') {
                const viewerUrl = isDoc ?
                    `https://docs.google.com/gview?url=${encodeURIComponent(url)}&embedded=true` :
                    url;
                return `<iframe src="${viewerUrl}" class="w-full border-0" style="height:70vh;"></iframe>`;
            }

            // Fallback: link biasa
            return `
            <div class="flex flex-col items-center justify-center h-full min-h-[400px] p-8 text-center gap-5">
                <a href="${url}" target="_blank"
                    class="flex items-center gap-2 bg-gradient-to-r from-[#8B0000] to-[#E62727] text-white px-6 py-3 rounded-xl text-sm font-bold shadow-lg hover:scale-105 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                    Buka Link
                </a>
            </div>`;
        }

        function openPreviewModal(type, url, title) {
            document.getElementById('previewTitle').textContent = title;
            document.getElementById('previewType').textContent = type.toUpperCase();
            document.getElementById('previewIcon').textContent = typeIconsMap[type] || '📎';
            document.getElementById('previewOpenLink').href = url;
            document.getElementById('previewContent').innerHTML = buildPreviewContent(type, url, title);

            const modal = document.getElementById('previewModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closePreviewModal() {
            const modal = document.getElementById('previewModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.getElementById('previewContent').innerHTML = '';
        }

        // ── Event Listeners ────────────────────────────────────────────

        ['addModal', 'editModal', 'previewModal'].forEach(id => {
            const el = document.getElementById(id);
            const closeFn = {
                addModal: closeAddModal,
                editModal: closeEditModal,
                previewModal: closePreviewModal
            };
            el.addEventListener('click', e => {
                if (e.target === el) closeFn[id]();
            });
        });
    </script>
</body>

</html>
