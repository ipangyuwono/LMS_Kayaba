<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Progress — {{ $customer->nama }}</title>
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

            {{-- Header Bar --}}
            <div class="bg-white rounded-xl shadow-lg border border-gray-200/60 p-6 mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div class="flex items-center gap-4">
                    <a href="{{ route('progress.index') }}" class="w-10 h-10 flex items-center justify-center rounded-xl hover:bg-gray-100 text-gray-400 hover:text-[#E62727] transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/></svg>
                    </a>
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">{{ $customer->nama }}</h2>
                        <p class="text-xs text-gray-400 mt-0.5">{{ $customer->kelas }} · {{ $customer->departemen }}</p>
                    </div>
                </div>
                @php
                    $completed = collect($progressMap)->where(fn($s) => $s === 'completed')->count();
                    $total     = $materials->count();
                    $pct       = $total > 0 ? round(($completed / $total) * 100) : 0;
                @endphp
                <div class="flex items-center gap-4">
                    <div class="text-right">
                        <p class="text-2xl font-bold text-[#E62727]">{{ $pct }}%</p>
                        <p class="text-xs text-gray-400">{{ $completed }}/{{ $total }} selesai</p>
                    </div>
                    <div class="w-16 h-16 relative">
                        <svg class="w-16 h-16 transform -rotate-90" viewBox="0 0 36 36">
                            <circle cx="18" cy="18" r="14" fill="none" stroke="#f1f1f1" stroke-width="3"/>
                            <circle cx="18" cy="18" r="14" fill="none" stroke="#E62727" stroke-width="3"
                                stroke-dasharray="{{ $pct * 0.88 }} 88"
                                stroke-linecap="round" class="transition-all duration-700"/>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Grouped by Service --}}
            @php $grouped = $materials->groupBy('service_id'); @endphp
            @foreach($grouped as $serviceId => $mats)
            @php $service = $mats->first()->service; @endphp
            <section class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200/60 mb-5 transition-all duration-300 hover:shadow-xl">
                <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white flex items-center gap-3">
                    <div class="w-1 h-6 bg-[#E62727] rounded-full"></div>
                    <h4 class="text-sm font-bold text-gray-800 uppercase tracking-wide">{{ $service->name }}</h4>
                    @php
                        $svcCompleted = $mats->filter(fn($m) => ($progressMap[$m->id] ?? 'not_started') === 'completed')->count();
                    @endphp
                    <span class="ml-auto text-xs font-semibold text-gray-400">{{ $svcCompleted }}/{{ $mats->count() }}</span>
                </div>

                <div class="divide-y divide-gray-50">
                    @foreach($mats as $mat)
                    @php
                        $status = $progressMap[$mat->id] ?? 'not_started';
                        $statusColors = [
                            'not_started' => 'bg-gray-100 text-gray-500',
                            'in_progress' => 'bg-yellow-100 text-yellow-700',
                            'completed'   => 'bg-green-100 text-green-700',
                        ];
                        $statusLabels = [
                            'not_started' => 'Belum Mulai',
                            'in_progress' => 'Sedang Dipelajari',
                            'completed'   => 'Selesai',
                        ];
                        $typeIcons = [
                            'video'    => '🎬',
                            'pdf'      => '📄',
                            'document' => '📝',
                            'link'     => '🔗',
                        ];
                    @endphp
                    <div class="flex items-center px-6 py-4 gap-4 hover:bg-red-50/30 transition-colors {{ $status === 'completed' ? 'opacity-70' : '' }}">
                        {{-- Icon + number --}}
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center text-sm
                            {{ $status === 'completed' ? 'bg-green-100 text-green-600' : ($status === 'in_progress' ? 'bg-yellow-100 text-yellow-600' : 'bg-gray-100 text-gray-400') }}">
                            @if($status === 'completed')
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                            @else
                                {{ $mat->position }}
                            @endif
                        </div>

                        {{-- Title --}}
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-800 {{ $status === 'completed' ? 'line-through' : '' }}">
                                {{ $typeIcons[$mat->type] ?? '' }} {{ $mat->title }}
                            </p>
                            @if($mat->description)
                            <p class="text-xs text-gray-400 mt-0.5 truncate">{{ $mat->description }}</p>
                            @endif
                        </div>

                        {{-- Status badge --}}
                        <span class="inline-flex items-center {{ $statusColors[$status] }} text-xs font-semibold px-2.5 py-1 rounded-full whitespace-nowrap">
                            {{ $statusLabels[$status] }}
                        </span>

                        {{-- Dropdown update status --}}
                        <form action="{{ route('progress.toggle', $customer) }}" method="POST" class="flex-shrink-0">
                            @csrf
                            <input type="hidden" name="material_id" value="{{ $mat->id }}">
                            <select name="status" onchange="this.form.submit()"
                                class="h-9 bg-slate-50 border border-slate-200 rounded-lg px-2 text-xs text-slate-600 font-medium transition-all focus:border-[#E62727] focus:ring-2 focus:ring-[#E62727]/10 outline-none cursor-pointer">
                                <option value="not_started" {{ $status === 'not_started' ? 'selected' : '' }}>Belum Mulai</option>
                                <option value="in_progress" {{ $status === 'in_progress' ? 'selected' : '' }}>Sedang Dipelajari</option>
                                <option value="completed" {{ $status === 'completed' ? 'selected' : '' }}>Selesai</option>
                            </select>
                        </form>
                    </div>
                    @endforeach
                </div>
            </section>
            @endforeach

            @if($materials->isEmpty())
            <div class="bg-white rounded-xl shadow-lg p-12 text-center border border-gray-200/60">
                <p class="text-lg text-gray-500">Belum ada materi aktif.</p>
                <a href="{{ route('materials.index') }}" class="inline-block mt-3 text-sm font-bold text-[#E62727] hover:underline">Tambah materi →</a>
            </div>
            @endif
        </main>
    </div>
    @include('components.footer')
    @include('components.profile-modal')
</body>
</html>
