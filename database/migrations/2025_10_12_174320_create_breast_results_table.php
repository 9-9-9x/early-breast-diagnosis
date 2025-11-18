<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('breast_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('breast_exam_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('prediction');
            $table->boolean('sadari_bulanan')->default(0);
            $table->boolean('periksa_tahunan')->default(0);
            $table->boolean('mammografi_40_plus')->default(0);
            $table->boolean('rujuk_lanjutan')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('breast_results');
    }
};
