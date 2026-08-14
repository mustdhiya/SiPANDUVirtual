<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('upload_dokumens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submission_id')->constrained('submissions')->onDelete('cascade');
            $table->foreignId('dokumen_wajib_id')->constrained('dokumen_wajibs')->onDelete('cascade');
            $table->string('file');
            $table->text('catatan')->nullable();
            $table->string('status')->default('pending'); // pending, diterima, revisi
            $table->text('feedback_admin')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('upload_dokumens');
    }
};