<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pls', function (Blueprint $table) {
            // Ubah dari string ke bigInteger
            $table->bigInteger('kode_rup')->change();
        });
    }

    public function down(): void
    {
        Schema::table('pls', function (Blueprint $table) {
            // Kembalikan ke string jika rollback
            $table->string('kode_rup')->change();
        });
    }
};