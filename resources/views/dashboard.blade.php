<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMS Dashboard</title>
    <link rel="icon" href="{{ asset('images/kyb-remove.png') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/profile.js', 'resources/js/dashboard.js', 'resources/js/sidebar.js'])
    <script>
        window.chartLabels = {!! json_encode($chartLabels->values()) !!};
        window.chartValues = {!! json_encode($chartValues->values()) !!};
    </script>
</head>

<style>
    body {
        font-family: 'Inter', sans-serif;
        background: linear-gradient(135deg, #f3f2ec 0%, #e5e4db 100%);
        color: var(--text);
        min-height: 100vh;
    }
</style>

<div class="flex min-h-screen relative overflow-visible">
    @include('components.sidebar')
    <main
        class="main-content flex-1 p-4 md:p-8 md:ml-[230px] transition-all duration-300 ease-[cubic-bezier(0.4,0,0.2,1)] w-full"
        id="mainContent">

        @include('components.header')
        <section class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div
                class="bg-white p-6 rounded-2xl border-l-4 border-l-[#E62727]/60 relative shadow-sm transition-all duration-250 group overflow-hidden hover:shadow-lg hover:-translate-y-1 hover:border-l-[#E62727]">
                <div
                    class="absolute inset-0 bg-gradient-to-br from-[#E62727]/0 to-[#E62727]/0 group-hover:from-[#E62727]/8 group-hover:to-transparent transition-opacity duration-300 ease-out">
                </div>
                <div
                    class="relative z-10 flex flex-col gap-1 transition-colors duration-250 group-hover:text-[#c62828]">
                    <h3
                        class="text-xs font-bold text-slate-500 uppercase tracking-wider group-hover:text-[#E62727] transition-colors">
                        Total Customer</h3>
                    <p class="text-2xl font-semibold text-slate-800 group-hover:text-[#c62828] transition-colors">
                        {{ number_format($totalCustomers) }}
                    </p>
                </div>
            </div>
            <div
                class="bg-white p-6 rounded-2xl border-l-4 border-l-[#E62727]/60 relative shadow-sm transition-all duration-250 group overflow-hidden hover:shadow-lg hover:-translate-y-1 hover:border-l-[#E62727]">
                <div
                    class="absolute inset-0 bg-gradient-to-br from-[#E62727]/0 to-[#E62727]/0 group-hover:from-[#E62727]/8 group-hover:to-transparent transition-opacity duration-300 ease-out">
                </div>
                <div
                    class="relative z-10 flex flex-col gap-1 transition-colors duration-250 group-hover:text-[#c62828]">
                    <h3
                        class="text-xs font-bold text-slate-500 uppercase tracking-wider group-hover:text-[#E62727] transition-colors">
                        Penjualan</h3>
                    <p class="text-2xl font-semibold text-slate-800 group-hover:text-[#c62828] transition-colors">Rp
                        {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                </div>
            </div>
            <div
                class="bg-white p-6 rounded-2xl border-l-4 border-l-[#E62727]/60 relative shadow-sm transition-all duration-250 group overflow-hidden hover:shadow-lg hover:-translate-y-1 hover:border-l-[#E62727]">
                <div
                    class="absolute inset-0 bg-gradient-to-br from-[#E62727]/0 to-[#E62727]/0 group-hover:from-[#E62727]/8 group-hover:to-transparent transition-opacity duration-300 ease-out">
                </div>
                <div
                    class="relative z-10 flex flex-col gap-1 transition-colors duration-250 group-hover:text-[#c62828]">
                    <h3
                        class="text-xs font-bold text-slate-500 uppercase tracking-wider group-hover:text-[#E62727] transition-colors">
                        Pesan Baru</h3>
                    <p class="text-2xl font-semibold text-slate-800 group-hover:text-[#c62828] transition-colors">
                        {{ $totalOrders }}
                    </p>
                </div>
            </div>
        </section>

        <section class="mb-10 lg:grid lg:grid-cols-1 gap-6">
            <div
                class="bg-white p-6 rounded-2xl shadow-sm border border-[#E62727]/10 h-[400px] transition-all duration-300 group hover:shadow-red-200/30">
                <h3
                    class="text-lg font-semibold text-slate-800 flex items-center gap-2 mb-6 before:content-[''] before:w-1 before:h-5 before:bg-[#E62727] before:rounded-full group-hover:text-[#E62727] transition-colors">
                    Grafik Aktivitas Penjualan
                </h3>
                <div class="h-[280px] w-full mt-4 transition-all duration-300 group-hover:scale-[1.015] origin-center">
                    <canvas id="activityChart"></canvas>
                </div>
            </div>
        </section>

        <section
            class="bg-white rounded-2xl shadow-xl overflow-hidden border border-[#E62727]/10 transition-all hover:shadow-2xl group relative after:absolute after:top-0 after:left-0 after:right-0 after:h-1 after:bg-gradient-to-r after:from-[#E62727] after:via-[#ff4444] after:to-[#E62727]">
            <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h3
                    class="text-lg font-bold text-slate-800 flex items-center gap-2 before:content-[''] before:w-1 before:h-5 before:bg-[#E62727] before:rounded-full">
                    Aktivitas Terbaru
                </h3>
                <a href="{{ route('orders.index') }}"
                    class="text-xs font-bold text-[#E62727] tracking-wider hover:underline">
                    Lihat Semua
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr>
                            <th class="p-4 pl-6 text-xs font-bold text-red-700 uppercase tracking-widest">Waktu</th>
                            <th class="p-4 text-xs font-bold text-red-700 uppercase tracking-widest">Dilakukan Oleh</th>
                            <th class="p-4 text-xs font-bold text-red-700 uppercase tracking-widest">Aktivitas</th>
                            <th class="p-4 pr-6 text-xs font-bold text-red-700 uppercase tracking-widest">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($recentActivities as $activity)
                            @php
                                $causer = $activity->causer->nama ?? ($activity->causer->name ?? 'Admin');
                            @endphp
                            <tr class="hover:bg-[#E62727]/5 transition-all {{ $loop->even ? 'bg-slate-50/30' : '' }}">
                                <td class="p-4 pl-6 text-xs text-slate-400 whitespace-nowrap">
                                    {{ $activity->created_at->diffForHumans() }}
                                </td>
                                <td class="p-4 text-sm text-slate-400">{{ $causer }}</td>
                                <td class="p-4 text-sm text-slate-400">{{ $activity->description }}</td>
                                <td class="p-4 pr-6 whitespace-nowrap">
                                    <p class="text-xs font-semibold text-slate-600">
                                        {{ $activity->created_at->format('d M Y') }}</p>
                                    <p class="text-xs text-slate-400">{{ $activity->created_at->format('H:i:s') }}</p>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-8 text-center text-slate-400 text-sm">Belum ada aktivitas.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
        </section>
    </main>
</div>
@include('components.footer')
@include('components.profile-modal')
</body>

</html>
