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
        Schema::create('sponsors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('svg');
            $table->string('link');
            $table->integer('position')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Carry over the sponsors that were previously hardcoded in config/sponsors.php
        // so the sponsor bar keeps working once the layout switches to reading from the DB.
        $now = now();
        foreach (config('sponsors.list', []) as $i => $sponsor) {
            DB::table('sponsors')->insert([
                'name'       => $sponsor['name'],
                'svg'        => $sponsor['svg'],
                'link'       => $sponsor['url'],
                'position'   => $i,
                'is_active'  => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sponsors');
    }
};
