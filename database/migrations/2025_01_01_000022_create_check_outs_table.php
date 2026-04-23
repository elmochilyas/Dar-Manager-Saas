<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('check_outs', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->char('reservation_id', 36)->unique();
            $table->timestamp('checked_out_at');
            $table->char('housekeeper_id', 36)->nullable();
            $table->enum('room_condition', ['good', 'needs_minor_repair', 'dirty', 'severely_damaged'])->default('good');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('reservation_id', 'fk_check_outs_reservation')
                ->references('id')
                ->on('reservations')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('housekeeper_id', 'fk_check_outs_housekeeper')
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->index('checked_out_at', 'idx_checked_out_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('check_outs');
    }
};