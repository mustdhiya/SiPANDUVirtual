<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('periode_triwulans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tahun_ajaran_id')->constrained('tahun_ajarans')->onDelete('cascade');
            $table->integer('nomor'); // 1, 2, 3, 4
            $table->string('tema');
            $table->date('deadline');
            $table->boolean('is_open')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['tahun_ajaran_id', 'nomor']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('periode_triwulans');
    }
};