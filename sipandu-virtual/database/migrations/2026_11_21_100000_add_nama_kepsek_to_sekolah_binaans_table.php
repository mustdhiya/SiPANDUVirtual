<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('sekolah_binaans', 'nama_kepsek')) {
            Schema::table('sekolah_binaans', function (Blueprint $table) {
                $table->string('nama_kepsek')->nullable()->after('nama_sekolah');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('sekolah_binaans', 'nama_kepsek')) {
            Schema::table('sekolah_binaans', function (Blueprint $table) {
                $table->dropColumn('nama_kepsek');
            });
        }
    }
};
