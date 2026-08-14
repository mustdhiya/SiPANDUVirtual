<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dokumen_wajibs', function (Blueprint $table) {
            $table->id();
            $table->integer('triwulan'); // 1, 2, 3, 4
            $table->string('nama_dokumen');
            $table->text('instruksi');
            $table->boolean('is_wajib')->default(true);
            $table->string('berlaku_untuk')->default('SEMUA'); // SEMUA, KEPSEK
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('urutan')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['triwulan', 'urutan']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dokumen_wajibs');
    }
};