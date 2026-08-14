<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('guru')->after('email');
            $table->boolean('is_approved')->default(false)->after('role');
            $table->string('status')->default('pending')->after('is_approved');
            $table->string('nomor_wa')->nullable()->after('status');
            $table->string('foto_profil')->nullable()->after('nomor_wa');
            $table->softDeletes()->after('foto_profil');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'is_approved', 'status', 'nomor_wa', 'foto_profil', 'deleted_at']);
        });
    }
};