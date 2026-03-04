<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Quiz</title>
    <link rel="icon" href="{{ asset('images/kyb-remove.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/profile.js', 'resources/js/sidebar.js'])
</head>

<style>
    body {
        font-family: 'Inter', sans-serif;
        background: linear-gradient(135deg, #f3f2ec 0%, #e5e4db 100%);
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

        <section class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200/60">
            {{-- Header --}}
            <div class="p-6 md:p-8 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-gradient-to-r from-gray-50 to-white">
                <div class="flex items-center gap-4">
                    <div class="w-1 h-8 bg-[#E62727] rounded-full"></div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">Kelola Quiz</h3>
                        <p class="text-xs text-slate-400 mt-0.5">Total {{ $quizzes->count() }} quiz</p>
                    </div>
                </div>
                <button onclick="openAddModal()"
                    class="flex items-center gap-2 bg-gradient-to-r from-[#8B0000] to-[#E62727] text-white px-5 py-2.5 rounded-xl text-sm font-bold shadow-[0_4px_15px_rgba(230,39,39,0.3)] hover:shadow-[0_6px_20px_rgba(230,39,39,0.4)] hover:scale-[1.02] active:scale-95 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Tambah Quiz
                </button>
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-slate-100">
                            <th class="text-left py-3 px-5 text-xs font-black text-slate-400 uppercase tracking-wider">No</th>
                            <th class="text-left py-3 px-5 text-xs font-black text-slate-400 uppercase tracking-wider">Judul</th>
                            <th class="text-left py-3 px-5 text-xs font-black text-slate-400 uppercase tracking-wider">Layanan</th>
                            <th class="text-left py-3 px-5 text-xs font-black text-slate-400 uppercase tracking-wider">Durasi</th>
                            <th class="text-left py-3 px-5 text-xs font-black text-slate-400 uppercase tracking-wider">Nilai Lulus</th>
                            <th class="text-left py-3 px-5 text-xs font-black text-slate-400 uppercase tracking-wider">Status</th>
                            <th class="text-left py-3 px-5 text-xs font-black text-slate-400 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($quizzes as $i => $quiz)
                        <tr class="hover:bg-red-50/50 transition-colors {{ $loop->even ? 'bg-gray-50/40' : '' }}">
                            <td class="py-3 px-5 text-slate-500">{{ $i + 1 }}</td>
                            <td class="py-3 px-5 font-semibold text-slate-800">{{ $quiz->title }}</td>
                            <td class="py-3 px-5"><span class="bg-gray-100 text-gray-700 text-xs font-semibold px-2.5 py-1 rounded-lg">{{ $quiz->service->name }}</span></td>
                            <td class="py-3 px-5 text-slate-600">{{ $quiz->duration_minutes }} menit</td>
                            <td class="py-3 px-5 text-slate-600">{{ $quiz->passing_score }}%</td>
                            <td class="py-3 px-5">
                                @if($quiz->is_active)
                                    <span class="inline-flex items-center gap-1 bg-green-100 text-green-700 text-xs font-semibold px-2.5 py-1 rounded-full">
                                        <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span> Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 bg-gray-100 text-gray-500 text-xs font-semibold px-2.5 py-1 rounded-full">
                                        <span class="w-1.5 h-1.5 bg-gray-400 rounded-full"></span> Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="py-3 px-5">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('quiz.show', $quiz) }}"
                                        class="w-9 h-9 flex items-center justify-center text-blue-500 hover:bg-blue-50 rounded-lg transition-all hover:scale-110 border border-transparent hover:border-blue-200" title="Detail">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    </a>
                                    <button onclick='openEditModal(@json($quiz))'
                                        class="w-9 h-9 flex items-center justify-center text-[#E62727] hover:bg-[#E62727]/10 rounded-lg transition-all hover:scale-110 border border-transparent hover:border-[#E62727]/30" title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    </button>
                                    <form action="{{ route('quiz.destroy', $quiz) }}" method="POST" onsubmit="return confirm('Hapus quiz ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="w-9 h-9 flex items-center justify-center text-red-400 hover:bg-red-50 rounded-lg transition-all hover:scale-110 border border-transparent hover:border-red-200" title="Hapus">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-400">
                                Belum ada quiz. <button onclick="openAddModal()" class="text-[#E62727] font-bold hover:underline">Tambah sekarang →</button>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</div>

{{-- ===================== MODAL TAMBAH ===================== --}}
<div id="addModal" class="fixed inset-0 z-[1000] hidden items-center justify-center bg-black/60 backdrop-blur-sm">
    <div class="relative w-[90%] max-w-[560px] max-h-[90vh] overflow-y-auto rounded-2xl bg-white shadow-[0_32px_64px_rgba(0,0,0,0.2)]">
        {{-- Header --}}
        <div class="relative bg-black px-8 py-6">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" class="text-white" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-white">Tambah Quiz</h2>
                    <p class="text-white/60 text-xs mt-0.5">Buat quiz baru untuk layanan</p>
                </div>
            </div>
            <button onclick="closeAddModal()" class="absolute top-5 right-5 w-8 h-8 rounded-lg bg-white/10 hover:bg-white/25 transition-all flex items-center justify-center text-white">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>

        {{-- Form --}}
        <form action="{{ route('quiz.store') }}" method="POST" id="addQuizForm" class="px-8 py-6 space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1.5">Layanan</label>
                <select name="service_id" required class="w-full h-11 bg-slate-50 border border-slate-200 rounded-xl px-4 text-sm text-slate-700 font-medium focus:bg-white focus:border-[#E62727] focus:ring-4 focus:ring-[#E62727]/10 outline-none">
                    <option value="">-- Pilih Layanan --</option>
                    @foreach($services as $svc)
                    <option value="{{ $svc->id }}">{{ $svc->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1.5">Judul Quiz</label>
                <input type="text" name="title" required placeholder="contoh: Quiz Akhir Materi"
                    class="w-full h-11 bg-slate-50 border border-slate-200 rounded-xl px-4 text-sm text-slate-700 font-medium focus:bg-white focus:border-[#E62727] focus:ring-4 focus:ring-[#E62727]/10 outline-none placeholder:text-slate-300">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1.5">Deskripsi (opsional)</label>
                <textarea name="description" rows="2" placeholder="Deskripsi singkat quiz..."
                    class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-700 font-medium focus:bg-white focus:border-[#E62727] focus:ring-4 focus:ring-[#E62727]/10 outline-none resize-none placeholder:text-slate-300"></textarea>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1.5">Durasi (menit)</label>
                    <input type="number" name="duration_minutes" value="30" min="1" required
                        class="w-full h-11 bg-slate-50 border border-slate-200 rounded-xl px-4 text-sm text-slate-700 font-medium focus:bg-white focus:border-[#E62727] focus:ring-4 focus:ring-[#E62727]/10 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1.5">Nilai Lulus (%)</label>
                    <input type="number" name="passing_score" value="70" min="0" max="100" required
                        class="w-full h-11 bg-slate-50 border border-slate-200 rounded-xl px-4 text-sm text-slate-700 font-medium focus:bg-white focus:border-[#E62727] focus:ring-4 focus:ring-[#E62727]/10 outline-none">
                </div>
            </div>

            {{-- Soal --}}
            <div class="border-t border-slate-100 pt-4">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-xs font-black text-slate-500 uppercase tracking-widest">Daftar Soal</h3>
                    <button type="button" id="addQuestion"
                        class="inline-flex items-center gap-1.5 bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold text-xs px-3 py-1.5 rounded-lg transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        Tambah Soal
                    </button>
                </div>
                <div id="questionList" class="flex flex-col gap-3">
                    <div class="question-item bg-slate-50 border border-slate-200 rounded-xl p-4">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-black text-slate-500 uppercase tracking-wider">Soal 1</span>
                            <button type="button" class="remove-question text-red-400 hover:text-red-600 transition-colors hidden">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                            </button>
                        </div>
                        <textarea name="questions[0][question]" rows="2" required placeholder="Tulis pertanyaan di sini..."
                            class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 focus:border-[#E62727] outline-none resize-none mb-2"></textarea>
                        <div class="flex items-center gap-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-wider">Poin:</label>
                            <input type="number" name="questions[0][score]" value="10" min="1" required
                                class="w-20 h-8 rounded-lg border border-slate-200 bg-white px-2 text-sm font-bold text-slate-700 focus:border-[#E62727] outline-none">
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex gap-3 pt-4">
                <button type="button" onclick="closeAddModal()" class="flex-1 h-11 bg-slate-100 text-slate-500 rounded-xl text-sm font-bold hover:bg-slate-200 transition-all">Batal</button>
                <button type="submit" class="flex-[2] h-11 bg-gradient-to-r from-[#8B0000] to-[#E62727] text-white rounded-xl text-sm font-bold shadow-[0_4px_15px_rgba(230,39,39,0.3)] hover:scale-[1.02] active:scale-95 transition-all">Simpan Quiz</button>
            </div>
        </form>
    </div>
</div>

{{-- ===================== MODAL EDIT ===================== --}}
<div id="editModal" class="fixed inset-0 z-[1000] hidden items-center justify-center bg-black/60 backdrop-blur-sm">
    <div class="relative w-[90%] max-w-[560px] max-h-[90vh] overflow-y-auto rounded-2xl bg-white shadow-[0_32px_64px_rgba(0,0,0,0.2)]">
        {{-- Header --}}
        <div class="relative bg-black px-8 py-6">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" class="text-white" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-white">Edit Quiz</h2>
                    <p class="text-white/60 text-xs mt-0.5">Perbarui informasi quiz</p>
                </div>
            </div>
            <button onclick="closeEditModal()" class="absolute top-5 right-5 w-8 h-8 rounded-lg bg-white/10 hover:bg-white/25 transition-all flex items-center justify-center text-white">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>

        {{-- Form --}}
        <form id="editForm" method="POST" class="px-8 py-6 space-y-4">
            @csrf @method('PUT')
            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1.5">Layanan</label>
                <select id="edit_service_id" name="service_id" required class="w-full h-11 bg-slate-50 border border-slate-200 rounded-xl px-4 text-sm text-slate-700 font-medium focus:bg-white focus:border-[#E62727] focus:ring-4 focus:ring-[#E62727]/10 outline-none">
                    @foreach($services as $svc)
                    <option value="{{ $svc->id }}">{{ $svc->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1.5">Judul Quiz</label>
                <input type="text" id="edit_title" name="title" required
                    class="w-full h-11 bg-slate-50 border border-slate-200 rounded-xl px-4 text-sm text-slate-700 font-medium focus:bg-white focus:border-[#E62727] focus:ring-4 focus:ring-[#E62727]/10 outline-none">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1.5">Deskripsi (opsional)</label>
                <textarea id="edit_description" name="description" rows="2"
                    class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-700 font-medium focus:bg-white focus:border-[#E62727] focus:ring-4 focus:ring-[#E62727]/10 outline-none resize-none"></textarea>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1.5">Durasi (menit)</label>
                    <input type="number" id="edit_duration" name="duration_minutes" min="1" required
                        class="w-full h-11 bg-slate-50 border border-slate-200 rounded-xl px-4 text-sm text-slate-700 font-medium focus:bg-white focus:border-[#E62727] focus:ring-4 focus:ring-[#E62727]/10 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1.5">Nilai Lulus (%)</label>
                    <input type="number" id="edit_passing" name="passing_score" min="0" max="100" required
                        class="w-full h-11 bg-slate-50 border border-slate-200 rounded-xl px-4 text-sm text-slate-700 font-medium focus:bg-white focus:border-[#E62727] focus:ring-4 focus:ring-[#E62727]/10 outline-none">
                </div>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1.5">Status</label>
                <select id="edit_is_active" name="is_active" class="w-full h-11 bg-slate-50 border border-slate-200 rounded-xl px-4 text-sm text-slate-700 font-medium focus:bg-white focus:border-[#E62727] focus:ring-4 focus:ring-[#E62727]/10 outline-none">
                    <option value="1">Aktif</option>
                    <option value="0">Nonaktif</option>
                </select>
            </div>

            <div class="flex gap-3 pt-4">
                <button type="button" onclick="closeEditModal()" class="flex-1 h-11 bg-slate-100 text-slate-500 rounded-xl text-sm font-bold hover:bg-slate-200 transition-all">Batal</button>
                <button type="submit" class="flex-[2] h-11 bg-gradient-to-r from-[#8B0000] to-[#E62727] text-white rounded-xl text-sm font-bold shadow-[0_4px_15px_rgba(230,39,39,0.3)] hover:scale-[1.02] active:scale-95 transition-all">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

@include('components.footer')
@include('components.profile-modal')

<script>
    // ===== ADD MODAL =====
    function openAddModal() {
        document.getElementById('addModal').classList.remove('hidden');
        document.getElementById('addModal').classList.add('flex');
    }
    function closeAddModal() {
        document.getElementById('addModal').classList.add('hidden');
        document.getElementById('addModal').classList.remove('flex');
    }

    // ===== EDIT MODAL =====
    function openEditModal(quiz) {
        document.getElementById('edit_service_id').value = quiz.service_id;
        document.getElementById('edit_title').value = quiz.title;
        document.getElementById('edit_description').value = quiz.description ?? '';
        document.getElementById('edit_duration').value = quiz.duration_minutes;
        document.getElementById('edit_passing').value = quiz.passing_score;
        document.getElementById('edit_is_active').value = quiz.is_active ? '1' : '0';
        document.getElementById('editForm').action = `/quiz/${quiz.id}`;
        document.getElementById('editModal').classList.remove('hidden');
        document.getElementById('editModal').classList.add('flex');
    }
    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
        document.getElementById('editModal').classList.remove('flex');
    }

    // Close modal on backdrop click
    ['addModal', 'editModal'].forEach(id => {
        document.getElementById(id).addEventListener('click', function(e) {
            if (e.target === this) {
                this.classList.add('hidden');
                this.classList.remove('flex');
            }
        });
    });

    // ===== SOAL DINAMIS =====
    let questionCount = 1;

    document.getElementById('addQuestion').addEventListener('click', function () {
        const list = document.getElementById('questionList');
        const div = document.createElement('div');
        div.className = 'question-item bg-slate-50 border border-slate-200 rounded-xl p-4';
        div.innerHTML = `
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-black text-slate-500 uppercase tracking-wider">Soal ${questionCount + 1}</span>
                <button type="button" class="remove-question text-red-400 hover:text-red-600 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>
            <textarea name="questions[${questionCount}][question]" rows="2" required placeholder="Tulis pertanyaan di sini..."
                class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 focus:border-[#E62727] outline-none resize-none mb-2"></textarea>
            <div class="flex items-center gap-2">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-wider">Poin:</label>
                <input type="number" name="questions[${questionCount}][score]" value="10" min="1" required
                    class="w-20 h-8 rounded-lg border border-slate-200 bg-white px-2 text-sm font-bold text-slate-700 focus:border-[#E62727] outline-none">
            </div>
        `;
        list.appendChild(div);
        questionCount++;
        updateRemoveButtons();
    });

    document.getElementById('questionList').addEventListener('click', function (e) {
        if (e.target.closest('.remove-question')) {
            e.target.closest('.question-item').remove();
            updateNumbers();
            updateRemoveButtons();
        }
    });

    function updateNumbers() {
        document.querySelectorAll('.question-item').forEach((item, i) => {
            item.querySelector('span').textContent = `Soal ${i + 1}`;
            item.querySelector('textarea').name = `questions[${i}][question]`;
            item.querySelector('input[type=number]').name = `questions[${i}][score]`;
        });
        questionCount = document.querySelectorAll('.question-item').length;
    }

    function updateRemoveButtons() {
        const items = document.querySelectorAll('.question-item');
        items.forEach(item => {
            item.querySelector('.remove-question').classList.toggle('hidden', items.length === 1);
        });
    }
</script>

</body>
</html>
