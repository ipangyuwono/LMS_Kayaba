@extends('layouts.app')
@section('title', 'Hasil Quiz')

@section('content')

    <div class="max-w-2xl mx-auto">

        {{-- Score Card --}}
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 mb-5 text-center">
            <p class="text-xs font-black text-slate-400 uppercase tracking-wider mb-1">{{ $quiz->title }}</p>
            <p class="text-xs text-slate-400 mb-5">{{ $customer->nama }} · {{ $customer->kelas }}</p>

            @if ($answers->whereNull('score')->count() > 0)
                <div
                    class="w-20 h-20 rounded-full bg-amber-50 border-4 border-amber-200 flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="none" stroke="#d97706"
                        stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10" />
                        <polyline points="12 6 12 12 16 14" />
                    </svg>
                </div>
                <p class="text-xl font-black text-amber-600 mb-1">Menunggu Penilaian</p>
                <p class="text-sm text-slate-400">Jawaban kamu sudah dikumpulkan. Tunggu admin menilai.</p>
            @else
                <div
                    class="w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-4 border-4 {{ $passed ? 'bg-green-50 border-green-200' : 'bg-red-50 border-red-200' }}">
                    <span
                        class="text-2xl font-black {{ $passed ? 'text-green-600' : 'text-red-500' }}">{{ $pct }}%</span>
                </div>
                <p class="text-xl font-black {{ $passed ? 'text-green-600' : 'text-red-500' }} mb-1">
                    {{ $passed ? '🎉 Lulus!' : '😔 Belum Lulus' }}
                </p>
                <p class="text-sm text-slate-400">Skor: {{ $totalScore }}/{{ $maxScore }} · Nilai minimum lulus:
                    {{ $quiz->passing_score }}%</p>
            @endif
        </div>

        {{-- Detail Jawaban --}}
        <div class="flex flex-col gap-4">
            @foreach ($answers as $i => $answer)
                <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-5">
                    <div class="flex items-start gap-3 mb-3">
                        <span
                            class="w-6 h-6 rounded-lg bg-slate-100 text-slate-500 text-xs font-black flex items-center justify-center shrink-0">{{ $i + 1 }}</span>
                        <p class="text-sm font-semibold text-slate-800">{{ $answer->question->question }}</p>
                    </div>

                    <div class="bg-slate-50 rounded-lg px-4 py-3 mb-3">
                        <p class="text-xs font-black text-slate-400 uppercase tracking-wider mb-1">Jawaban Kamu</p>
                        <p class="text-sm text-slate-700">{{ $answer->answer }}</p>
                    </div>

                    @if ($answer->score !== null)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                @if ($answer->feedback)
                                    <div class="bg-blue-50 rounded-lg px-3 py-2">
                                        <p class="text-xs font-black text-blue-400 uppercase tracking-wider mb-0.5">Feedback
                                        </p>
                                        <p class="text-xs text-blue-700">{{ $answer->feedback }}</p>
                                    </div>
                                @endif
                            </div>
                            <span
                                class="text-sm font-black text-[#E62727]">{{ $answer->score }}/{{ $answer->question->score }}
                                poin</span>
                        </div>
                    @else
                        <p class="text-xs text-amber-500 font-semibold">⏳ Belum dinilai</p>
                    @endif
                </div>
            @endforeach
        </div>

        <div class="mt-5">
            <a href="{{ route('progress.show', $customer) }}"
                class="w-full h-11 flex items-center justify-center rounded-xl bg-slate-100 hover:bg-slate-200 font-bold text-sm text-slate-600 transition-all">
                ← Kembali ke Progress
            </a>
        </div>
    </div>

@endsection
