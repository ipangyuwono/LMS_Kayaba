<div id="chatbot-container" class="fixed bottom-6 right-6 z-[2000] flex flex-col items-end gap-3">

    <div id="chat-window"
        class="hidden w-[350px] bg-white rounded-2xl shadow-2xl border border-gray-200 overflow-hidden flex flex-col"
        style="height: 480px;">

        <div class="bg-gradient-to-r from-[#8B0000] to-[#E62727] px-5 py-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none"
                        stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" class="text-white">
                        <path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm0 18a8 8 0 1 1 8-8 8 8 0 0 1-8 8z" />
                        <path d="M12 6v6l4 2" />
                    </svg>
                </div>
                <div>
                    <p class="text-white font-bold text-sm">KYB Assistant</p>
                </div>
            </div>
            <button onclick="toggleChat()" class="text-white/70 hover:text-white transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none"
                    stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <line x1="18" y1="6" x2="6" y2="18" />
                    <line x1="6" y1="6" x2="18" y2="18" />
                </svg>
            </button>
        </div>

        <!-- Messages -->
        <div id="chat-messages" class="flex-1 overflow-y-auto p-4 space-y-3 bg-gray-50">
            <!-- Welcome message -->
            <div class="flex gap-2">
                <div class="w-7 h-7 rounded-full overflow-hidden flex-shrink-0">
                    <img src="{{ asset('images/logo-polos.webp') }}" alt="KYB" class="w-full h-full object-cover">
                </div>
                <div class="bg-white rounded-2xl rounded-tl-none px-4 py-2.5 shadow-sm max-w-[80%]">
                    <p class="text-sm text-gray-700">Halo! Saya KYB Assistant. Ada yang bisa saya bantu? 😊<br><span
                            class="text-xs text-gray-400">*Maks. 10 pertanyaan per menit</span></p>
                </div>
            </div>
        </div>

        <!-- Input -->
        <div class="p-3 bg-white border-t border-gray-100">
            <div class="flex gap-2 items-end">
                <textarea id="chat-input" rows="1" placeholder="Ketik pesan..."
                    class="flex-1 resize-none bg-gray-50 border border-gray-200 rounded-xl px-3 py-2.5 text-sm text-gray-700 focus:outline-none focus:border-[#E62727] focus:ring-2 focus:ring-[#E62727]/10 max-h-24 overflow-y-auto"
                    onkeydown="handleKey(event)"></textarea>
                <button onclick="sendMessage()"
                    class="w-10 h-10 bg-gradient-to-r from-[#8B0000] to-[#E62727] rounded-xl flex items-center justify-center hover:scale-105 active:scale-95 transition-all shadow-md flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none"
                        stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" class="text-white">
                        <line x1="22" y1="2" x2="11" y2="13" />
                        <polygon points="22 2 15 22 11 13 2 9 22 2" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Toggle Button -->
    <button onclick="toggleChat()"
        class="w-14 h-14 bg-gradient-to-r from-[#8B0000] to-[#E62727] rounded-full shadow-[0_8px_30px_rgba(230,39,39,0.4)] flex items-center justify-center hover:scale-110 active:scale-95 transition-all">
        <svg id="chat-icon-open" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
            stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" class="text-white">
            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
        </svg>
        <svg id="chat-icon-close" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
            stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" class="text-white hidden">
            <line x1="18" y1="6" x2="6" y2="18" />
            <line x1="6" y1="6" x2="18" y2="18" />
        </svg>
    </button>
</div>

<script>
    function toggleChat() {
        const window_ = document.getElementById('chat-window');
        const iconOpen = document.getElementById('chat-icon-open');
        const iconClose = document.getElementById('chat-icon-close');
        const isHidden = window_.classList.contains('hidden');

        window_.classList.toggle('hidden');
        iconOpen.classList.toggle('hidden');
        iconClose.classList.toggle('hidden');

        if (isHidden) {
            document.getElementById('chat-input').focus();
        }
    }

    function handleKey(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            sendMessage();
        }
    }

    function appendMessage(role, text) {
        const container = document.getElementById('chat-messages');

        if (role === 'user') {
            container.innerHTML += `
                <div class="flex gap-2 justify-end">
                    <div class="bg-gradient-to-r from-[#8B0000] to-[#E62727] rounded-2xl rounded-tr-none px-4 py-2.5 max-w-[80%]">
                        <p class="text-sm text-white">${text}</p>
                    </div>
                </div>`;
        } else if (role === 'loading') {
            container.innerHTML += `
                <div class="flex gap-2" id="loading-bubble">
                    <div class="w-7 h-7 rounded-full bg-gradient-to-br from-[#8B0000] to-[#E62727] flex items-center justify-center flex-shrink-0">
                        <span class="text-white text-xs font-bold">K</span>
                    </div>
                    <div class="bg-white rounded-2xl rounded-tl-none px-4 py-3 shadow-sm">
                        <div class="flex gap-1 items-center">
                            <span class="w-2 h-2 bg-gray-300 rounded-full animate-bounce" style="animation-delay:0ms"></span>
                            <span class="w-2 h-2 bg-gray-300 rounded-full animate-bounce" style="animation-delay:150ms"></span>
                            <span class="w-2 h-2 bg-gray-300 rounded-full animate-bounce" style="animation-delay:300ms"></span>
                        </div>
                    </div>
                </div>`;
        } else {
            container.innerHTML += `
                <div class="flex gap-2">
                    <div class="w-7 h-7 rounded-full bg-gradient-to-br from-[#8B0000] to-[#E62727] flex items-center justify-center flex-shrink-0">
                        <span class="text-white text-xs font-bold">K</span>
                    </div>
                    <div class="bg-white rounded-2xl rounded-tl-none px-4 py-2.5 shadow-sm max-w-[80%]">
                        <p class="text-sm text-gray-700 whitespace-pre-wrap">${text}</p>
                    </div>
                </div>`;
        }

        container.scrollTop = container.scrollHeight;
    }

    async function sendMessage() {
        const input = document.getElementById('chat-input');
        const message = input.value.trim();
        if (!message) return;

        input.value = '';
        input.style.height = 'auto';

        appendMessage('user', message);
        appendMessage('loading', '');

        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            const res = await fetch('{{ route('chatbot') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken || '{{ csrf_token() }}',
                    'Accept': 'application/json' // ← BARIS INI YANG PENTING!
                },
                body: JSON.stringify({
                    message
                }),
            });

            const data = await res.json(); // ini akan berhasil sekarang

            document.getElementById('loading-bubble')?.remove();

            if (res.ok && data.reply) {
                appendMessage('bot', data.reply);
            } else {
                appendMessage('bot', data.error || data.message || 'Maaf, terjadi kesalahan server.');
            }
        } catch (err) {
            console.error('Chatbot Fetch Error:', err);
            document.getElementById('loading-bubble')?.remove();
            appendMessage('bot', 'Maaf, tidak bisa terhubung ke server. Lihat console F12 untuk detail.');
        }
    }
</script>
