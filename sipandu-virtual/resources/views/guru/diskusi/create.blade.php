@extends('layouts.guru')

@section('title', 'Buat Thread Diskusi')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-4">Buat Thread Diskusi - TW {{ $periode->nomor }}</h1>

    <div class="card bg-base-200 shadow-md">
        <div class="card-body">
            <form action="{{ route('guru.diskusi.store', $periode->id) }}" method="POST">
                @csrf

                <div class="form-control mb-4">
                    <label class="label">
                        <span class="label-text">Judul Thread</span>
                    </label>
                    <input type="text" name="judul" value="{{ old('judul') }}" placeholder="Contoh: Pertanyaan tentang dokumen Prota" class="input input-bordered" required />
                </div>

                <div class="form-control mb-4">
                    <label class="label">
                        <span class="label-text">Isi Thread</span>
                    </label>
                    <textarea name="isi" class="textarea textarea-bordered" rows="4" placeholder="Jelaskan pertanyaan atau topik diskusi Anda..." required>{{ old('isi') }}</textarea>
                </div>

                <div class="form-control mt-4">
                    <button type="submit" class="btn btn-primary">
                        <span class="material-icons align-middle mr-2">send</span>
                        Buat Thread
                    </button>
                    <a href="{{ route('guru.diskusi.show', $periode->id) }}" class="btn btn-ghost">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection