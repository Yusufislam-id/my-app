<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->string('nama_lengkap');
            $table->text('deskripsi')->nullable();
            
            // File paths - semua nullable karena tidak semua file wajib
            $table->string('surat_pengajuan_rumah')->nullable();
            $table->string('dokumen_ktp')->nullable();
            $table->string('dokumen_kk')->nullable();
            $table->string('dokumen_npwp')->nullable();
            $table->string('surat_keterangan_kerja')->nullable();
            $table->string('slip_gaji_3bulan')->nullable();
            $table->string('rekening_koran_3bulan')->nullable();
            $table->string('surat_keterangan_usaha')->nullable();
            $table->string('neraca_keuangan_6bulan')->nullable();
            
            $table->enum('status', ['draft', 'submitted', 'reviewed', 'approved', 'rejected'])->default('draft');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};