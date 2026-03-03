<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP</title>
    @vite(['resources/css/app.css', 'resources/js/otp.js'])
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

    @keyframes shake {

        0%,
        100% {
            transform: translateX(0);
        }

        10%,
        30%,
        50%,
        70%,
        90% {
            transform: translateX(-5px);
        }

        20%,
        40%,
        60%,
        80% {
            transform: translateX(5px);
        }
    }

    .animate-fade-in {
        animation: fade-in 0.8s cubic-bezier(0.4, 0, 0.2, 1) forwards;
    }

    .animate-shake {
        animation: shake 0.6s cubic-bezier(.36, .07, .19, .97) both;
    }
</style>

<body class="flex items-center justify-center min-h-screen relative overflow-hidden font-['Manrope',sans-serif]">

    <div class="fixed inset-0 -z-10">
        <img src="{{ asset('images/kayaba-bg.webp') }}"
            class="w-full h-full object-cover brightness-100 contrast-125 saturate-110">
    </div>

    <div class="relative z-10 w-full max-w-[450px] p-4 animate-fade-in">
        <div
            class="bg-white/95 backdrop-blur-xl p-10 rounded-[2.5rem] shadow-[0_25px_80px_rgba(0,0,0,0.15)] border border-white/50 relative overflow-hidden after:absolute after:top-0 after:left-0 after:right-0 after:h-2 after:bg-gradient-to-r after:from-[#E62727] after:via-[#ff4444] after:to-[#E62727]">

            <form action="{{ route('otp.verify') }}" method="POST" class="flex flex-col gap-8 text-center mt-2">
                @csrf

                <div class="flex flex-col gap-1">
                    <div
                        class="w-28 h-28 rounded-2xl mx-auto mb-2 flex items-center justify-center overflow-hidden transition-transform hover:scale-110">
                        <img src="{{ asset('images/kyb-remove.png') }}" class="w-full h-full object-contain scale-125"
                            alt="Logo">
                    </div>
                    <h2 class="text-2xl font-bold text-slate-800">Verifikasi OTP</h2>
                    <p class="text-slate-500 text-sm leading-relaxed">Masukkan 6 Digit Kode Yang Dikirimkan <strong
                            class="text-[#E62727]"></strong></p>
                </div>

                @if (session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-r-xl">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-r-xl">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="flex justify-center gap-0.5 sm:gap-1">
                    @for ($i = 0; $i < 6; $i++)
                        <input type="text" name="otp[]" maxlength="1" required {{ $i == 0 ? 'autofocus' : '' }}
                            class="w-12 h-14 sm:w-14 sm:h-16 text-center text-2xl font-bold bg-slate-50 border border-slate-200 rounded-xl transition-all focus:bg-white focus:border-[#E62727] focus:ring-4 focus:ring-[#E62727]/10 outline-none"
                            oninput="if(this.value.length==1) this.nextElementSibling?.focus()">
                    @endfor
                </div>

                <button type="submit"
                    class="w-full h-15 bg-gradient-to-br from-[#8B0000] to-[#E62727] text-white font-bold text-lg rounded-2xl shadow-[0_10px_30px_rgba(139,0,0,0.3)] transition-all duration-300 hover:scale-[1.02] hover:shadow-[0_15px_40px_rgba(139,0,0,0.4)] active:scale-95 flex items-center justify-center gap-3 cursor-pointer mt-2">
                    <span>Verifikasi Sekarang</span>
                </button>

                <div class="text-sm text-slate-400 font-medium flex items-center gap-1 justify-center">
                    Tidak menerima kode?
                    <form action="{{ route('otp.resend') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit"
                            class="text-[#E62727] hover:underline transition-all font-medium focus:outline-none">
                            Kirim ulang
                        </button>
                    </form>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
