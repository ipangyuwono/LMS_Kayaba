<div id="profileModal"
    class="fixed inset-0 z-[1100] hidden items-center justify-center bg-black/80 backdrop-blur-md transition-opacity duration-300">
    <div
        class="relative w-[90%] max-w-[480px] overflow-hidden rounded-[2.5rem] bg-white shadow-[0_30px_100px_rgba(0,0,0,0.4)] transition-all duration-300 border border-white/20">

        <div id="profileViewSection" class="hidden">

            <div class="p-6 flex flex-col gap-6">

                {{-- Avatar + Nama --}}
                <div class="flex flex-col items-center gap-3 pt-2">
                    <div class="relative">
                        <div
                            class="w-20 h-20 rounded-2xl bg-black flex items-center justify-center shadow-[0_8px_24px_rgba(230,39,39,0.35)]">
                            <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24"
                                fill="currentColor" class="text-white">
                                <path
                                    d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z" />
                            </svg>
                        </div>
                        <div
                            class="absolute -bottom-1 -right-1 w-5 h-5 bg-green-400 rounded-full border-2 border-white">
                        </div>
                    </div>
                    <div class="text-center">
                        <h4 class="text-xl font-black text-slate-800">Admin User</h4>
                        <span
                            class="inline-block mt-1 px-3 py-0.5 rounded-full bg-[#E62727]/10 text-[#E62727] text-[10px] font-black uppercase tracking-widest">
                            System Administrator
                        </span>
                    </div>
                </div>

                {{-- Divider --}}
                <div class="h-px bg-gradient-to-r from-transparent via-slate-200 to-transparent"></div>

                {{-- Info --}}
                <div class="space-y-3">
                    <div
                        class="flex items-center gap-3 p-3.5 bg-slate-50 hover:bg-[#E62727]/5 rounded-xl border border-slate-100 hover:border-[#E62727]/20 transition-all group">
                        <div
                            class="w-9 h-9 rounded-lg bg-white border border-slate-200 flex items-center justify-center flex-shrink-0 shadow-sm group-hover:border-[#E62727]/30 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"
                                fill="none" stroke="#E62727" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                                <polyline points="22,6 12,13 2,6" />
                            </svg>
                        </div>
                        <div class="flex flex-col min-w-0">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Alamat
                                Email</span>
                            <span class="text-sm font-bold text-slate-700 truncate">admin@kayaba.com</span>
                        </div>
                    </div>

                    <div
                        class="flex items-center gap-3 p-3.5 bg-slate-50 hover:bg-[#E62727]/5 rounded-xl border border-slate-100 hover:border-[#E62727]/20 transition-all group">
                        <div
                            class="w-9 h-9 rounded-lg bg-white border border-slate-200 flex items-center justify-center flex-shrink-0 shadow-sm group-hover:border-[#E62727]/30 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"
                                fill="none" stroke="#E62727" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <rect x="2" y="7" width="20" height="14" rx="2" ry="2" />
                                <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16" />
                            </svg>
                        </div>
                        <div class="flex flex-col min-w-0">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Unit
                                Kerja</span>
                            <span class="text-sm font-bold text-slate-700 truncate">IT Support Center</span>
                        </div>
                    </div>
                </div>

                {{-- Button --}}
                <button type="button" id="switchToEditProfile"
                    class="w-full h-12 cursor-pointer rounded-xl bg-gradient-to-r from-[#8B0000] to-[#E62727] font-bold text-sm text-white transition-all duration-300 hover:scale-[1.02] shadow-[0_4px_15px_rgba(230,39,39,0.3)] hover:shadow-[0_8px_25px_rgba(230,39,39,0.4)] flex items-center justify-center gap-2 group active:scale-95">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                        stroke-linejoin="round" class="opacity-80">
                        <path
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    <span>Perbarui Data Profil</span>
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
                    <div class="relative mx-auto w-[120px] mb-8 group">
                        <div
                            class="h-[120px] w-[120px] rounded-[2.5rem] bg-[#E62727]/5 p-1 border-2 border-dashed border-[#E62727]/20 group-hover:border-[#E62727] transition-all">
                            <img id="modalAvatarPreview"
                                src="https://ui-avatars.com/api/?name=Admin+User&background=random&color=fff"
                                alt="Preview"
                                class="h-full w-full rounded-[2.2rem] object-cover shadow-xl group-hover:scale-95 transition-transform">
                        </div>
                        <label for="modalAvatarInput"
                            class="absolute -bottom-2 -right-2 flex h-10 w-10 cursor-pointer items-center justify-center rounded-2xl border-4 border-white bg-[#E62727] shadow-xl transition-all hover:scale-110 active:scale-90 z-20">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path
                                    d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z">
                                </path>
                                <circle cx="12" cy="13" r="4"></circle>
                            </svg>
                        </label>
                        <input type="file" id="modalAvatarInput" name="avatar" class="hidden" accept="image/*">
                    </div>

                    <div class="grid grid-cols-1 gap-5">
                        <div class="flex flex-col gap-2 group">
                            <label
                                class="text-[10px] font-black text-slate-400 uppercase tracking-[2px] ml-1 group-focus-within:text-[#E62727] transition-colors">Nama
                                Lengkap</label>
                            <input type="text"
                                class="w-full h-14 rounded-2xl border border-slate-200 bg-slate-50 px-5 font-bold text-slate-700 transition-all focus:bg-white focus:border-[#E62727] focus:ring-4 focus:ring-[#E62727]/10 outline-none"
                                id="modalName" name="name" value="Admin User" required>
                        </div>

                        <div class="flex flex-col gap-2 group">
                            <label
                                class="text-[10px] font-black text-slate-400 uppercase tracking-[2px] ml-1 group-focus-within:text-[#E62727] transition-colors">Alamat
                                Email</label>
                            <input type="email"
                                class="w-full h-14 rounded-2xl border border-slate-200 bg-slate-50 px-5 font-bold text-slate-700 transition-all focus:bg-white focus:border-[#E62727] focus:ring-4 focus:ring-[#E62727]/10 outline-none"
                                id="modalEmail" name="email" value="admin@kayaba.com" required>
                        </div>

                        <div class="flex flex-col gap-2 group">
                            <label
                                class="text-[10px] font-black text-slate-400 uppercase tracking-[2px] ml-1 group-focus-within:text-[#E62727] transition-colors">Departemen</label>
                            <select
                                class="w-full h-14 rounded-2xl border border-slate-200 bg-slate-50 px-5 font-bold text-slate-700 transition-all appearance-none cursor-pointer focus:bg-white focus:border-[#E62727] focus:ring-4 focus:ring-[#E62727]/10 outline-none"
                                id="modalDepartment" name="department">
                                <option value="IT Support" selected>IT Support Center</option>
                                <option value="HRD">Human Resources</option>
                                <option value="Marketing">Marketing & Communication</option>
                                <option value="Production">Production Engineering</option>
                            </select>
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
