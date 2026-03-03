<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<style>
    @keyframes fade-in {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in {
        animation: fade-in 0.8s cubic-bezier(0.4, 0, 0.2, 1) forwards;
    }
</style>

<body
    class="bg-[#F3F2EC] flex items-center justify-center min-h-screen relative overflow-hidden font-['Manrope',sans-serif]">

    <!-- Background Elements -->
    <div class="fixed inset-0 z-0 pointer-events-none transform scale-105">
        <img src="{{ asset('images/kayaba-bg.webp') }}" alt="Background" class="w-full h-full object-cover">
    </div>

    <div class="relative z-10 w-full max-w-[430px] p-4 animate-fade-in">
        <div
            class="bg-white p-10 rounded-[2rem] shadow-[0_20px_60px_rgba(0,0,0,0.12)]
           border border-slate-200/60   <!-- tipis + soft -->
           relative overflow-hidden
           after:absolute after:top-0 after:left-0 after:right-0 after:h-2
           after:bg-gradient-to-r after:from-[#E62727] after:via-[#ff4444] after:to-[#E62727]">

            <form action="{{ route('login') }}" method="POST" class="flex flex-col gap-4">
                @csrf

                <!-- Logo Section -->
                <div class="flex justify-center mb-8 transition-all hover:scale-105 duration-500">
                    <img src="{{ asset('images/kyb-remove.png') }}" alt="Logo Aplikasi"
                        class="w-[180px] drop-shadow-sm">
                </div>

                <div class="flex flex-col gap-6">
                    <!-- NPK Input -->
                    <div class="flex flex-col gap-2 group">
                        <label for="npk"
                            class="text-sm font-bold text-slate-500 uppercase tracking-widest ml-1 transition-colors group-focus-within:text-[#E62727]">NPK</label>
                        <div class="relative">
                            <input type="text" id="npk" name="npk" required
                                class="w-full h-14 bg-slate-50 border border-slate-200 rounded-2xl px-5 text-slate-700 font-semibold transition-all focus:bg-white focus:border-[#E62727] focus:ring-4 focus:ring-[#E62727]/10 outline-none">
                            <i
                                class="fas fa-user absolute right-5 top-1/2 -translate-y-1/2 text-slate-300 transition-colors group-focus-within:text-[#E62727]"></i>
                        </div>
                    </div>

                    <!-- Password Input -->
                    <div class="flex flex-col gap-2 group">
                        <label for="password"
                            class="text-sm font-bold text-slate-500 uppercase tracking-widest ml-1 transition-colors group-focus-within:text-[#E62727]">Password</label>
                        <div class="relative">
                            <input type="password" id="password" name="password" required
                                class="w-full h-14 bg-slate-50 border border-slate-200 rounded-2xl px-5 text-slate-700 font-semibold transition-all focus:bg-white focus:border-[#E62727] focus:ring-4 focus:ring-[#E62727]/10 outline-none">
                        </div>
                    </div>

                    <!-- Captcha Section -->
                    <div class="flex flex-col gap-3 group">
                        <label for="captcha"
                            class="text-sm font-bold text-slate-500 uppercase tracking-widest ml-1 transition-colors group-focus-within:text-[#E62727]">Captcha</label>
                        <div class="flex items-center gap-3 p-3">
                            <div
                                class="captcha-img flex-1 overflow-hidden h-12 rounded-xl border border-slate-100 bg-white flex items-center justify-center scale-90 origin-left">
                                <img id="captcha-image" src="{{ captcha_src('default') }}" alt="Captcha Code"
                                    class="max-h-full">
                                <span class="text-xs text-slate-400 hidden" id="captcha-error">Captcha gagal dimuat, cek
                                    GD atau refresh</span>
                            </div>
                            <button type="button"
                                class="w-12 h-12 flex items-center justify-center bg-white text-[#E62727] border border-slate-200 rounded-xl transition-all hover:bg-[#E62727] hover:text-white hover:border-[#E62727] shadow-sm active:scale-95"
                                onclick="refreshCaptcha()">
                                <i class="fas fa-sync-alt"></i>
                            </button>
                        </div>
                        <input type="text" id="captcha" name="captcha" required
                            placeholder="Masukkan captcha di atas"
                            class="w-full h-14 bg-slate-50 border border-slate-200 rounded-2xl px-5 text-slate-700 font-semibold transition-all focus:bg-white focus:border-[#E62727] focus:ring-4 focus:ring-[#E62727]/10 outline-none placeholder:text-slate-300 placeholder:font-normal">
                    </div>

                    @if ($errors->any() || session('error'))
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-r-xl">
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    @foreach ($errors->all() as $error)
                                        <li>{{ str_replace('validation.captcha', 'Captcha salah', strtolower($error)) }}
                                        </li>
                                    @endforeach
                                @endforeach
                                @if (session('error'))
                                    <li>{{ session('error') }}</li>
                                @endif
                            </ul>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-r-xl">
                            {{ session('success') }}
                        </div>
                    @endif

                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full h-15 bg-gradient-to-br from-[#8B0000] to-[#E62727] text-white font-bold text-lg rounded-2xl shadow-[0_10px_30px_rgba(139,0,0,0.3)] transition-all duration-300 hover:scale-[1.02] hover:shadow-[0_15px_40px_rgba(139,0,0,0.4)] active:scale-95 flex items-center justify-center gap-3 cursor-pointer mt-2">
                    <span>Masuk</span>
                    <i class="fas fa-arrow-right text-sm opacity-80 group-hover:translate-x-1 transition-transform"></i>
                </button>
            </form>
        </div>
    </div>

    <script>
        function refreshCaptcha() {
            const img = document.getElementById('captcha-image');
            if (img) {
                img.src = '{{ captcha_src('default') }}?' + new Date().getTime();
            }
        }
    </script>

</body>

</html>
