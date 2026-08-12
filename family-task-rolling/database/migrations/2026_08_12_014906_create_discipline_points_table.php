<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('discipline_points', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('family_id')->constrained('families')->onDelete('cascade');
            $table->integer('point_change');
            $table->string('reason_code');
            $table->text('reason_detail')->nullable();
            $table->string('reference_type')->nullable();
            $table->integer('reference_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['user_id', 'family_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('discipline_points');
    }
};