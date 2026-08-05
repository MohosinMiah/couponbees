<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * The `details` column was added to the live database outside of any
     * tracked migration and ended up NOT NULL with no default, which
     * crashes every store save that leaves it empty even though the
     * app (validation, model, views) has always treated it as optional.
     */
    public function up(): void
    {
        DB::statement('ALTER TABLE stores MODIFY details TEXT NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE stores MODIFY details TEXT NOT NULL DEFAULT ''");
    }
};
