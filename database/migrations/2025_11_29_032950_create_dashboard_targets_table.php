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
        Schema::create('dashboard_targets', function (Blueprint $table) {
            $table->id();
            $table->string('name')->default('Ca Mamae'); // Nama target
            $table->integer('sasaran')->default(0); // Sasaran total
            $table->integer('target')->default(0); // Target yang ingin dicapai
            $table->year('tahun')->default(date('Y')); // Tahun target
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dashboard_targets');
    }
};
