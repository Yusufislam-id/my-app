<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('financial_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->string('periode'); // Contoh: "2024-01" atau "Q1-2024"
            
            // File paths untuk dokumen keuangan
            $table->string('laporan_keuangan_pt')->nullable();
            $table->string('laporan_data_konsumen')->nullable();
            $table->string('sp3k')->nullable();
            $table->string('pengisian_data_myob')->nullable();
            $table->string('laporan_keuangan')->nullable();
            $table->string('laporan_kas_lapangan')->nullable();
            $table->string('laporan_kas_pt')->nullable();
            
            $table->text('catatan')->nullable();
            $table->enum('status', ['draft', 'submitted', 'reviewed', 'approved', 'rejected'])->default('draft');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('financial_reports');
    }
};