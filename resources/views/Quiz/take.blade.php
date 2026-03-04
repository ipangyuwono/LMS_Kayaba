@extends('layouts.app')
@section('title', 'Quiz — ' . $quiz->title)

@section('content')

    @if ($alreadySubmitted)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 max-w-2xl mx-auto text-center">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none" stroke="#16a34a"
                    stroke-width="2.5" viewBox="0 0 24 24">
                    <polyline points="20 6 9 17 4 12" />
                </svg>
            </div>
            <h2 class="text-xl font-black text-slate-800 mb-2">Quiz Sudah Dikerjakan!</h2>
            <p class="text-sm text-slate-500 mb-6">Kamu sudah mengumpulkan jawaban. Tunggu penilaian dari admin.</p>
            <a href="{{ route('quiz.result', [$quiz, $customer]) }}"
                class="inline-flex items-center gap-2 bg-gradient-to-r from-[#8B0000] to-[#E62727] text-white font-bold text-sm px-6 py-3 rounded-xl shadow hover:opacity-90 transition-all">
                Lihat Hasil
            </a>
        </div>
    @else
        {{-- Timer --}}
        <div class="max-w-2xl mx-auto mb-4">
            <div class="bg-white rounded-xl border border-slate-200 px-5 py-3 flex items-center justify-between shadow-sm">
                <div>
                    <p class="text-xs font-black text-slate-400 uppercase tracking-wider">{{ $quiz->title }}</p>
                    <p class="text-xs text-slate-400 mt-0.5">{{ $quiz->questions->count() }} soal · Nilai lulus
                        {{ $quiz->passing_score }}%</p>
                </div>
                <div class="flex items-center gap-2 bg-red-50 border border-red-100 px-4 py-2 rounded-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="#E62727"
                        stroke-width="2.5" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10" />
                        <polyline points="12 6 12 12 16 14" />
                    </svg>
                    <span id="timer"
                        class="font-mono font-black text-[#E62727] text-sm tabular-nums">{{ sprintf('%02d:%02d', $quiz->duration_minutes, 0) }}</span>
                </div>
            </div>
        </div>

        <form action="{{ route('quiz.submit', [$quiz, $customer]) }}" method="POST" id="quizForm">
            @csrf

            <div class="max-w-2xl mx-auto flex flex-col gap-4">
                @foreach ($quiz->questions as $i => $question)
                    <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
                        <div class="flex items-start gap-3 mb-4">
                            <span
                                class="w-7 h-7 rounded-lg bg-gradient-to-br from-[#8B0000] to-[#E62727] text-white text-xs font-black flex items-center justify-center shrink-0 mt-0.5">{{ $i + 1 }}</span>
                            <p class="text-sm font-semibold text-slate-800 leading-relaxed">{{ $question->question }}</p>
                        </div>
                        <textarea name="answers[{{ $question->id }}]" rows="4" required placeholder="Tulis jawaban kamu di sini..."
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 focus:bg-white focus:border-[#E62727] focus:ring-4 focus:ring-[#E62727]/10 outline-none resize-none transition-all"></textarea>
                        <p class="text-xs text-slate-400 mt-1.5 text-right">Poin: {{ $question->score }}</p>
                    </div>
                @endforeach

                <button type="submit"
                    class="w-full h-12 rounded-xl bg-gradient-to-r from-[#8B0000] to-[#E62727] font-bold text-white text-sm shadow-lg shadow-red-200 hover:opacity-90 hover:scale-[1.01] active:scale-95 transition-all">
                    Kumpulkan Jawaban
                </button>
            </div>
        </form>

        <script>
            // Timer countdown
            let totalSeconds = {{ $quiz->duration_minutes * 60 }};
            const timerEl = document.getElementById('timer');

            const interval = setInterval(function() {
                totalSeconds--;
                if (totalSeconds <= 0) {
                    clearInterval(interval);
                    alert('Waktu habis! Jawaban otomatis dikumpulkan.');
                    document.getElementById('quizForm').submit();
                    return;
                }
                const m = Math.floor(totalSeconds / 60);
                const s = totalSeconds % 60;
                timerEl.textContent = String(m).padStart(2, '0') + ':' + String(s).padStart(2, '0');

                // Warna merah menyala kalau kurang 1 menit
                if (totalSeconds <= 60) {
                    timerEl.classList.add('animate-pulse');
                }
            }, 1000);

            // Konfirmasi sebelum submit
            document.getElementById('quizForm').addEventListener('submit', function(e) {
                if (!confirm('Yakin ingin mengumpulkan jawaban? Jawaban tidak bisa diubah setelah dikumpulkan.')) {
                    e.preventDefault();
                } else {
                    clearInterval(interval);
                }
            });
        </script>
    @endif

@endsection
