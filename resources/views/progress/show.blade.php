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

        <main
            class="main-content flex-1 pl-8 md:px-8 md:ml-[230px] transition-all duration-300 ease-[cubic-bezier(0.4,0,0.2,1)] w-full overflow-x-auto "
            id="mainContent">
            @include('components.header')

            {{-- Alert --}}
            @if (session('success'))
                <div
                    class="mt-16 flex items-center gap-3 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-5 text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                        viewBox="0 0 24 24">
                        <path
                            d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 14l-4-4 1.41-1.41L10 13.17l6.59-6.59L18 8l-8 8z" />
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            @php
                $totalPoints = 0;
                foreach ($materials as $mat) {
                    $status = $progressMap[$mat->id] ?? 'not_started';
                    if ($status === 'completed') {
                        $totalPoints += 100;
                    } elseif ($status === 'in_progress') {
                        $totalPoints += 50;
                    }
                }
                $maxPoints = $materials->count() * 100;
                $pct = $maxPoints > 0 ? round(($totalPoints / $maxPoints) * 100) : 0;

                // Optional: hitung juga completed & in_progress count kalau mau ditampilkan
                $completed = $materials
                    ->filter(fn($m) => ($progressMap[$m->id] ?? 'not_started') === 'completed')
                    ->count();
                $inProgress = $materials
                    ->filter(fn($m) => ($progressMap[$m->id] ?? 'not_started') === 'in_progress')
                    ->count();
                $total = $materials->count();
            @endphp

            <div class="bg-white rounded-xl shadow-lg border border-gray-200/60 p-6 mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mt-14">
                <div class="flex items-center gap-4">
                    <a href="{{ route('progress.index') }}"
                        class="w-10 h-10 flex items-center justify-center rounded-xl hover:bg-gray-100 text-gray-400 hover:text-[#E62727] transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z" />
                        </svg>
                    </a>
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">{{ $customer->nama }}</h2>
                        <p class="text-xs text-gray-400 mt-0.5">{{ $customer->kelas }} · {{ $customer->departemen }}
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <div class="text-right">
                        <p class="text-2xl font-bold text-[#219559]">{{ $pct }}%</p>
                        <p class="text-xs text-gray-400">{{ $completed }}/{{ $total }} selesai</p>
                    </div>
                    <div class="w-16 h-16 relative">
                        <svg class="w-16 h-16 transform -rotate-90" viewBox="0 0 36 36">
                            <circle cx="18" cy="18" r="14" fill="none" stroke="#f1f1f1"
                                stroke-width="3" />
                            <circle cx="18" cy="18" r="14" fill="none"
                                stroke="{{ $pct >= 100 ? '#16a34a' : '#E62727' }}" stroke-width="3"
                                stroke-dasharray="{{ $pct * 0.88 }} 88" stroke-linecap="round"
                                class="transition-all duration-700" />
                        </svg>
                    </div>
                </div>
            </div>


            {{-- Grouped by Service --}}
            @php $grouped = $materials->groupBy('service_id'); @endphp
            @forelse ($grouped as $serviceId => $mats)
                @php $service = $mats->first()->service; @endphp
                <section
                    class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200/60 mb-5 transition-all duration-300 hover:shadow-xl">
                    <div
                        class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white flex items-center gap-3">
                        <div class="w-1 h-6 bg-[#E62727] rounded-full"></div>
                        <h4 class="text-sm font-bold text-gray-800 uppercase tracking-wide">{{ $service->name }}
                        </h4>

                        <div class="ml-auto flex items-center gap-2">
                            @if ($pct >= 100)
                                <a href="{{ route('progress.certificate', $customer) }}"
                                    class="inline-flex items-center gap-1.5 bg-gradient-to-r from-[#8B0000] to-[#E62727] text-white font-bold text-xs px-3 py-1.5 rounded-lg shadow hover:scale-[1.02] active:scale-95 transition-all">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13"
                                        fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6zm-1 1.5L18.5 9H13V3.5zM12 17l-4-4h2.5v-3h3v3H16l-4 4z" />
                                    </svg>
                                    Cetak Sertifikat
                                </a>

                                @php $quiz = \App\Models\Quiz::where('service_id', $serviceId)->where('is_active', true)->first(); @endphp
                                @if ($quiz)
                                    <a href="{{ route('quiz.take', [$quiz, $customer]) }}"
                                        class="inline-flex items-center gap-1.5 bg-gradient-to-r from-[#212529] to-[#219559] text-white font-bold text-xs px-3 py-1.5 rounded-lg shadow hover:scale-[1.02] active:scale-95 transition-all">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13"
                                            fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                            <path
                                                d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2" />
                                            <rect x="8" y="2" width="8" height="4" rx="1" />
                                            <line x1="8" y1="10" x2="16" y2="10" />
                                            <line x1="8" y1="14" x2="12" y2="14" />
                                        </svg>
                                        Kerjakan Quiz
                                    </a>
                                @endif
                            @endif
                        </div>
                    </div>

                    <div class="divide-y divide-gray-50">
                        @foreach ($mats as $mat)
                            @php
                                $status = $progressMap[$mat->id] ?? 'not_started';
                                $statusColors = [
                                    'not_started' => 'bg-gray-100 text-gray-500',
                                    'in_progress' => 'bg-yellow-100 text-yellow-700',
                                    'completed' => 'bg-green-100 text-green-700',
                                ];
                                $statusLabels = [
                                    'not_started' => 'Belum Mulai',
                                    'in_progress' => 'Sedang Dipelajari',
                                    'completed' => 'Selesai',
                                ];
                                $typeIcons = [
                                    'video' => '🎬',
                                    'pdf' => '📄',
                                    'document' => '📝',
                                    'link' => '🔗',
                                ];
                            @endphp
                            <div
                                class="flex items-center px-6 py-4 gap-4 hover:bg-red-50/30 transition-colors {{ $status === 'completed' ? 'opacity-70' : '' }}">
                                <div
                                    class="w-8 h-8 rounded-lg flex items-center justify-center text-sm
                                    {{ $status === 'completed' ? 'bg-green-100 text-green-600' : ($status === 'in_progress' ? 'bg-yellow-100 text-yellow-600' : 'bg-gray-100 text-gray-400') }}">
                                    @if ($status === 'completed')
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z" />
                                        </svg>
                                    @else
                                        {{ $mat->position }}
                                    @endif
                                </div>

                                <div class="flex-1 min-w-0">
                                    <p
                                        class="text-sm font-semibold text-gray-800 {{ $status === 'completed' ? 'line-through' : '' }}">
                                        {{ $typeIcons[$mat->type] ?? '' }} {{ $mat->title }}
                                    </p>
                                    @if ($mat->description)
                                        <p class="text-xs text-gray-400 mt-0.5 truncate">{{ $mat->description }}
                                        </p>
                                    @endif
                                </div>

                                <span
                                    class="inline-flex items-center {{ $statusColors[$status] }} text-xs font-semibold px-2.5 py-1 rounded-full whitespace-nowrap">
                                    {{ $statusLabels[$status] }}
                                </span>

                                <form action="{{ route('progress.toggle', $customer) }}" method="POST"
                                    class="flex-shrink-0">
                                    @csrf
                                    <input type="hidden" name="material_id" value="{{ $mat->id }}">
                                    <select name="status" onchange="this.form.submit()"
                                        class="h-9 bg-slate-50 border border-slate-200 rounded-lg px-2 text-xs text-slate-600 font-medium transition-all focus:border-[#E62727] focus:ring-2 focus:ring-[#E62727]/10 outline-none cursor-pointer">
                                        <option value="not_started" {{ $status === 'not_started' ? 'selected' : '' }}>
                                            Belum Mulai</option>
                                        <option value="in_progress" {{ $status === 'in_progress' ? 'selected' : '' }}>
                                            Sedang Dipelajari</option>
                                        <option value="completed" {{ $status === 'completed' ? 'selected' : '' }}>
                                            Selesai</option>
                                    </select>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </section>
            @empty
                <div class="bg-white rounded-xl shadow-lg p-12 text-center border border-gray-200/60">
                    <p class="text-lg text-gray-500">Belum ada materi aktif untuk customer ini.</p>
                    <a href="{{ route('materials.index') }}"
                        class="inline-block mt-3 text-sm font-bold text-[#E62727] hover:underline">Kelola Materi
                        →</a>
                </div>
            @endforelse
        </main>
    </div>

    @include('components.footer')
    @include('components.profile-modal')
</body>

</html>
