<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->char('property_id', 36);
            $table->char('room_type_id', 36);
            $table->string('room_number', 50);
            $table->integer('floor')->nullable();
            $table->enum('status', ['available', 'occupied', 'maintenance', 'blocked'])->default('available');
            $table->timestamp('last_housekeeping_at')->nullable();
            $table->string('maintenance_reason', 255)->nullable();
            $table->timestamp('maintenance_until')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('property_id', 'fk_rooms_property')
                ->references('id')
                ->on('properties')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('room_type_id', 'fk_rooms_type')
                ->references('id')
                ->on('room_types')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->index(['property_id', 'room_number', 'deleted_at'], 'uniq_room_per_property');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};