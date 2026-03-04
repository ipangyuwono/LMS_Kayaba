@extends('layouts.app')
@section('title', 'Detail Quiz')

@section('content')

    @if (session('success'))
        <div
            class="flex items-center gap-3 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-5 text-sm">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
                <path
                    d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 14l-4-4 1.41-1.41L10 13.17l6.59-6.59L18 8l-8 8z" />
            </svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route('quiz.index') }}"
                class="w-9 h-9 flex items-center justify-center rounded-xl hover:bg-slate-100 text-slate-400 hover:text-[#E62727] transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                    viewBox="0 0 24 24">
                    <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z" />
                </svg>
            </a>
            <div>
                <h2 class="text-xl font-black text-slate-800">{{ $quiz->title }}</h2>
                <p class="text-xs text-slate-400">{{ $quiz->service->name }} · {{ $quiz->duration_minutes }} menit · Lulus
                    {{ $quiz->passing_score }}%</p>
            </div>
        </div>
    </div>

    {{-- Soal --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
        <h3 class="text-sm font-black text-slate-700 uppercase tracking-wider mb-4">Daftar Soal
            ({{ $quiz->questions->count() }})</h3>
        <div class="flex flex-col gap-3">
            @foreach ($quiz->questions as $i => $q)
                <div class="flex items-start gap-3 bg-slate-50 rounded-xl px-4 py-3">
                    <span
                        class="w-6 h-6 rounded-lg bg-[#E62727] text-white text-xs font-black flex items-center justify-center shrink-0">{{ $i + 1 }}</span>
                    <div class="flex-1">
                        <p class="text-sm text-slate-700">{{ $q->question }}</p>
                        <p class="text-xs text-slate-400 mt-1">Poin: {{ $q->score }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Jawaban Customer --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-sm font-black text-slate-700 uppercase tracking-wider mb-4">Jawaban Customer
            ({{ $answers->count() }})</h3>

        @forelse($answers as $customerId => $customerAnswers)
            @php $customer = $customerAnswers->first()->customer; @endphp
            <div class="border border-slate-100 rounded-xl overflow-hidden mb-5">
                <div class="bg-slate-50 px-5 py-3 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-black text-slate-800">{{ $customer->nama }}</p>
                        <p class="text-xs text-slate-400">{{ $customer->kelas }} · {{ $customer->departemen }}</p>
                    </div>
                    <span
                        class="text-xs font-bold {{ $customerAnswers->whereNull('score')->count() > 0 ? 'text-amber-500' : 'text-green-600' }}">
                        {{ $customerAnswers->whereNull('score')->count() > 0 ? '⏳ Belum dinilai semua' : '✓ Sudah dinilai' }}
                    </span>
                </div>

                <div class="divide-y divide-slate-50">
                    @foreach ($customerAnswers as $answer)
                        <div class="px-5 py-4">
                            <p class="text-xs font-black text-slate-400 uppercase tracking-wider mb-1">
                                {{ $answer->question->question }}</p>
                            <p class="text-sm text-slate-700 bg-slate-50 rounded-lg px-3 py-2 mb-3">{{ $answer->answer }}
                            </p>

                            <form action="{{ route('quiz.grade', $answer) }}" method="POST" class="flex items-end gap-3">
                                @csrf
                                <div class="flex flex-col gap-1">
                                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-wider">Nilai (max
                                        {{ $answer->question->score }})</label>
                                    <input type="number" name="score" value="{{ $answer->score }}" min="0"
                                        max="{{ $answer->question->score }}" required
                                        class="w-24 h-9 rounded-lg border border-slate-200 bg-white px-3 text-sm font-bold text-slate-700 focus:border-[#E62727] outline-none">
                                </div>
                                <div class="flex-1 flex flex-col gap-1">
                                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-wider">Feedback
                                        (opsional)</label>
                                    <input type="text" name="feedback" value="{{ $answer->feedback }}"
                                        placeholder="Komentar untuk jawaban ini..."
                                        class="w-full h-9 rounded-lg border border-slate-200 bg-white px-3 text-sm text-slate-700 focus:border-[#E62727] outline-none">
                                </div>
                                <button type="submit"
                                    class="h-9 px-4 rounded-lg bg-gradient-to-r from-[#8B0000] to-[#E62727] text-white text-xs font-bold hover:opacity-90 transition-all shrink-0">
                                    Simpan
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
            <p class="text-sm text-slate-400 text-center py-8">Belum ada customer yang mengerjakan quiz ini.</p>
        @endforelse
    </div>

@endsection
