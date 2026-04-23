<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pricing_rules', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->char('property_id', 36);
            $table->char('room_type_id', 36)->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->string('day_of_week', 3)->nullable();
            $table->decimal('price_override', 10, 2)->nullable();
            $table->decimal('discount_percent', 5, 2)->nullable();
            $table->integer('min_stay')->nullable();
            $table->integer('max_stay')->nullable();
            $table->timestamps();

            $table->foreign('property_id', 'fk_pricing_rules_property')
                ->references('id')
                ->on('properties')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('room_type_id', 'fk_pricing_rules_type')
                ->references('id')
                ->on('room_types')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->index(['start_date', 'end_date'], 'idx_pricing_dates');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pricing_rules');
    }
};