<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('guru_binaans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap');
            $table->foreignId('sekolah_id')->nullable()->constrained('sekolah_binaans')->onDelete('set null');
            $table->string('nip_siaga')->unique()->nullable();
            $table->string('status_jabatan')->default('GURU'); // GURU, GURU_KEPSEK
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('user_account_id')->nullable()->unique();
            $table->foreign('user_account_id')->references('id')->on('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guru_binaans');
    }
};