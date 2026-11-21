<!DOCTYPE html>
<html lang="id" data-theme="sipandu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun Baru - SiPANDU VIRTUAL</title>
    <meta name="description" content="Daftar akun di SiPANDU VIRTUAL - Sistem Pendampingan Terpadu Virtual Pengawas PAI Kota Samarinda.">
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
<body class="min-h-screen bg-base-200 px-4 py-8 text-base-content sm:py-10">

    <div class="mx-auto max-w-xl">

        {{-- Header --}}
        <div class="mb-6 flex flex-col items-center text-center">
            <a href="{{ url('/') }}" class="mb-4 flex items-center gap-3">
                <div class="h-14 w-14 rounded-2xl border-2 border-base-300 bg-white p-1.5 shadow-sm">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo SiPANDU" class="h-full w-full object-contain">
                </div>
                <div class="text-left">
                    <p class="text-xl font-extrabold text-primary">SiPANDU VIRTUAL</p>
                    <p class="text-xs font-semibold text-base-content/75">Pengawas PAI Kota Samarinda</p>
                </div>
            </a>

            <h1 class="text-2xl font-extrabold text-base-content sm:text-3xl">Daftar Akun Baru</h1>
            <p class="mt-2 text-base text-base-content/80">
                Isi data diri Anda di bawah ini dengan benar untuk mendaftar.
            </p>
        </div>

        <div class="rounded-3xl border-2 border-base-300 bg-base-100 p-6 shadow-md sm:p-8">

            @if($errors->any())
                <div class="alert alert-error mb-6" role="alert">
                    <span class="material-icons text-2xl">error</span>
                    <ul class="list-disc list-inside text-sm font-medium">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register.post') }}" method="POST" class="space-y-6">
                @csrf

                {{-- Langkah 1 --}}
                <div class="space-y-4">
                    <div class="flex items-center gap-3 border-b-2 border-base-200 pb-2">
                        <span class="flex h-8 w-8 items-center justify-center rounded-full bg-primary text-sm font-extrabold text-primary-content">1</span>
                        <h2 class="text-lg font-extrabold text-base-content">Data Identitas Diri</h2>
                    </div>

                    <div class="form-control">
                        <label for="name" class="label pb-1.5">
                            <span class="label-text text-base font-bold">Nama Lengkap &amp; Gelar</span>
                        </label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}"
                            placeholder="Contoh: Ahmad Fauzan, S.Pd."
                            class="input input-bordered w-full text-base" required />
                    </div>

                    <div class="form-control">
                        <label for="email" class="label pb-1.5">
                            <span class="label-text text-base font-bold">Alamat Email</span>
                        </label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}"
                            placeholder="Contoh: nama@gmail.com"
                            class="input input-bordered w-full text-base" required />
                    </div>

                    <div class="form-control">
                        <label for="nomor_wa" class="label pb-1.5">
                            <span class="label-text text-base font-bold">Nomor WhatsApp Aktif</span>
                        </label>
                        <input id="nomor_wa" type="text" name="nomor_wa" value="{{ old('nomor_wa') }}"
                            placeholder="Contoh: 081234567890"
                            class="input input-bordered w-full text-base" />
                    </div>
                </div>

                {{-- Langkah 2 --}}
                <div class="space-y-4">
                    <div class="flex items-center gap-3 border-b-2 border-base-200 pb-2">
                        <span class="flex h-8 w-8 items-center justify-center rounded-full bg-primary text-sm font-extrabold text-primary-content">2</span>
                        <h2 class="text-lg font-extrabold text-base-content">Buat Kata Sandi</h2>
                    </div>

                    <div class="form-control">
                        <label for="password" class="label pb-1.5">
                            <span class="label-text text-base font-bold">Kata Sandi (Minimal 6 huruf/angka)</span>
                        </label>
                        <div class="relative">
                            <input id="password" type="password" name="password" placeholder="Ketik kata sandi"
                                class="input input-bordered w-full pr-28 text-base" required />
                            <button type="button" onclick="togglePass('password', this)"
                                class="btn btn-ghost btn-sm absolute right-1.5 top-1/2 -translate-y-1/2 min-h-0 h-9 px-2.5 text-xs font-bold text-primary">
                                Lihat
                            </button>
                        </div>
                    </div>

                    <div class="form-control">
                        <label for="password_confirmation" class="label pb-1.5">
                            <span class="label-text text-base font-bold">Ulangi Kata Sandi</span>
                        </label>
                        <div class="relative">
                            <input id="password_confirmation" type="password" name="password_confirmation" placeholder="Ketik ulang kata sandi"
                                class="input input-bordered w-full pr-28 text-base" required />
                            <button type="button" onclick="togglePass('password_confirmation', this)"
                                class="btn btn-ghost btn-sm absolute right-1.5 top-1/2 -translate-y-1/2 min-h-0 h-9 px-2.5 text-xs font-bold text-primary">
                                Lihat
                            </button>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-lg w-full text-lg font-bold">
                    <span class="material-icons text-2xl">how_to_reg</span>
                    Daftar Sekarang
                </button>
            </form>

            <div class="mt-6 border-t-2 border-base-200 pt-5 text-center text-base">
                <span class="text-base-content/80">Sudah punya akun?</span>
                <a href="{{ route('login') }}" class="ml-1 font-extrabold text-primary underline">Masuk di sini</a>
            </div>
        </div>

        <div class="mt-5 rounded-2xl border-2 border-base-300 bg-base-100 p-4 text-sm leading-relaxed text-base-content/85">
            <p class="flex items-start gap-2">
                <span class="material-icons text-xl text-secondary">info</span>
                <span>Akun baru terdaftar sebagai Guru PAI dan perlu disetujui terlebih dahulu oleh Admin Utama sebelum bisa masuk.</span>
            </p>
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
