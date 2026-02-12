<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Reduce varchar(255) columns to appropriate sizes.
     */
    public function up(): void
    {
        Schema::table('patient_profiles', function (Blueprint $table) {
            $table->string('nama', 100)->nullable()->change();
            $table->string('nik', 16)->nullable()->change();
            $table->string('suku_bangsa', 50)->nullable()->change();
            $table->string('agama', 20)->nullable()->change();
            $table->string('nomor_telepon', 20)->nullable()->change();
            $table->string('rt', 5)->nullable()->change();
            $table->string('rw', 5)->nullable()->change();
            $table->string('desa_kelurahan', 50)->nullable()->change();
            $table->string('pendidikan_terakhir', 50)->nullable()->change();
            $table->string('pekerjaan_pasien', 100)->nullable()->change();
            $table->string('pekerjaan_suami', 100)->nullable()->change();
            $table->string('perkawinan_pasangan', 30)->nullable()->change();
        });

        Schema::table('breast_exams', function (Blueprint $table) {
            $table->string('benjolan_ukuran', 50)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patient_profiles', function (Blueprint $table) {
            $table->string('nama')->nullable()->change();
            $table->string('nik')->nullable()->change();
            $table->string('suku_bangsa')->nullable()->change();
            $table->string('agama')->nullable()->change();
            $table->string('nomor_telepon')->nullable()->change();
            $table->string('rt')->nullable()->change();
            $table->string('rw')->nullable()->change();
            $table->string('desa_kelurahan')->nullable()->change();
            $table->string('pendidikan_terakhir')->nullable()->change();
            $table->string('pekerjaan_pasien')->nullable()->change();
            $table->string('pekerjaan_suami')->nullable()->change();
            $table->string('perkawinan_pasangan')->nullable()->change();
        });

        Schema::table('breast_exams', function (Blueprint $table) {
            $table->string('benjolan_ukuran')->nullable()->change();
        });
    }
};
