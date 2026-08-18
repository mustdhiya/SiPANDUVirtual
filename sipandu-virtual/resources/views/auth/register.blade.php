<!DOCTYPE html>
<html lang="id" data-theme="sipandu-warm">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - SiPANDU VIRTUAL</title>
    <meta name="description" content="Daftar akun Guru PAI di SiPANDU VIRTUAL — Sistem Pendampingan Terpadu Virtual Pengawas PAI Kota Samarinda.">

    {{-- Material Icons (WAJIB sesuai standar sistem) --}}
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

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
        body{ font-family:'Inter',sans-serif; background:var(--sw-bg-alt); color:var(--sw-text); }
        .font-display{ font-family:'Fraunces',serif; }
        .logo-badge{
            width:44px; height:44px; background:var(--sw-dark); color:#fff; border-radius:0.85rem;
            display:flex; align-items:center; justify-content:center; flex-shrink:0;
        }
        .form-input-icon{ position:relative; }
        .form-input-icon .material-icons{
            position:absolute; left:0.9rem; top:50%; transform:translateY(-50%);
            color:var(--sw-text2); font-size:1.25rem; pointer-events:none;
        }
        .input-with-icon{ padding-left:2.75rem !important; }
        .select-with-icon{ padding-left:2.75rem !important; }
        .input-bordered:focus, .select-bordered:focus{
            border-color:var(--sw-gold) !important; outline:2px solid var(--sw-gold-tint);
        }
        .btn-brand{
            background:var(--sw-dark); color:#fff; border:none;
            transition:transform 180ms cubic-bezier(0.16,1,0.3,1), background-color 180ms ease;
        }
        .btn-brand:hover{ background:var(--sw-dark2); transform:scale(1.015); }
        .link-gold{ color:var(--sw-gold); font-weight:600; }
        .link-gold:hover{ text-decoration:underline; }
        .step-badge{
            width:28px; height:28px; border-radius:50%; background:var(--sw-gold-tint);
            color:var(--sw-gold); display:flex; align-items:center; justify-content:center;
            font-weight:700; font-size:0.8rem; flex-shrink:0;
        }
        .role-card{
            border:2px solid var(--sw-border); border-radius:1rem; padding:0.9rem 1rem;
            cursor:pointer; transition:all 160ms ease; background:#fff;
        }
        .role-card:hover{ border-color:var(--sw-gold); }
        input[type="radio"]:checked + .role-card,
        .role-card.role-selected{
            border-color:var(--sw-dark); background:var(--sw-gold-tint);
        }
        a:focus-visible, button:focus-visible, input:focus-visible, select:focus-visible{
            outline:3px solid var(--sw-gold); outline-offset:2px;
        }
    </style>
</head>
<body class="min-h-screen py-8 px-4">

    <div class="max-w-lg mx-auto">

        {{-- Logo & Header --}}
        <div class="flex flex-col items-center text-center mb-6">
            <a href="{{ url('/') }}" class="flex items-center gap-3 mb-4">
                <div class="logo-badge">
                    <span class="material-icons" style="font-size:22px;">explore</span>
                </div>
                <div class="text-left">
                    <div class="font-display font-bold text-lg leading-tight" style="color:var(--sw-dark);">SiPANDU</div>
                    <div class="text-[0.65rem] tracking-widest" style="color:var(--sw-text2);">VIRTUAL &middot; PENGAWAS PAI SAMARINDA</div>
                </div>
            </a>
            <h2 class="font-display font-semibold text-2xl" style="color:var(--sw-text);">Daftar Akun Baru</h2>
            <p class="text-sm mt-1" style="color:var(--sw-text2);">Lengkapi data di bawah untuk membuat akun.</p>
        </div>

        <div class="card bg-base-100 shadow-xl">
            <div class="card-body p-6 lg:p-8">

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

                <form action="{{ route('register.post') }}" method="POST" class="space-y-5">
                    @csrf

                    {{-- Step 1: Identitas --}}
                    <div>
                        <div class="flex items-center gap-2 mb-3">
                            <span class="step-badge">1</span>
                            <span class="font-semibold text-sm" style="color:var(--sw-text);">Identitas Diri</span>
                        </div>

                        <div class="form-control mb-3">
                            <label class="label pb-1">
                                <span class="label-text font-medium">Nama Lengkap</span>
                            </label>
                            <div class="form-input-icon">
                                <span class="material-icons">person</span>
                                <input type="text" name="name" value="{{ old('name') }}"
                                    placeholder="Contoh: Ahmad Fauzan, S.Pd."
                                    class="input input-bordered w-full input-with-icon" required />
                            </div>
                        </div>

                        <div class="form-control mb-3">
                            <label class="label pb-1">
                                <span class="label-text font-medium">Email</span>
                            </label>
                            <div class="form-input-icon">
                                <span class="material-icons">mail</span>
                                <input type="email" name="email" value="{{ old('email') }}"
                                    placeholder="nama@sekolah.sch.id"
                                    class="input input-bordered w-full input-with-icon" required />
                            </div>
                        </div>

                        <div class="form-control">
                            <label class="label pb-1">
                                <span class="label-text font-medium">Nomor WhatsApp</span>
                            </label>
                            <div class="form-input-icon">
                                <span class="material-icons">chat</span>
                                <input type="text" name="nomor_wa" value="{{ old('nomor_wa') }}"
                                    placeholder="08xxxxxxxxxx"
                                    class="input input-bordered w-full input-with-icon" />
                            </div>
                        </div>
                    </div>

                    <div class="divider my-2"></div>

                    {{-- Step 2: Peran --}}
                    <div>
                        <div class="flex items-center gap-2 mb-3">
                            <span class="step-badge">2</span>
                            <span class="font-semibold text-sm" style="color:var(--sw-text);">Pilih Peran</span>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <label class="block">
                                <input type="radio" name="role" value="guru" class="hidden peer"
                                    {{ old('role', 'guru') === 'guru' ? 'checked' : '' }}
                                    onchange="document.querySelectorAll('.role-card').forEach(el=>el.classList.remove('role-selected')); this.nextElementSibling.classList.add('role-selected');" />
                                <div class="role-card {{ old('role', 'guru') === 'guru' ? 'role-selected' : '' }} text-center">
                                    <span class="material-icons block mb-1" style="color:var(--sw-dark);">school</span>
                                    <span class="font-semibold text-sm">Guru PAI</span>
                                </div>
                            </label>
                            <label class="block">
                                <input type="radio" name="role" value="admin" class="hidden peer"
                                    {{ old('role') === 'admin' ? 'checked' : '' }}
                                    onchange="document.querySelectorAll('.role-card').forEach(el=>el.classList.remove('role-selected')); this.nextElementSibling.classList.add('role-selected');" />
                                <div class="role-card {{ old('role') === 'admin' ? 'role-selected' : '' }} text-center">
                                    <span class="material-icons block mb-1" style="color:var(--sw-dark);">shield_person</span>
                                    <span class="font-semibold text-sm">Admin</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="divider my-2"></div>

                    {{-- Step 3: Kata Sandi --}}
                    <div>
                        <div class="flex items-center gap-2 mb-3">
                            <span class="step-badge">3</span>
                            <span class="font-semibold text-sm" style="color:var(--sw-text);">Buat Kata Sandi</span>
                        </div>

                        <div class="form-control mb-3">
                            <label class="label pb-1">
                                <span class="label-text font-medium">Kata Sandi</span>
                            </label>
                            <div class="form-input-icon">
                                <span class="material-icons">lock</span>
                                <input type="password" name="password" placeholder="Minimal 6 karakter"
                                    class="input input-bordered w-full input-with-icon" required />
                            </div>
                        </div>

                        <div class="form-control">
                            <label class="label pb-1">
                                <span class="label-text font-medium">Konfirmasi Kata Sandi</span>
                            </label>
                            <div class="form-input-icon">
                                <span class="material-icons">lock_reset</span>
                                <input type="password" name="password_confirmation" placeholder="Ulangi kata sandi"
                                    class="input input-bordered w-full input-with-icon" required />
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-brand w-full mt-2">
                        <span class="material-icons text-base">how_to_reg</span>
                        Daftar Sekarang
                    </button>
                </form>

                <div class="text-center text-sm mt-5" style="color:var(--sw-text2);">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="link-gold">Masuk di sini</a>
                </div>
            </div>
        </div>

        <div class="flex items-start gap-2 text-xs mt-4 px-2" style="color:var(--sw-text2);">
            <span class="material-icons text-sm" style="color:var(--sw-gold);">info</span>
            <span>Akun yang mendaftar sebagai Guru akan diverifikasi oleh Admin (Pengawas PAI) sebelum dapat digunakan untuk masuk.</span>
        </div>
    </div>

</body>
</html>