<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('promo_codes', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->char('property_id', 36);
            $table->string('code', 50);
            $table->enum('discount_type', ['percentage', 'fixed_amount']);
            $table->decimal('discount_value', 10, 2);
            $table->integer('max_uses')->default(999);
            $table->integer('used_count')->default(0);
            $table->timestamp('valid_from')->nullable();
            $table->timestamp('valid_until');
            $table->enum('status', ['active', 'expired'])->default('active');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('property_id', 'fk_promo_codes_property')
                ->references('id')
                ->on('properties')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->index('code', 'idx_promo_code');
            $table->index('status', 'idx_promo_status');
            $table->index('valid_until', 'idx_promo_valid_until');
            $table->index(['property_id', 'code', 'deleted_at'], 'uniq_promo_code_per_property');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('promo_codes');
    }
};