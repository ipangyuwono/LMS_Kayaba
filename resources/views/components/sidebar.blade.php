@vite(['resources/js/sidebar.js'])
<div class="relative z-[900]">
    <nav class="fixed left-0 top-0 h-screen w-[230px] bg-pink-800 pt-4 pl-4 pr-4 text-white
            transition-transform duration-300 ease-[cubic-bezier(0.4,0,0.2,1)]
            shadow-[4px_0_30px_rgba(139,0,0,0.3)] z-[950] -translate-x-full"
        id="sidebar">

        <div class="mb-10 text-center relative z-10">
            <img src="{{ asset('images/logo-polos.webp') }}" alt="Kayaba Logo"
                class="w-full h-auto max-w-[120px] block mx-auto rounded-lg shadow-lg">
        </div>

        <ul class="list-none p-0">
            <li class="mb-4">
                <a href="{{ route('dashboard') }}"
                    class="flex items-center gap-3 p-3 rounded-xl text-stone-50 no-underline transition-all duration-300 hover:bg-pink-600 hover:pl-6 group {{ active_menu('dashboard') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round"
                        class="flex-shrink-0 transition-transform duration-300 group-hover:scale-110 group-hover:rotate-6 drop-shadow-[0_2px_4px_rgba(0,0,0,0.2)]">
                        <rect x="3" y="3" width="7" height="7"></rect>
                        <rect x="14" y="3" width="7" height="7"></rect>
                        <rect x="14" y="14" width="7" height="7"></rect>
                        <rect x="3" y="14" width="7" height="7"></rect>
                    </svg>
                    <span class="font-semibold relative z-10 text-sm">Dashboard</span>
                </a>
            </li>

            <li class="mt-6 mb-2">
                <div class="text-xs uppercase font-bold text-white/70 tracking-wider px-4 mb-2">Pengguna</div>
            </li>

            <li class="mb-4">
                <a href="{{ route('customers') }}"
                    class="flex items-center gap-3 p-3 rounded-xl text-stone-50 no-underline transition-all duration-300 hover:bg-pink-600 hover:pl-6 group {{ active_menu('customers.*') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round"
                        class="flex-shrink-0 transition-transform duration-300 group-hover:scale-110 group-hover:rotate-6">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                        <circle cx="9" cy="7" r="4" />
                        <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                    </svg>
                    <span class="font-semibold relative z-10 text-sm">Customers</span>
                </a>
            </li>

            <li class="mt-6 mb-2">
                <div class="text-xs uppercase font-bold text-white/70 tracking-wider px-4 mb-2">Aktivitas</div>
            </li>

            <li class="mb-4">
                <a href="{{ route('services.index') }}"
                    class="flex items-center gap-3 p-3 rounded-xl text-stone-50 no-underline transition-all duration-300 hover:bg-pink-600 hover:pl-6 group {{ active_menu('services.*') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round"
                        class="flex-shrink-0 transition-transform duration-300 group-hover:scale-110 group-hover:rotate-6">
                        <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z" />
                        <line x1="3" y1="6" x2="21" y2="6" />
                        <path d="M16 10a4 4 0 0 1-8 0" />
                    </svg>
                    <span class="font-semibold relative z-10 text-sm">Layanan</span>
                </a>
            </li>

            <li class="mb-4">
                <a href="{{ route('orders.index') }}"
                    class="flex items-center gap-3 p-3 rounded-xl text-stone-50 no-underline transition-all duration-300 hover:bg-pink-600 hover:pl-6 group {{ active_menu('orders.*') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round"
                        class="flex-shrink-0 transition-transform duration-300 group-hover:scale-110 group-hover:rotate-6">
                        <circle cx="8" cy="21" r="1" />
                        <circle cx="19" cy="21" r="1" />
                        <path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.56-7.43H5.12" />
                    </svg>
                    <span class="font-semibold relative z-10 text-sm">Orders</span>
                </a>
            </li>

            <li class="mt-6 mb-2">
                <div class="text-xs uppercase font-bold text-white/70 tracking-wider px-4 mb-2">Pembelajaran</div>
            </li>

            <li class="mb-4">
                <a href="{{ route('materials.index') }}"
                    class="flex items-center gap-3 p-3 rounded-xl text-stone-50 no-underline transition-all duration-300 hover:bg-pink-600 hover:pl-6 group {{ active_menu('materials.*') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round"
                        class="flex-shrink-0 transition-transform duration-300 group-hover:scale-110 group-hover:rotate-6">
                        <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20" />
                        <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z" />
                    </svg>
                    <span class="font-semibold relative z-10 text-sm">Materi</span>
                </a>
            </li>

            <li class="mb-4">
                <a href="{{ route('quiz.index') }}"
                    class="flex items-center gap-3 p-3 rounded-xl text-stone-50 no-underline transition-all duration-300 hover:bg-pink-600 hover:pl-6 group {{ active_menu('quiz.*') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round"
                        class="flex-shrink-0 transition-transform duration-300 group-hover:scale-110 group-hover:rotate-6">
                        <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
                        <rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect>
                        <line x1="8" y1="10" x2="16" y2="10"></line>
                        <line x1="8" y1="14" x2="12" y2="14"></line>
                    </svg>
                    <span class="font-semibold relative z-10 text-sm">Quiz</span>
                </a>
            </li>

            <li class="mb-4">
                <a href="{{ route('progress.index') }}"
                    class="flex items-center gap-3 p-3 rounded-xl text-stone-50 no-underline transition-all duration-300 hover:bg-pink-600 hover:pl-6 group {{ active_menu('progress.*') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round"
                        class="flex-shrink-0 transition-transform duration-300 group-hover:scale-110 group-hover:rotate-6">
                        <line x1="18" y1="20" x2="18" y2="10" />
                        <line x1="12" y1="20" x2="12" y2="4" />
                        <line x1="6" y1="20" x2="6" y2="14" />
                    </svg>
                    <span class="font-semibold relative z-10 text-sm">Progress</span>
                </a>
            </li>
        </ul>
    </nav>

    {{-- Overlay --}}
    <div id="sidebarOverlay" class="hidden fixed inset-0 bg-black/50 z-[940]"></div>
</div>
