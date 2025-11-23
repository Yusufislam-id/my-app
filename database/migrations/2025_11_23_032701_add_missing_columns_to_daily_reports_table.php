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
        Schema::table('daily_reports', function (Blueprint $table) {
            if (!Schema::hasColumn('daily_reports', 'company_id')) {
                $table->foreignId('company_id')->after('id')->constrained()->cascadeOnDelete();
            }
            if (!Schema::hasColumn('daily_reports', 'housing_location_id')) {
                $table->foreignId('housing_location_id')->after('company_id')->constrained()->cascadeOnDelete();
            }
            if (!Schema::hasColumn('daily_reports', 'created_by')) {
                $table->foreignId('created_by')->after('housing_location_id')->constrained('users')->cascadeOnDelete();
            }
            if (!Schema::hasColumn('daily_reports', 'report_type')) {
                $table->string('report_type')->after('created_by');
            }
            if (!Schema::hasColumn('daily_reports', 'report_date')) {
                $table->date('report_date')->after('report_type');
            }
            if (!Schema::hasColumn('daily_reports', 'file_path')) {
                $table->string('file_path')->nullable()->after('report_date');
            }
            if (!Schema::hasColumn('daily_reports', 'notes')) {
                $table->text('notes')->nullable()->after('file_path');
            }
            if (!Schema::hasColumn('daily_reports', 'status')) {
                $table->enum('status', ['draft', 'submitted', 'reviewed', 'approved', 'rejected'])->default('draft')->after('notes');
            }
            if (!Schema::hasColumn('daily_reports', 'deleted_at')) {
                $table->softDeletes();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('daily_reports', function (Blueprint $table) {
            if (Schema::hasColumn('daily_reports', 'deleted_at')) {
                $table->dropSoftDeletes();
            }
            if (Schema::hasColumn('daily_reports', 'status')) {
                $table->dropColumn('status');
            }
            if (Schema::hasColumn('daily_reports', 'notes')) {
                $table->dropColumn('notes');
            }
            if (Schema::hasColumn('daily_reports', 'file_path')) {
                $table->dropColumn('file_path');
            }
            if (Schema::hasColumn('daily_reports', 'report_date')) {
                $table->dropColumn('report_date');
            }
            if (Schema::hasColumn('daily_reports', 'report_type')) {
                $table->dropColumn('report_type');
            }
            if (Schema::hasColumn('daily_reports', 'created_by')) {
                $table->dropForeign(['created_by']);
                $table->dropColumn('created_by');
            }
            if (Schema::hasColumn('daily_reports', 'housing_location_id')) {
                $table->dropForeign(['housing_location_id']);
                $table->dropColumn('housing_location_id');
            }
            if (Schema::hasColumn('daily_reports', 'company_id')) {
                $table->dropForeign(['company_id']);
                $table->dropColumn('company_id');
            }
        });
    }
};
