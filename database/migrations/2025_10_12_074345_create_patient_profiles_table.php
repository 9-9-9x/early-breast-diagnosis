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
            $table->string('nama');
            $table->integer('umur');
            $table->string('suku_bangsa')->nullable();
            $table->string('agama');
            $table->decimal('bb', 5, 2);
            $table->decimal('tb', 5, 2);
            $table->integer('jumlah_anak_kandung');
            $table->string('nomor_telepon');
            $table->text('alamat');
            $table->string('rt');
            $table->string('rw');
            $table->string('desa_kelurahan');
            $table->string('pendidikan_terakhir');
            $table->string('pekerjaan_pasien');
            $table->string('pekerjaan_suami')->nullable();
            $table->string('perkawinan_pasangan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patient_profiles');
    }
};
