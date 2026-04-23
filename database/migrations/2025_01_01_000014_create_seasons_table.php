<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seasons', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->char('property_id', 36);
            $table->string('name', 100);
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('multiplier', 3, 2);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('property_id', 'fk_seasons_property')
                ->references('id')
                ->on('properties')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->index(['start_date', 'end_date'], 'idx_season_dates');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seasons');
    }
};