<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->char('property_id', 36);
            $table->char('guest_id', 36);
            $table->char('room_id', 36)->nullable();
            $table->date('check_in_date');
            $table->date('check_out_date');
            $table->integer('num_nights')->storedAs('DATEDIFF(check_out_date, check_in_date)');
            $table->enum('status', ['pending', 'confirmed', 'checked_in', 'checked_out', 'cancelled'])->default('pending');
            $table->decimal('total_amount', 10, 2);
            $table->text('notes')->nullable();
            $table->enum('booking_channel', ['own', 'booking_com', 'airbnb', 'walk_in'])->default('own');
            $table->enum('source', ['online', 'walk_in'])->default('online');
            $table->char('promo_code_id', 36)->nullable();
            $table->integer('version')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('property_id', 'fk_reservations_property')
                ->references('id')
                ->on('properties')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('guest_id', 'fk_reservations_guest')
                ->references('id')
                ->on('guests')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('room_id', 'fk_reservations_room')
                ->references('id')
                ->on('rooms')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('promo_code_id', 'fk_reservations_promo')
                ->references('id')
                ->on('promo_codes')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->index('status', 'idx_reservation_status');
            $table->index('check_in_date', 'idx_reservation_check_in');
            $table->index('check_out_date', 'idx_reservation_check_out');
$table->index(['check_in_date', 'check_out_date', 'status'], 'idx_reservation_dates');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};