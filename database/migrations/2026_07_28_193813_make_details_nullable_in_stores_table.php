<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * On some environments the `details` column was added to the database
     * outside of any tracked migration and ended up NOT NULL with no
     * default, which crashes every store save that leaves it empty even
     * though the app (validation, model, views) has always treated it as
     * optional. On environments migrating from scratch the column doesn't
     * exist yet, so create it nullable instead of altering it.
     */
    public function up(): void
    {
        if (Schema::hasColumn('stores', 'details')) {
            DB::statement('ALTER TABLE stores MODIFY details TEXT NULL');
        } else {
            Schema::table('stores', function (Blueprint $table) {
                $table->text('details')->nullable()->after('description');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('stores', 'details')) {
            Schema::table('stores', function (Blueprint $table) {
                $table->dropColumn('details');
            });
        }
    }
};
