<div id="profileModal"
    class="fixed inset-0 z-[1100] hidden items-center justify-center bg-black/80 backdrop-blur-md transition-opacity duration-300">
    <div
        class="relative w-[90%] max-w-[480px] overflow-hidden rounded-[2.5rem] bg-white shadow-[0_30px_100px_rgba(0,0,0,0.4)] transition-all duration-300 border border-white/20">

        <div id="profileViewSection" class="hidden">
            <div class="p-6 flex flex-col gap-5">

                {{-- Avatar + Nama --}}
                <div
                    class="flex items-center gap-4 bg-gradient-to-r from-slate-50 to-white border border-slate-100 rounded-2xl p-4">
                    <div class="relative flex-shrink-0">
                        <div
                            class="w-14 h-14 rounded-2xl bg-gradient-to-br from-[#8B0000] to-[#E62727] flex items-center justify-center shadow-lg shadow-red-200">
                            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24"
                                fill="white">
                                <path
                                    d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z" />
                            </svg>
                        </div>
                        <div
                            class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-green-400 rounded-full border-2 border-white">
                        </div>
                    </div>
                    <div class="min-w-0">
                        <h4 class="text-base font-black text-slate-800 truncate">{{ auth('lembur')->user()->full_name }}
                        </h4>
                    </div>
                </div>

                {{-- Info Cards --}}
                <div class="flex flex-col gap-2.5">

                    {{-- NPK --}}
                    <div
                        class="flex items-center gap-3 p-3.5 bg-slate-50 hover:bg-red-50 border border-slate-100 hover:border-red-100 rounded-xl transition-all duration-200 group cursor-default">
                        <div
                            class="w-9 h-9 rounded-xl bg-white border border-slate-200 group-hover:border-red-200 flex items-center justify-center flex-shrink-0 shadow-sm transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                fill="none" stroke="#E62727" stroke-width="2.5" stroke-linecap="round"
                                stroke-linejoin="round">
                                <rect x="2" y="3" width="20" height="14" rx="2" />
                                <line x1="8" y1="21" x2="16" y2="21" />
                                <line x1="12" y1="17" x2="12" y2="21" />
                            </svg>
                        </div>
                        <div class="flex flex-col min-w-0 flex-1">
                            <span class="text-[9px] font-black text-slate-400 uppercase tracking-[2px]">Nomer NPK</span>
                            <span
                                class="text-sm font-bold text-slate-700 truncate disabled:">{{ auth('lembur')->user()->npk }}</span>
                        </div>
                        <div
                            class="w-1 h-7 rounded-full bg-gradient-to-b from-[#E62727] to-[#8B0000] opacity-20 group-hover:opacity-60 transition-all">
                        </div>
                    </div>

                    {{-- Departemen --}}
                    <div
                        class="flex items-center gap-3 p-3.5 bg-slate-50 hover:bg-red-50 border border-slate-100 hover:border-red-100 rounded-xl transition-all duration-200 group cursor-default">
                        <div
                            class="w-9 h-9 rounded-xl bg-white border border-slate-200 group-hover:border-red-200 flex items-center justify-center flex-shrink-0 shadow-sm transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                fill="none" stroke="#E62727" stroke-width="2.5" stroke-linecap="round"
                                stroke-linejoin="round">
                                <rect x="2" y="7" width="20" height="14" rx="2" ry="2" />
                                <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16" />
                            </svg>
                        </div>
                        <div class="flex flex-col min-w-0 flex-1">
                            <span
                                class="text-[9px] font-black text-slate-400 uppercase tracking-[2px]">Departemen</span>
                            <span
                                class="text-sm font-bold text-slate-700 truncate">{{ auth('lembur')->user()->dept }}</span>
                        </div>
                        <div
                            class="w-1 h-7 rounded-full bg-gradient-to-b from-[#E62727] to-[#8B0000] opacity-20 group-hover:opacity-60 transition-all">
                        </div>
                    </div>

                </div>

                {{-- Divider --}}
                <div class="h-px bg-gradient-to-r from-transparent via-slate-200 to-transparent"></div>

                {{-- Edit Button --}}
                <button type="button" id="switchToEditProfile"
                    class="w-full h-11 cursor-pointer rounded-xl bg-gradient-to-r from-[#8B0000] to-[#E62727] font-bold text-sm text-white flex items-center justify-center gap-2 shadow-lg shadow-red-200 hover:shadow-red-300 hover:scale-[1.02] active:scale-95 transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Perbarui Data Profil
                </button>

            </div>
        </div>

        <!-- Edit Mode (Hidden by default) -->
        <div id="profileEditSection" class="hidden">
            <div class="flex items-center justify-between border-0 p-10 pb-4">
                <div class="flex flex-col gap-1">
                    <h2 class="m-0 text-3xl font-black text-slate-800 tracking-tight">Edit Profil</h2>
                    <p class="text-xs font-bold text-[#E62727] uppercase tracking-widest">Update Informasi Anda</p>
                </div>
                <span class="cursor-pointer text-3xl text-slate-300 hover:text-[#E62727] transition-all"
                    id="closeProfileModalEdit">&times;</span>
            </div>
            <div class="p-10 pt-4">
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Avatar Upload -->
                    <div class="grid grid-cols-1 gap-5">
                        <div class="flex flex-col gap-2 group">
                            <label
                                class="text-[10px] font-black text-slate-400 uppercase tracking-[2px] ml-1 group-focus-within:text-[#E62727] transition-colors">Nama
                                Lengkap</label>
                            <input type="text"
                                class="w-full h-14 rounded-2xl border border-slate-200 bg-slate-50 px-5 font-bold text-slate-700 transition-all focus:bg-white focus:border-[#E62727] focus:ring-4 focus:ring-[#E62727]/10 outline-none"
                                id="modalName" name="name" value={{ auth('lembur')->user()->full_name }} required>
                        </div>

                        <div class="flex flex-col gap-2 group">
                            <label
                                class="text-[10px] font-black text-slate-400 uppercase tracking-[2px] ml-1 group-focus-within:text-[#E62727] transition-colors">Nomer
                                NPK</label>
                            <input type="text"
                                class="w-full h-14 rounded-2xl border border-slate-200 bg-slate-50 px-5 font-bold text-slate-700 transition-all focus:bg-white focus:border-[#E62727] focus:ring-4 focus:ring-[#E62727]/10 outline-none"
                                id="modalNpk" name="npk" value={{ auth('lembur')->user()->npk }} readonly>
                        </div>

                        <div class="flex flex-col gap-2 group">
                            <label
                                class="text-[10px] font-black text-slate-400 uppercase tracking-[2px] ml-1 group-focus-within:text-[#E62727] transition-colors">Departemen</label>
                            <input type="text"
                                class="w-full h-14 rounded-2xl border border-slate-200 bg-slate-50 px-5 font-bold text-slate-700 transition-all focus:bg-white focus:border-[#E62727] focus:ring-4 focus:ring-[#E62727]/10 outline-none"
                                id="modalDepartment" name="department" value={{ auth('lembur')->user()->dept }} required>
                        </div>
                    </div>

                    <div class="mt-10 flex gap-4 pt-6 border-t border-slate-100">
                        <button type="button" id="switchToViewProfile"
                            class="h-14 flex-1 cursor-pointer rounded-2xl border border-slate-200 font-bold text-slate-500 transition-all hover:bg-slate-50 active:scale-95">
                            Batal
                        </button>
                        <button type="submit"
                            class="h-14 flex-[2] cursor-pointer rounded-2xl bg-[#E62727] font-bold text-white transition-all hover:bg-[#c02222] shadow-[0_10px_25px_rgba(230,39,39,0.3)] hover:scale-[1.02] active:scale-95">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
