<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patient_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nama')->nullable();
            $table->integer('umur')->nullable();
            $table->string('suku_bangsa')->nullable();
            $table->string('agama')->nullable();
            $table->decimal('bb', 5, 2)->nullable();
            $table->decimal('tb', 5, 2)->nullable();
            $table->integer('jumlah_anak_kandung')->nullable();
            $table->string('nomor_telepon')->nullable();
            $table->text('alamat')->nullable();
            $table->string('rt')->nullable();
            $table->string('rw')->nullable();
            $table->string('desa_kelurahan')->nullable();
            $table->string('pendidikan_terakhir')->nullable();
            $table->string('pekerjaan_pasien')->nullable();
            $table->string('pekerjaan_suami')->nullable();
            $table->string('perkawinan_pasangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patient_profiles');
    }
};
