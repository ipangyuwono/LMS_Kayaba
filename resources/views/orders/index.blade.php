<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Order</title>
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

            {{-- Stats Cards --}}
            @php
                $total   = $orders->total();
                $paid    = \App\Models\Orders::where('status', 'paid')->count();
                $pending = \App\Models\Orders::where('status', 'pending')->count();
                $failed  = \App\Models\Orders::where('status', 'failed')->count();
            @endphp
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white rounded-xl border border-gray-200/60 shadow-lg px-5 py-4 hover:shadow-xl transition-all duration-300">
                    <p class="text-xs text-gray-500 font-semibold uppercase tracking-wide">Total Order</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">{{ $total }}</p>
                </div>
                <div class="bg-white rounded-xl border border-gray-200/60 shadow-lg px-5 py-4 hover:shadow-xl transition-all duration-300">
                    <p class="text-xs text-green-600 font-semibold uppercase tracking-wide">Lunas</p>
                    <p class="text-2xl font-bold text-green-600 mt-1">{{ $paid }}</p>
                </div>
                <div class="bg-white rounded-xl border border-gray-200/60 shadow-lg px-5 py-4 hover:shadow-xl transition-all duration-300">
                    <p class="text-xs text-yellow-600 font-semibold uppercase tracking-wide">Pending</p>
                    <p class="text-2xl font-bold text-yellow-600 mt-1">{{ $pending }}</p>
                </div>
                <div class="bg-white rounded-xl border border-gray-200/60 shadow-lg px-5 py-4 hover:shadow-xl transition-all duration-300">
                    <p class="text-xs text-red-500 font-semibold uppercase tracking-wide">Gagal</p>
                    <p class="text-2xl font-bold text-red-500 mt-1">{{ $failed }}</p>
                </div>
            </div>

            <section
                class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200/60 transition-all duration-300 hover:shadow-xl group">
                {{-- Header section --}}
                <div
                    class="p-6 md:p-8 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-gradient-to-r from-gray-50 to-white">
                    <div class="flex items-center gap-4">
                        <div class="w-1 h-8 bg-[#E62727] rounded-full"></div>
                        <h3 class="text-xl md:text-xl font-bold text-gray-800">Data Order</h3>
                    </div>
                </div>

                {{-- Table --}}
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse min-w-[800px]">
                        <thead>
                            <tr class="text-black">
                                <th class="p-5 pl-8 text-left text-xs font-semibold uppercase tracking-wide">ID Order</th>
                                <th class="p-5 text-left text-xs font-semibold uppercase tracking-wide">Service</th>
                                <th class="p-5 text-left text-xs font-semibold uppercase tracking-wide">Customer</th>
                                <th class="p-5 text-left text-xs font-semibold uppercase tracking-wide">Email</th>
                                <th class="p-5 text-left text-xs font-semibold uppercase tracking-wide">Total</th>
                                <th class="p-5 text-left text-xs font-semibold uppercase tracking-wide">Status</th>
                                <th class="p-5 pr-8 text-left text-xs font-semibold uppercase tracking-wide">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($orders as $order)
                            <tr
                                class="hover:bg-red-50/50 transition-colors duration-150 {{ $loop->even ? 'bg-gray-50/40' : '' }}">
                                <td class="p-5 pl-8">
                                    <span class="font-mono text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded-lg">
                                        {{ $order->order_id }}
                                    </span>
                                </td>
                                <td class="p-5 text-sm font-semibold text-gray-900">{{ $order->service->name }}</td>
                                <td class="p-5 text-sm text-gray-700">{{ $order->customer_name }}</td>
                                <td class="p-5 text-sm text-gray-500">{{ $order->customer_email }}</td>
                                <td class="p-5 text-sm font-bold text-[#E62727]">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                <td class="p-5 text-sm">
                                    @php
                                        $badge = match($order->status) {
                                            'paid'    => 'bg-green-100 text-green-700',
                                            'pending' => 'bg-yellow-100 text-yellow-700',
                                            'failed'  => 'bg-red-100 text-red-600',
                                            'expired' => 'bg-gray-100 text-gray-500',
                                            default   => 'bg-gray-100 text-gray-500',
                                        };
                                        $dot = match($order->status) {
                                            'paid'    => 'bg-green-500',
                                            'pending' => 'bg-yellow-500 animate-pulse',
                                            'failed'  => 'bg-red-500',
                                            default   => 'bg-gray-400',
                                        };
                                    @endphp
                                    <span class="inline-flex items-center gap-1 {{ $badge }} text-xs font-semibold px-2.5 py-1 rounded-full">
                                        <span class="w-1.5 h-1.5 {{ $dot }} rounded-full"></span>
                                        {{ strtoupper($order->status) }}
                                    </span>
                                </td>
                                <td class="p-5 pr-8 text-xs text-gray-400">{{ $order->created_at->format('d M Y, H:i') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7">
                                    <div class="p-12 text-center text-slate-400">
                                        <p class="text-lg">Belum ada data order.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($orders->hasPages())
                <div class="px-8 py-4 border-t border-gray-100">
                    {{ $orders->links() }}
                </div>
                @endif
            </section>
        </main>
    </div>
    @include('components.footer')
    @include('components.profile-modal')
</body>

</html>
