<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Modify the enum to include 'super_admin'
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('founder', 'direktur', 'komisaris', 'admin_pemberkasan', 'admin_keuangan', 'super_admin')");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to original enum values
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('founder', 'direktur', 'komisaris', 'admin_pemberkasan', 'admin_keuangan')");
    }
};
