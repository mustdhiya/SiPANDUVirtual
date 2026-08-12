<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('daily_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('template_id')->constrained('task_templates')->onDelete('cascade');
            $table->foreignId('family_id')->constrained('families')->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('date');
            $table->string('status')->default('pending'); // pending, in_progress, waiting_verification, completed, skipped, absent
            $table->datetime('due_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['family_id', 'date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('daily_tasks');
    }
};