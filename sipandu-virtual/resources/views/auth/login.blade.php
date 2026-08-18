<!DOCTYPE html>
<html lang="id" data-theme="sipandu-warm">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - SiPANDU VIRTUAL</title>
    <meta name="description" content="Masuk ke SiPANDU VIRTUAL — Sistem Pendampingan Terpadu Virtual Pengawas PAI Kota Samarinda.">

    {{-- Material Icons (WAJIB sesuai standar sistem) --}}
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    {{-- Font selaras dengan landing page --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,500;0,9..144,600;0,9..144,700;1,9..144,500&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/daisyui@5/daisyui.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <style>
        :root{
            --sw-bg:#faf7f0; --sw-bg-alt:#eef0e3; --sw-dark:#3d4a2f; --sw-dark2:#2d3822;
            --sw-gold:#a97f34; --sw-gold-tint:#f2e6cc; --sw-text:#1f2419; --sw-text2:#4f5546;
            --sw-border:rgba(61,74,47,0.16);
        }
        body{ font-family:'Inter',sans-serif; background:var(--sw-bg); color:var(--sw-text); }
        .font-display{ font-family:'Fraunces',serif; }
        .brand-panel{
            background: linear-gradient(160deg, var(--sw-dark) 0%, var(--sw-dark2) 100%);
            position:relative; overflow:hidden;
        }
        .brand-panel::before{
            content:''; position:absolute; width:420px; height:420px; border-radius:50%;
            border:1px solid rgba(255,255,255,0.12); top:-120px; right:-140px;
        }
        .brand-panel::after{
            content:''; position:absolute; width:280px; height:280px; border-radius:50%;
            border:1px solid rgba(255,255,255,0.08); bottom:-100px; left:-90px;
        }
        .logo-badge{
            width:46px; height:46px; background:var(--sw-gold); color:#fff; border-radius:0.85rem;
            display:flex; align-items:center; justify-content:center; flex-shrink:0;
        }
        .form-input-icon{ position:relative; }
        .form-input-icon .material-icons{
            position:absolute; left:0.9rem; top:50%; transform:translateY(-50%);
            color:var(--sw-text2); font-size:1.25rem; pointer-events:none;
        }
        .input-with-icon{ padding-left:2.75rem !important; }
        .input-bordered:focus{ border-color:var(--sw-gold) !important; outline:2px solid var(--sw-gold-tint); }
        .btn-brand{
            background:var(--sw-dark); color:#fff; border:none;
            transition:transform 180ms cubic-bezier(0.16,1,0.3,1), background-color 180ms ease;
        }
        .btn-brand:hover{ background:var(--sw-dark2); transform:scale(1.015); }
        .link-gold{ color:var(--sw-gold); font-weight:600; }
        .link-gold:hover{ text-decoration:underline; }
        .role-note{ background:var(--sw-gold-tint); border:1px solid var(--sw-border); }
        a:focus-visible, button:focus-visible, input:focus-visible{
            outline:3px solid var(--sw-gold); outline-offset:2px;
        }
    </style>
</head>
<body class="min-h-screen">

    <div class="grid lg:grid-cols-2 min-h-screen">

        {{-- KIRI: Branding (tersembunyi di mobile agar form langsung terlihat) --}}
        <div class="brand-panel hidden lg:flex flex-col justify-between p-12 text-white relative z-10">
            <div class="flex items-center gap-3">
                <div class="logo-badge">
                    <span class="material-icons" style="font-size:24px;">explore</span>
                </div>
                <div>
                    <div class="font-display font-bold text-lg leading-tight">SiPANDU</div>
                    <div class="text-xs tracking-widest opacity-70">VIRTUAL &middot; PENGAWAS PAI SAMARINDA</div>
                </div>
            </div>

            <div class="max-w-md">
                <h1 class="font-display font-medium text-4xl leading-tight mb-4">
                    Mendampingi guru,<br>
                    <em class="italic" style="color:var(--sw-gold);">menguatkan</em> pendidikan.
                </h1>
                <p class="opacity-80 text-sm leading-relaxed">
                    Satu sistem terpadu untuk Pengawas dan Guru PAI SMA/SMK Kota Samarinda memantau, mendampingi, dan melaporkan kegiatan pembinaan secara digital.
                </p>
            </div>

            <div class="flex items-center gap-3 text-sm opacity-70">
                <span class="material-icons" style="font-size:18px;">verified_user</span>
                <span>Data Anda aman &amp; hanya dapat diakses sesuai peran.</span>
            </div>
        </div>

        {{-- KANAN: Form Login --}}
        <div class="flex items-center justify-center p-6 lg:p-12 bg-base-100">
            <div class="w-full max-w-sm">

                {{-- Logo untuk mobile --}}
                <div class="flex items-center gap-3 mb-8 lg:hidden">
                    <div class="logo-badge" style="background:var(--sw-dark);">
                        <span class="material-icons" style="font-size:22px;">explore</span>
                    </div>
                    <div class="font-display font-bold text-lg" style="color:var(--sw-dark);">SiPANDU VIRTUAL</div>
                </div>

                <div class="mb-8">
                    <h2 class="font-display font-semibold text-3xl mb-2" style="color:var(--sw-text);">Selamat Datang</h2>
                    <p class="text-sm" style="color:var(--sw-text2);">Masuk untuk melanjutkan pendampingan Anda.</p>
                </div>

                @if(session('success'))
                    <div class="alert alert-success mb-4 text-sm">
                        <span class="material-icons text-base">check_circle</span>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-error mb-4 text-sm">
                        <span class="material-icons text-base">error</span>
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
                    @csrf

                    <div class="form-control">
                        <label class="label pb-1">
                            <span class="label-text font-medium">Email</span>
                        </label>
                        <div class="form-input-icon">
                            <span class="material-icons">mail</span>
                            <input type="email" name="email" value="{{ old('email') }}"
                                placeholder="nama@sekolah.sch.id"
                                class="input input-bordered w-full input-with-icon" required autofocus />
                        </div>
                    </div>

                    <div class="form-control">
                        <label class="label pb-1">
                            <span class="label-text font-medium">Kata Sandi</span>
                        </label>
                        <div class="form-input-icon">
                            <span class="material-icons">lock</span>
                            <input type="password" name="password" placeholder="••••••••"
                                class="input input-bordered w-full input-with-icon" required />
                        </div>
                    </div>

                    <div class="form-control mt-2">
                        <label class="label cursor-pointer justify-start gap-2 py-0">
                            <input type="checkbox" name="remember" class="checkbox checkbox-sm" />
                            <span class="label-text text-sm">Ingat saya di perangkat ini</span>
                        </label>
                    </div>

                    <button type="submit" class="btn btn-brand w-full mt-2">
                        <span class="material-icons text-base">login</span>
                        Masuk
                    </button>
                </form>

                <div class="divider text-xs" style="color:var(--sw-text2);">atau</div>

                <div class="text-center text-sm" style="color:var(--sw-text2);">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="link-gold">Daftar sebagai Guru</a>
                </div>

                <div class="role-note rounded-xl p-3 mt-6 flex items-start gap-2 text-xs" style="color:var(--sw-text2);">
                    <span class="material-icons text-sm" style="color:var(--sw-gold);">info</span>
                    <span>Akun Guru baru perlu disetujui Admin sebelum bisa masuk. Jika belum aktif, hubungi Pengawas PAI.</span>
                </div>
            </div>
        </div>
    </div>

</body>
</html>