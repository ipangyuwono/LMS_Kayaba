<header
    class="flex items-center justify-between gap-4 sticky top-0 left-0 right-0 z-[1000] bg-white/80 backdrop-blur-md px-6 py-5 -mx-8 -mt-8 mb-6 shadow-sm transition-all duration-300">
    <div class="flex items-center gap-4">
        <button
            class="flex flex-col items-center justify-center gap-[5px] w-11 h-11 bg-black border-none rounded-xl cursor-pointer shadow-[0_4px_15px_rgba(139,0,0,0.4)] transition-all duration-300 hover:scale-105 group"
            id="sidebarToggle">
            <span
                class="w-[25px] h-[3px] bg-white rounded-sm transition-all duration-300 group-[.active]:rotate-45 group-[.active]:translate-y-[8px]"></span>
            <span
                class="w-[25px] h-[3px] bg-white rounded-sm transition-all duration-300 group-[.active]:opacity-0"></span>
            <span
                class="w-[25px] h-[3px] bg-white rounded-sm transition-all duration-300 group-[.active]:-rotate-45 group-[.active]:-translate-y-[8px]"></span>
        </button>
        <h1
            class="text-xl font-bold text-slate-800 relative pl-4 after:content-[''] after:absolute after:left-0 after:top-1/2 after:-translate-y-1/2 after:w-1 after:h-8 after:bg-[#E62727] after:rounded-full">
            LMS Training
        </h1>
        <div class="ml-0.5 pl-2 border-l border-slate-200 h-6 flex items-center">
            <nav class="flex items-center gap-2 text-sm text-slate-400">
                {{ Breadcrumbs::render() }}
            </nav>
        </div>
    </div>

    {{-- Live Clock --}}
    <div class="flex items-center gap-7">
        <div class="flex items-center gap-2 bg-slate-50 border border-slate-200 px-2 py-1.5 rounded-xl">
            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none"
                stroke="#E62727" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10" />
                <polyline points="12 6 12 12 16 14" />
            </svg>
            <span id="liveClock" class="text-xs font-bold text-slate-700 tabular-nums tracking-wide"></span>
        </div>

        <div class="user-profile group relative cursor-pointer">
            <div
                class="profile-trigger flex items-center gap-1 bg-black px-2 py-1 rounded-xl shadow-[0_4px_15px_rgba(139,0,0,0.3)] border transition-all hover:scale-105 hover:shadow-[0_8px_25px_rgba(139,0,0,0.4)] active:scale-95">
                <div class="p-2 bg-white/20 text-white rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                        stroke-linejoin="round" class="transition-transform group-hover:rotate-12">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                </div>
                <span class="font-semibold text-sm text-white tracking-wide">Profil</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                    class="text-white/70 group-hover:translate-y-0.5 transition-transform">
                    <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
            </div>

            <div
                class="profile-dropdown absolute top-[calc(100%+8px)] right-0 min-w-[200px] bg-white rounded-xl shadow-[0_10px_30px_rgba(0,0,0,0.15)] opacity-0 invisible translate-y-2 transition-all group-[.active]:opacity-100 group-[.active]:visible group-[.active]:translate-y-0 z-[1100] border border-slate-50 overflow-hidden">
                <button type="button"
                    class="open-profile-modal flex items-center gap-3 w-full p-4 text-sm font-semibold text-slate-700 hover:bg-[#E62727]/5 hover:text-[#E62727] transition-all text-left">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                    <span>Lihat Profil</span>
                </button>
                <div class="h-px bg-slate-100 my-0 mx-4"></div>
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit"
                        class="flex items-center gap-3 w-full p-4 text-sm font-semibold text-slate-700 hover:bg-red-50 hover:text-red-600 transition-all text-left">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                            <polyline points="16 17 21 12 16 7"></polyline>
                            <line x1="21" y1="12" x2="9" y2="12"></line>
                        </svg>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>
