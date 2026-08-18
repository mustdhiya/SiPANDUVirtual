<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('thread_diskusis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guru_id')->constrained('guru_binaans')->onDelete('cascade');
            $table->foreignId('periode_id')->constrained('periode_triwulans')->onDelete('cascade');
            $table->string('judul');
            $table->text('isi');
            $table->boolean('is_locked')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['periode_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('thread_diskusis');
    }
};