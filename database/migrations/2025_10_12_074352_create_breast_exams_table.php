<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('breast_exams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->boolean('payudara_kanan')->default(false);
            $table->boolean('payudara_kiri')->default(false);
            $table->string('kulit');
            $table->string('areola_papilla');
            $table->boolean('benjolan_tidak')->default(true);
            $table->boolean('benjolan_ya')->default(false);
            $table->string('benjolan_ukuran')->nullable();
            $table->string('bentuk_kelainan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('breast_exams');
    }
};
