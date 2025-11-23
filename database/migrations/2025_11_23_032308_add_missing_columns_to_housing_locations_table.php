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
        Schema::table('housing_locations', function (Blueprint $table) {
            if (!Schema::hasColumn('housing_locations', 'company_id')) {
                $table->foreignId('company_id')->after('id')->constrained()->cascadeOnDelete();
            }
            if (!Schema::hasColumn('housing_locations', 'name')) {
                $table->string('name')->after('company_id');
            }
            if (!Schema::hasColumn('housing_locations', 'code')) {
                $table->string('code')->unique()->after('name');
            }
            if (!Schema::hasColumn('housing_locations', 'address')) {
                $table->text('address')->nullable()->after('code');
            }
            if (!Schema::hasColumn('housing_locations', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('address');
            }
            if (!Schema::hasColumn('housing_locations', 'deleted_at')) {
                $table->softDeletes();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('housing_locations', function (Blueprint $table) {
            if (Schema::hasColumn('housing_locations', 'deleted_at')) {
                $table->dropSoftDeletes();
            }
            if (Schema::hasColumn('housing_locations', 'is_active')) {
                $table->dropColumn('is_active');
            }
            if (Schema::hasColumn('housing_locations', 'address')) {
                $table->dropColumn('address');
            }
            if (Schema::hasColumn('housing_locations', 'code')) {
                $table->dropColumn('code');
            }
            if (Schema::hasColumn('housing_locations', 'name')) {
                $table->dropColumn('name');
            }
            if (Schema::hasColumn('housing_locations', 'company_id')) {
                $table->dropForeign(['company_id']);
                $table->dropColumn('company_id');
            }
        });
    }
};
