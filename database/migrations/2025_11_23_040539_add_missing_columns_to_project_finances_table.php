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
        Schema::table('project_finances', function (Blueprint $table) {
            if (!Schema::hasColumn('project_finances', 'company_id')) {
                $table->foreignId('company_id')->after('id')->constrained()->cascadeOnDelete();
            }
            if (!Schema::hasColumn('project_finances', 'housing_location_id')) {
                $table->foreignId('housing_location_id')->after('company_id')->constrained()->cascadeOnDelete();
            }
            if (!Schema::hasColumn('project_finances', 'created_by')) {
                $table->foreignId('created_by')->after('housing_location_id')->constrained('users')->cascadeOnDelete();
            }
            if (!Schema::hasColumn('project_finances', 'finance_type')) {
                $table->string('finance_type')->after('created_by');
            }
            if (!Schema::hasColumn('project_finances', 'report_date')) {
                $table->date('report_date')->after('finance_type');
            }
            if (!Schema::hasColumn('project_finances', 'laporan_keuangan_file')) {
                $table->string('laporan_keuangan_file')->nullable()->after('report_date');
            }
            if (!Schema::hasColumn('project_finances', 'petty_cash_file')) {
                $table->string('petty_cash_file')->nullable()->after('laporan_keuangan_file');
            }
            if (!Schema::hasColumn('project_finances', 'data_konsumen_file')) {
                $table->string('data_konsumen_file')->nullable()->after('petty_cash_file');
            }
            if (!Schema::hasColumn('project_finances', 'data_pembayaran_file')) {
                $table->string('data_pembayaran_file')->nullable()->after('data_konsumen_file');
            }
            if (!Schema::hasColumn('project_finances', 'data_konsumen_reject_file')) {
                $table->string('data_konsumen_reject_file')->nullable()->after('data_pembayaran_file');
            }
            if (!Schema::hasColumn('project_finances', 'sp3k_dokumen_file')) {
                $table->string('sp3k_dokumen_file')->nullable()->after('data_konsumen_reject_file');
            }
            if (!Schema::hasColumn('project_finances', 'pencairan_kpr_file')) {
                $table->string('pencairan_kpr_file')->nullable()->after('sp3k_dokumen_file');
            }
            if (!Schema::hasColumn('project_finances', 'biaya_material_tenaga_file')) {
                $table->string('biaya_material_tenaga_file')->nullable()->after('pencairan_kpr_file');
            }
            if (!Schema::hasColumn('project_finances', 'total_amount')) {
                $table->decimal('total_amount', 15, 2)->nullable()->after('biaya_material_tenaga_file');
            }
            if (!Schema::hasColumn('project_finances', 'notes')) {
                $table->text('notes')->nullable()->after('total_amount');
            }
            if (!Schema::hasColumn('project_finances', 'status')) {
                $table->enum('status', ['draft', 'submitted', 'reviewed', 'approved', 'rejected'])->default('draft')->after('notes');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('project_finances', function (Blueprint $table) {
            if (Schema::hasColumn('project_finances', 'status')) {
                $table->dropColumn('status');
            }
            if (Schema::hasColumn('project_finances', 'notes')) {
                $table->dropColumn('notes');
            }
            if (Schema::hasColumn('project_finances', 'total_amount')) {
                $table->dropColumn('total_amount');
            }
            if (Schema::hasColumn('project_finances', 'biaya_material_tenaga_file')) {
                $table->dropColumn('biaya_material_tenaga_file');
            }
            if (Schema::hasColumn('project_finances', 'pencairan_kpr_file')) {
                $table->dropColumn('pencairan_kpr_file');
            }
            if (Schema::hasColumn('project_finances', 'sp3k_dokumen_file')) {
                $table->dropColumn('sp3k_dokumen_file');
            }
            if (Schema::hasColumn('project_finances', 'data_konsumen_reject_file')) {
                $table->dropColumn('data_konsumen_reject_file');
            }
            if (Schema::hasColumn('project_finances', 'data_pembayaran_file')) {
                $table->dropColumn('data_pembayaran_file');
            }
            if (Schema::hasColumn('project_finances', 'data_konsumen_file')) {
                $table->dropColumn('data_konsumen_file');
            }
            if (Schema::hasColumn('project_finances', 'petty_cash_file')) {
                $table->dropColumn('petty_cash_file');
            }
            if (Schema::hasColumn('project_finances', 'laporan_keuangan_file')) {
                $table->dropColumn('laporan_keuangan_file');
            }
            if (Schema::hasColumn('project_finances', 'report_date')) {
                $table->dropColumn('report_date');
            }
            if (Schema::hasColumn('project_finances', 'finance_type')) {
                $table->dropColumn('finance_type');
            }
            if (Schema::hasColumn('project_finances', 'created_by')) {
                $table->dropForeign(['created_by']);
                $table->dropColumn('created_by');
            }
            if (Schema::hasColumn('project_finances', 'housing_location_id')) {
                $table->dropForeign(['housing_location_id']);
                $table->dropColumn('housing_location_id');
            }
            if (Schema::hasColumn('project_finances', 'company_id')) {
                $table->dropForeign(['company_id']);
                $table->dropColumn('company_id');
            }
        });
    }
};
