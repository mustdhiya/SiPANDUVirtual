<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('matriks_prioritas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guru_id')->constrained('guru_binaans')->onDelete('cascade');
            $table->foreignId('periode_id')->constrained('periode_triwulans')->onDelete('cascade');
            $table->string('kategori_prioritas'); // prioritas_utama, prioritas_menengah, prioritas_akhir
            $table->decimal('skor_kelengkapan', 5, 2)->default(0);
            $table->decimal('skor_respons', 5, 2)->default(0);
            $table->decimal('skor_total', 5, 2)->default(0);
            $table->text('catatan_admin')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['guru_id', 'periode_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('matriks_prioritas');
    }
};