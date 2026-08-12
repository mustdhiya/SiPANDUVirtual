<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rotation_rules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rolling_schedule_id')->constrained('rolling_schedules')->onDelete('cascade');
            $table->foreignId('task_template_id')->constrained('task_templates')->onDelete('cascade');
            $table->integer('rotation_order');
            $table->integer('interval_days')->default(1);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rotation_rules');
    }
};