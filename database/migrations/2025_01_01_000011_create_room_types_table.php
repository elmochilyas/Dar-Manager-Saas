<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('room_types', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->char('property_id', 36);
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->integer('capacity');
            $table->decimal('base_price', 10, 2);
            $table->json('amenities')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('property_id', 'fk_room_types_property')
                ->references('id')
                ->on('properties')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            });
    }

    public function down(): void
    {
        Schema::dropIfExists('room_types');
    }
};