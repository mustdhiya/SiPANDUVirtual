<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('verification_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('verification_id')->nullable()->constrained('task_verifications')->onDelete('cascade');
            $table->foreignId('skip_request_id')->nullable()->constrained('skip_requests')->onDelete('cascade');
            $table->foreignId('commented_by')->constrained('users')->onDelete('cascade');
            $table->text('content');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('verification_comments');
    }
};