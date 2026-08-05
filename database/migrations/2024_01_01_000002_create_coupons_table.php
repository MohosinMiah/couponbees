<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('code')->nullable();
            $table->text('description')->nullable();
            $table->enum('type', ['code', 'deal'])->default('code');
            $table->string('discount_value')->nullable();
            $table->enum('discount_type', ['percentage', 'fixed', 'free_shipping', 'other'])->default('percentage');
            $table->date('expires_at')->nullable();
            $table->boolean('is_verified')->default(true);
            $table->boolean('is_exclusive')->default(false);
            $table->unsignedInteger('copy_count')->default(0);
            $table->unsignedInteger('success_count')->default(0);
            $table->unsignedInteger('failure_count')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
