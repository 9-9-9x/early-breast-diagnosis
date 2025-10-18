<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('breast_exams', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Kolom untuk Kulit (P1-P5)
            $table->boolean('kulit_normal')->default(0);
            $table->boolean('kulit_abnormal')->default(0);
            $table->boolean('kulit_jeruk')->default(0);
            $table->boolean('penarikan_kulit')->default(0);
            $table->boolean('luka_basah_kulit')->default(0);
            
            // Kolom untuk Areola/Papilla (P6-P10)
            $table->boolean('areola_normal')->default(0);
            $table->boolean('areola_abnormal')->default(0);
            $table->boolean('retraksi')->default(0);
            $table->boolean('luka_basah_areola')->default(0);
            $table->boolean('cairan_abnormal')->default(0);
            
            // Kolom untuk Benjolan (P11)
            $table->boolean('benjolan_ya')->default(0);
            $table->boolean('benjolan_tidak')->default(0);
            $table->string('benjolan_ukuran')->nullable();
            
            // Keterangan (K) - gabungan ukuran, lokasi, bentuk kelainan
            $table->text('keterangan')->nullable();
            
            // Hasil Prediksi dari ML Model
            // $table->string('prediction')->nullable();
            // $table->float('probability_normal')->nullable();
            // $table->float('probability_jinak')->nullable();
            // $table->float('probability_ganas')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('breast_exams');
    }
};
