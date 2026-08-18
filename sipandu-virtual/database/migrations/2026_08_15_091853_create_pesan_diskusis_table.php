<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pesan_diskusis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('thread_id')->constrained('thread_diskusis')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->text('isi_pesan');
            $table->boolean('is_admin')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['thread_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pesan_diskusis');
    }
};