<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Progress Belajar</title>
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
        <main class="main-content flex-1 p-4 md:p-8 md:ml-[230px] transition-all duration-300 ease-[cubic-bezier(0.4,0,0.2,1)] w-full" id="mainContent">
            @include('components.header')

            {{-- Alert --}}
            @if(session('success'))
            <div class="flex items-center gap-3 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-5 text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 14l-4-4 1.41-1.41L10 13.17l6.59-6.59L18 8l-8 8z"/></svg>
                {{ session('success') }}
            </div>
            @endif

            <section class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200/60 transition-all duration-300 hover:shadow-xl group">
                <div class="p-6 md:p-8 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-gradient-to-r from-gray-50 to-white">
                    <div class="flex items-center gap-4">
                        <div class="w-1 h-8 bg-[#E62727] rounded-full"></div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-800">Progress Belajar</h3>
                            <p class="text-xs text-gray-400 mt-0.5">Total materi aktif: <span class="font-bold text-gray-600">{{ $totalMaterials }}</span></p>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse min-w-[700px]">
                        <thead>
                            <tr class="text-black">
                                <th class="p-5 pl-8 text-left text-xs font-semibold uppercase tracking-wide w-10">No</th>
                                <th class="p-5 text-left text-xs font-semibold uppercase tracking-wide">Customer</th>
                                <th class="p-5 text-left text-xs font-semibold uppercase tracking-wide">Kelas</th>
                                <th class="p-5 text-left text-xs font-semibold uppercase tracking-wide">Departemen</th>
                                <th class="p-5 text-left text-xs font-semibold uppercase tracking-wide">Progress</th>
                                <th class="p-5 pr-8 text-left text-xs font-semibold uppercase tracking-wide">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($customers as $cust)
                            @php
                                $pct = $totalMaterials > 0 ? round(($cust->completed_count / $totalMaterials) * 100) : 0;
                                $barColor = $pct >= 100 ? 'bg-green-500' : ($pct > 0 ? 'bg-[#E62727]' : 'bg-gray-300');
                            @endphp
                            <tr class="hover:bg-red-50/50 transition-colors duration-150 {{ $loop->even ? 'bg-gray-50/40' : '' }}">
                                <td class="p-5 pl-8 text-sm text-gray-500">{{ $loop->iteration + ($customers->currentPage() - 1) * $customers->perPage() }}</td>
                                <td class="p-5 text-sm font-semibold text-gray-900">{{ $cust->nama }}</td>
                                <td class="p-5 text-sm text-gray-700">{{ $cust->kelas }}</td>
                                <td class="p-5 text-sm text-gray-500">{{ $cust->departemen }}</td>
                                <td class="p-5">
                                    <div class="flex items-center gap-3">
                                        <div class="flex-1 h-2.5 bg-gray-100 rounded-full overflow-hidden">
                                            <div class="{{ $barColor }} h-full rounded-full transition-all duration-500" style="width: {{ $pct }}%"></div>
                                        </div>
                                        <span class="text-xs font-bold text-gray-600 min-w-[3rem] text-right">{{ $cust->completed_count }}/{{ $totalMaterials }}</span>
                                    </div>
                                    <div class="flex items-center gap-2 mt-1.5">
                                        @if($cust->in_progress_count > 0)
                                        <span class="text-[10px] bg-yellow-100 text-yellow-700 font-semibold px-1.5 py-0.5 rounded">{{ $cust->in_progress_count }} sedang dipelajari</span>
                                        @endif
                                        @if($pct >= 100)
                                        <span class="text-[10px] bg-green-100 text-green-700 font-semibold px-1.5 py-0.5 rounded">✓ Selesai</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="p-5 pr-8">
                                    <a href="{{ route('progress.show', $cust) }}"
                                        class="w-9 h-9 flex items-center justify-center text-[#E62727] hover:bg-[#E62727]/10 rounded-lg transition-all hover:scale-110 border border-transparent hover:border-[#E62727]/30" title="Detail">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6">
                                    <div class="p-12 text-center text-gray-500">
                                        <p class="text-lg">Belum ada data customer.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($customers->hasPages())
                <div class="px-8 py-4 border-t border-gray-100">{{ $customers->links() }}</div>
                @endif
            </section>
        </main>
    </div>
    @include('components.footer')
    @include('components.profile-modal')
</body>
</html>
