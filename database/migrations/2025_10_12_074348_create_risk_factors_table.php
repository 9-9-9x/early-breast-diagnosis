<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('risk_factors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->boolean('pernah_menyusui')->default(false);
            $table->boolean('pernah_melahirkan')->default(false);
            $table->boolean('melahirkan_lebih_4_kali')->default(false);
            $table->boolean('kb_hormonal_pil_lebih_5_tahun')->default(false);
            $table->boolean('kb_hormonal_suntik_lebih_5_tahun')->default(false);
            $table->boolean('riwayat_tumor_jinak_payudara')->default(false);
            $table->boolean('menopause_lebih_50_tahun')->default(false);
            $table->boolean('obesitas_imt_lebih_27')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('risk_factors');
    }
};
