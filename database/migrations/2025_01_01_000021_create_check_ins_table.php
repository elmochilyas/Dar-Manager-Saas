<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('check_ins', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->char('reservation_id', 36)->unique();
            $table->timestamp('checked_in_at');
            $table->char('receptionist_id', 36);
            $table->enum('id_type', ['cin', 'passport'])->nullable();
            $table->string('id_scan_path', 255)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('reservation_id', 'fk_check_ins_reservation')
                ->references('id')
                ->on('reservations')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('receptionist_id', 'fk_check_ins_receptionist')
                ->references('id')
                ->on('users')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->index('checked_in_at', 'idx_checked_in_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('check_ins');
    }
};