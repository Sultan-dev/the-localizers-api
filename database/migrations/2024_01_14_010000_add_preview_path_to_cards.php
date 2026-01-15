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
        Schema::table('cards', function (Blueprint $table) {
            // Add preview_path column if it doesn't exist
            if (!Schema::hasColumn('cards', 'preview_path')) {
                $table->string('preview_path')->nullable()->after('preview_url');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cards', function (Blueprint $table) {
            if (Schema::hasColumn('cards', 'preview_path')) {
                $table->dropColumn('preview_path');
            }
        });
    }
};
