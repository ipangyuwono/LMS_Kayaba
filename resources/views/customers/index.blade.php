<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMS Customer</title>
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
            <section
                class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200/60 transition-all duration-300 hover:shadow-xl group">
                <!-- Header section -->
                <div
                    class="p-6 md:p-8 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-gradient-to-r from-gray-50 to-white">
                    <div class="flex items-center gap-4">
                        <div class="w-1 h-8 bg-[#E62727] rounded-full"></div>
                        <h3 class="text-xl md:text-xl font-bold text-gray-800">Data Customer</h3>
                    </div>

                    <button onclick="openAddModal()"
                        class="flex items-center gap-2 px-5 py-2.5 bg-slate-800 hover:bg-slate-700 text-white font-medium text- rounded-xl shadow-md transition-all duration-200 hover:shadow-lg hover:scale-[1.02] active:scale-95 whitespace-nowrap">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                            stroke-linejoin="round">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                        Tambah Customer
                    </button>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse min-w-[900px]">
                        <!-- min-w supaya tidak terlalu sempit di mobile -->
                        <thead>
                            <tr class="text-black">
                                <th class="p-5 pl-8 text-left text-xs font-semibold uppercase tracking-wide">ID</th>
                                <th class="p-5 text-left text-xs font-semibold uppercase tracking-wide">Nama</th>
                                <th class="p-5 text-left text-xs font-semibold uppercase tracking-wide">Kelas</th>
                                <th class="p-5 text-left text-xs font-semibold uppercase tracking-wide">Password</th>
                                <th class="p-5 text-left text-xs font-semibold uppercase tracking-wide">Departemen</th>
                                <th class="p-5 pr-8 text-left text-xs font-semibold uppercase tracking-wide">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($Customers as $index => $record)
                                <tr
                                    class="hover:bg-red-50/50 transition-colors duration-150 {{ $loop->even ? 'bg-gray-50/40' : '' }}">
                                    <td class="p-5 pl-8 text-sm font-bold text-[#E62727]">{{ $index + 1 }}</td>
                                    <td class="p-5 text-sm font-semibold text-gray-900">{{ $record->nama }}</td>
                                    <td class="p-5 text-sm text-gray-700">{{ $record->kelas }}</td>
                                    <td class="p-5 text-sm text-gray-500 font-mono tracking-wide">
                                        {{ $record->password }}</td>
                                    <td class="p-5 text-sm">
                                        <span
                                            class="inline-block px-3 py-1 bg-gray-100 text-gray-700 rounded-md text-xs font-medium">
                                            {{ $record->departemen }}
                                        </span>
                                    </td>
                                    <td class="p-5 pr-8">
                                        <div class="flex items-center gap-3">
                                            <!-- Edit -->
                                            <button
                                                onclick="openEditModal({{ $record->id }}, '{{ addslashes($record->nama) }}', '{{ addslashes($record->kelas) }}', '{{ addslashes($record->departemen) }}')"
                                                class="w-9 h-9 flex items-center justify-center text-[#E62727] hover:bg-[#E62727]/10 rounded-lg transition-all hover:scale-110 border border-transparent hover:border-[#E62727]/30"
                                                title="Edit">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path
                                                        d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7">
                                                    </path>
                                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z">
                                                    </path>
                                                </svg>
                                            </button>

                                            <!-- Delete -->
                                            <form action="{{ route('customers.delete', $record->id) }}" method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus {{ addslashes($record->nama) }}?')"
                                                class="m-0">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="w-9 h-9 flex items-center justify-center text-white bg-red-600 hover:bg-red-700 rounded-lg transition-all hover:scale-110 shadow-sm"
                                                    title="Hapus">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="18"
                                                        height="18" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <polyline points="3 6 5 6 21 6"></polyline>
                                                        <path
                                                            d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                        </path>
                                                        <line x1="10" y1="11" x2="10"
                                                            y2="17"></line>
                                                        <line x1="14" y1="11" x2="14"
                                                            y2="17"></line>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Optional: jika kosong -->
                @if ($Customers->isEmpty())
                    <div class="p-12 text-center text-gray-500">
                        <p class="text-lg">Belum ada data customer.</p>
                        <button onclick="openAddModal()" class="mt-4 text-[#E62727] hover:underline">Tambah data
                            pertama sekarang →</button>
                    </div>
                @endif
            </section>
        </main>
    </div>

    {{-- Modal Edit Customer --}}
    <div id="editModal" class="fixed inset-0 z-[1000] hidden items-center justify-center bg-black/60 backdrop-blur-sm">
        <div
            class="relative w-[90%] max-w-[480px] overflow-hidden rounded-2xl bg-white shadow-[0_32px_64px_rgba(0,0,0,0.2)]">

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
                        <h2 class="text-lg font-bold text-white">Edit Customer</h2>
                        <p class="text-white/60 text-xs mt-0.5">Perbarui data customer</p>
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

                    {{-- Nama --}}
                    <div class="group">
                        <label for="edit_nama"
                            class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1.5 group-focus-within:text-[#E62727] transition-colors">
                            Nama
                        </label>
                        <input type="text" id="edit_nama" name="nama" required placeholder="Masukkan nama"
                            class="w-full h-11 bg-slate-50 border border-slate-200 rounded-xl px-4 text-sm text-slate-700 font-medium transition-all focus:bg-white focus:border-[#E62727] focus:ring-4 focus:ring-[#E62727]/10 outline-none placeholder:text-slate-300">
                    </div>

                    {{-- Kelas --}}
                    <div class="group">
                        <label for="edit_kelas"
                            class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1.5 group-focus-within:text-[#E62727] transition-colors">
                            Kelas
                        </label>
                        <input type="text" id="edit_kelas" name="kelas" required placeholder="Masukkan kelas"
                            class="w-full h-11 bg-slate-50 border border-slate-200 rounded-xl px-4 text-sm text-slate-700 font-medium transition-all focus:bg-white focus:border-[#E62727] focus:ring-4 focus:ring-[#E62727]/10 outline-none placeholder:text-slate-300">
                    </div>

                    {{-- Password --}}
                    <div class="group">
                        <label for="edit_password"
                            class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1.5 group-focus-within:text-[#E62727] transition-colors">
                            Password
                            <span class="normal-case font-normal text-slate-300 ml-1"></span>
                        </label>
                        <div class="relative">
                            <input type="password" id="edit_password" name="password"
                                placeholder="Masukkan password baru"
                                class="w-full h-11 bg-slate-50 border border-slate-200 rounded-xl px-4 pr-11 text-sm text-slate-700 font-medium transition-all focus:bg-white focus:border-[#E62727] focus:ring-4 focus:ring-[#E62727]/10 outline-none placeholder:text-slate-300">
                            <button type="button" onclick="toggleEditPassword()"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-300 hover:text-[#E62727] transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Departemen --}}
                    <div class="group">
                        <label for="edit_departemen"
                            class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1.5 group-focus-within:text-[#E62727] transition-colors">
                            Departemen
                        </label>
                        <input type="text" id="edit_departemen" name="departemen" required
                            placeholder="Masukkan departemen"
                            class="w-full h-11 bg-slate-50 border border-slate-200 rounded-xl px-4 text-sm text-slate-700 font-medium transition-all focus:bg-white focus:border-[#E62727] focus:ring-4 focus:ring-[#E62727]/10 outline-none placeholder:text-slate-300">
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
    </div>

    {{-- Modal Tambah Customer --}}
    <div id="addModal"
        class="fixed inset-0 z-[1000] hidden items-center justify-center bg-black/60 backdrop-blur-sm">
        <div
            class="relative w-[90%] max-w-[480px] overflow-hidden rounded-2xl bg-white shadow-[0_32px_64px_rgba(0,0,0,0.2)] animate-fade-in">

            {{-- Header --}}
            <div class="relative bg-black px-8 py-6">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                            fill="currentColor" class="text-white">
                            <path
                                d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-white">Tambah Customer</h2>
                        <p class="text-white/60 text-xs mt-0.5">Isi data customer baru</p>
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
            <form action="{{ route('customers.store') }}" method="POST" class="px-8 py-6">
                @csrf
                <div class="space-y-4">

                    {{-- Nama --}}
                    <div class="group">
                        <label
                            class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1.5 group-focus-within:text-[#E62727] transition-colors">
                            Nama
                        </label>
                        <input type="text" name="nama" required placeholder="Masukkan nama"
                            class="w-full h-11 bg-slate-50 border border-slate-200 rounded-xl px-4 text-sm text-slate-700 font-medium transition-all focus:bg-white focus:border-[#E62727] focus:ring-4 focus:ring-[#E62727]/10 outline-none placeholder:text-slate-300">
                    </div>

                    {{-- Kelas --}}
                    <div class="group">
                        <label
                            class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1.5 group-focus-within:text-[#E62727] transition-colors">
                            Kelas
                        </label>
                        <input type="text" name="kelas" required placeholder="Masukkan kelas"
                            class="w-full h-11 bg-slate-50 border border-slate-200 rounded-xl px-4 text-sm text-slate-700 font-medium transition-all focus:bg-white focus:border-[#E62727] focus:ring-4 focus:ring-[#E62727]/10 outline-none placeholder:text-slate-300">
                    </div>

                    {{-- Password --}}
                    <div class="group">
                        <label
                            class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1.5 group-focus-within:text-[#E62727] transition-colors">
                            Password
                        </label>
                        <div class="relative">
                            <input type="password" name="password" id="modalPassword" required
                                placeholder="Masukkan password"
                                class="w-full h-11 bg-slate-50 border border-slate-200 rounded-xl px-4 pr-11 text-sm text-slate-700 font-medium transition-all focus:bg-white focus:border-[#E62727] focus:ring-4 focus:ring-[#E62727]/10 outline-none placeholder:text-slate-300">
                            <button type="button" onclick="toggleModalPassword()"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-300 hover:text-[#E62727] transition-colors">
                                <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Departemen --}}
                    <div class="group">
                        <label
                            class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1.5 group-focus-within:text-[#E62727] transition-colors">
                            Departemen
                        </label>
                        <input type="text" name="departemen" required placeholder="Masukkan departemen"
                            class="w-full h-11 bg-slate-50 border border-slate-200 rounded-xl px-4 text-sm text-slate-700 font-medium transition-all focus:bg-white focus:border-[#E62727] focus:ring-4 focus:ring-[#E62727]/10 outline-none placeholder:text-slate-300">
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
                        Simpan Customer
                    </button>
                </div>
            </form>
        </div>
    </div>
    @include('components.footer')
    @include('components.profile-modal')
    <script>
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

        function openEditModal(id, nama, kelas, departemen) {
            const modal = document.getElementById('editModal');
            const form = document.getElementById('editForm');
            form.action = `/customers/${id}`;
            document.getElementById('edit_nama').value = nama;
            document.getElementById('edit_kelas').value = kelas;
            document.getElementById('edit_departemen').value = departemen;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeEditModal() {
            const modal = document.getElementById('editModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function toggleModalPassword() {
            const input = document.getElementById('modalPassword');
            input.type = input.type === 'password' ? 'text' : 'password';
        }
    </script>
</body>

</html>
