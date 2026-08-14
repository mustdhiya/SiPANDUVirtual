<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guru_id')->constrained('guru_binaans')->onDelete('cascade');
            $table->foreignId('periode_id')->constrained('periode_triwulans')->onDelete('cascade');
            $table->string('status_review')->default('draft'); // draft, submitted, revisi, lengkap
            $table->text('feedback_admin')->nullable();
            $table->datetime('submitted_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['guru_id', 'periode_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('submissions');
    }
};