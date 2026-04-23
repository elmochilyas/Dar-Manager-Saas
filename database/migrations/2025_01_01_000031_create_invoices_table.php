<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->char('property_id', 36);
            $table->char('reservation_id', 36);
            $table->char('guest_id', 36);
            $table->string('invoice_number', 50);
            $table->decimal('total_ht', 10, 2);
            $table->decimal('tva_amount', 10, 2);
            $table->decimal('total_ttc', 10, 2);
            $table->enum('status', ['draft', 'finalized', 'paid', 'cancelled'])->default('draft');
            $table->date('issued_date');
            $table->date('due_date')->nullable();
            $table->timestamp('paid_date')->nullable();
            $table->string('signature', 255)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('property_id', 'fk_invoices_property')
                ->references('id')
                ->on('properties')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('reservation_id', 'fk_invoices_reservation')
                ->references('id')
                ->on('reservations')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('guest_id', 'fk_invoices_guest')
                ->references('id')
                ->on('guests')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->index('invoice_number', 'idx_invoice_number');
            $table->index('status', 'idx_invoice_status');
            $table->index('issued_date', 'idx_invoice_issued_date');
            $table->index(['property_id', 'invoice_number'], 'uniq_invoice_per_property');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};