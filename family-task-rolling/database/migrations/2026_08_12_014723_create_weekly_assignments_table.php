<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('weekly_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rolling_schedule_id')->constrained('rolling_schedules')->onDelete('cascade');
            $table->date('week_start_date');
            $table->date('week_end_date');
            $table->json('assignment_map');
            $table->boolean('is_locked')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('weekly_assignments');
    }
};