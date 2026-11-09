<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Hanya jalankan MODIFY COLUMN jika database-nya MySQL (SQLite tidak butuh perintah ini)
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE users MODIFY COLUMN role VARCHAR(30) NOT NULL DEFAULT 'guru'");
        }

        // 1. Tambahkan kolom di tabel users
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'password_plain')) {
                $table->string('password_plain')->nullable();
            }
            if (!Schema::hasColumn('users', 'nip')) {
                $table->string('nip', 50)->nullable();
            }
            if (!Schema::hasColumn('users', 'is_profile_complete')) {
                $table->boolean('is_profile_complete')->default(false);
            }
        });

        // 2. Tambahkan pengawas_id di guru_binaans
        Schema::table('guru_binaans', function (Blueprint $table) {
            if (!Schema::hasColumn('guru_binaans', 'pengawas_id')) {
                $table->foreignId('pengawas_id')
                    ->nullable()
                    ->constrained('users')
                    ->nullOnDelete();
            }
        });

        // 3. Tambahkan pengawas_id di dokumen_wajibs
        Schema::table('dokumen_wajibs', function (Blueprint $table) {
            if (!Schema::hasColumn('dokumen_wajibs', 'pengawas_id')) {
                $table->foreignId('pengawas_id')
                    ->nullable()
                    ->constrained('users')
                    ->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('dokumen_wajibs', function (Blueprint $table) {
            if (Schema::hasColumn('dokumen_wajibs', 'pengawas_id')) {
                $table->dropForeign(['pengawas_id']);
                $table->dropColumn('pengawas_id');
            }
        });

        Schema::table('guru_binaans', function (Blueprint $table) {
            if (Schema::hasColumn('guru_binaans', 'pengawas_id')) {
                $table->dropForeign(['pengawas_id']);
                $table->dropColumn('pengawas_id');
            }
        });

        Schema::table('users', function (Blueprint $table) {
            $cols = array_filter(['password_plain', 'nip', 'is_profile_complete'], fn($c) => Schema::hasColumn('users', $c));
            if (!empty($cols)) {
                $table->dropColumn($cols);
            }
        });
    }
};