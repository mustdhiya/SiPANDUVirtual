<!DOCTYPE html>
<html lang="id" data-theme="sipandu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - SiPANDU VIRTUAL</title>
    <meta name="description" content="Masuk ke SiPANDU VIRTUAL - Sistem Pendampingan Terpadu Virtual Pengawas PAI Kota Samarinda.">
    <link rel="manifest" href="{{ asset('manifest.webmanifest') }}">
    <meta name="theme-color" content="#1E4D2B">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-title" content="SiPANDU">

    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-base-200 text-base-content">

    <div class="grid min-h-screen lg:grid-cols-2">

        {{-- KIRI: Panel Sambutan (Desktop) --}}
        <div class="hidden flex-col justify-between bg-primary p-12 text-primary-content lg:flex">
            <div class="flex items-center gap-4">
                <div class="h-14 w-14 rounded-2xl bg-white p-1.5 shadow-md">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo SiPANDU" class="h-full w-full object-contain">
                </div>
                <div>
                    <p class="text-2xl font-extrabold leading-tight">SiPANDU VIRTUAL</p>
                    <p class="text-sm opacity-90">Pengawas PAI Kota Samarinda</p>
                </div>
            </div>

            <div class="max-w-lg space-y-4">
                <h1 class="text-4xl font-extrabold leading-tight">
                    Sistem Pendampingan Terpadu Guru &amp; Pengawas PAI
                </h1>
                <p class="text-lg leading-relaxed opacity-90">
                    Dirancang sederhana, jelas, dan nyaman digunakan untuk pelaporan triwulan, pemeriksaan berkas, dan pembinaan guru PAI.
                </p>
            </div>

            <div class="flex items-center gap-3 rounded-2xl bg-white/10 p-4 text-sm">
                <span class="material-icons text-2xl">verified_user</span>
                <span>Masuk menggunakan email dan kata sandi yang telah terdaftar.</span>
            </div>
        </div>

        {{-- KANAN: Form Masuk --}}
        <div class="flex items-center justify-center p-5 sm:p-10">
            <div class="w-full max-w-md rounded-3xl border-2 border-base-300 bg-base-100 p-6 shadow-md sm:p-8">

                {{-- Logo Mobile --}}
                <div class="mb-6 flex items-center gap-3 lg:hidden">
                    <div class="h-12 w-12 rounded-xl border-2 border-base-300 bg-white p-1">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo SiPANDU" class="h-full w-full object-contain">
                    </div>
                    <div>
                        <p class="text-xl font-extrabold text-primary">SiPANDU VIRTUAL</p>
                        <p class="text-xs font-medium text-base-content/75">Pengawas PAI Samarinda</p>
                    </div>
                </div>

                <div class="mb-6">
                    <h2 class="text-2xl font-extrabold text-base-content sm:text-3xl">Masuk ke Akun Anda</h2>
                    <p class="mt-2 text-base text-base-content/80">
                        Ketik email dan kata sandi Anda di bawah ini.
                    </p>
                </div>

                @if(session('success'))
                    <div class="alert alert-success mb-5" role="status">
                        <span class="material-icons text-2xl">check_circle</span>
                        <span class="font-semibold">{{ session('success') }}</span>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-error mb-5" role="alert">
                        <span class="material-icons text-2xl">error</span>
                        <ul class="list-disc list-inside text-sm font-medium">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('login.post') }}" method="POST" class="space-y-5">
                    @csrf

                    <div class="form-control">
                        <label for="email" class="label pb-1.5">
                            <span class="label-text text-base font-bold">Alamat Email</span>
                        </label>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="Contoh: nama@sekolah.sch.id"
                            class="input input-bordered w-full text-base"
                            required
                            autofocus
                        />
                    </div>

                    <div class="form-control">
                        <label for="password" class="label pb-1.5">
                            <span class="label-text text-base font-bold">Kata Sandi</span>
                        </label>
                        <div class="relative">
                            <input
                                id="password"
                                type="password"
                                name="password"
                                placeholder="Ketik kata sandi Anda"
                                class="input input-bordered w-full pr-28 text-base"
                                required
                            />
                            <button
                                type="button"
                                onclick="togglePass('password', this)"
                                class="btn btn-ghost btn-sm absolute right-1.5 top-1/2 -translate-y-1/2 min-h-0 h-9 px-2.5 text-xs font-bold text-primary"
                            >
                                Lihat
                            </button>
                        </div>
                    </div>

                    <label class="flex cursor-pointer items-center gap-3 pt-1">
                        <input type="checkbox" name="remember" class="checkbox checkbox-primary h-6 w-6" />
                        <span class="text-base font-medium text-base-content">Ingat saya di perangkat ini</span>
                    </label>

                    <button type="submit" class="btn btn-primary btn-lg w-full text-lg font-bold">
                        <span class="material-icons text-2xl">login</span>
                        Masuk Sekarang
                    </button>
                </form>

                <div class="divider my-6 text-sm font-semibold">atau</div>

                <div class="text-center text-base">
                    <p class="text-base-content/80">Belum punya akun?</p>
                    <a href="{{ route('register') }}" class="btn btn-outline btn-secondary border-2 mt-2 w-full font-bold">
                        Daftar Akun Baru
                    </a>
                </div>

                <div class="mt-6 rounded-xl border border-base-300 bg-base-200 p-4 text-sm leading-relaxed text-base-content/85">
                    <p class="flex items-start gap-2">
                        <span class="material-icons text-xl text-secondary">info</span>
                        <span>Jika lupa kata sandi atau akun belum aktif, silakan hubungi <strong>Admin Utama / Pengawas PAI</strong>.</span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePass(id, btn) {
            var input = document.getElementById(id);
            if (!input) return;
            if (input.type === 'password') {
                input.type = 'text';
                btn.textContent = 'Sembunyi';
            } else {
                input.type = 'password';
                btn.textContent = 'Lihat';
            }
        }
    </script>
</body>
</html>
