<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->char('reservation_id', 36);
            $table->decimal('amount', 10, 2);
            $table->enum('method', ['cash', 'card', 'virement']);
            $table->string('transaction_id', 255)->nullable();
            $table->enum('status', ['pending', 'completed', 'failed', 'refunded'])->default('pending');
            $table->timestamp('paid_at')->nullable();
            $table->string('reference', 255)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('reservation_id', 'fk_payments_reservation')
                ->references('id')
                ->on('reservations')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->index('method', 'idx_payment_method');
            $table->index('status', 'idx_payment_status');
            $table->index('paid_at', 'idx_payment_paid_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};