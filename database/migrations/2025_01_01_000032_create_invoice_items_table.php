<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->char('invoice_id', 36);
            $table->string('description', 255);
            $table->decimal('quantity', 10, 2);
            $table->decimal('unit_price', 10, 2);
            $table->decimal('subtotal', 10, 2)->storedAs('quantity * unit_price');
            $table->timestamps();

            $table->foreign('invoice_id', 'fk_invoice_items_invoice')
                ->references('id')
                ->on('invoices')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoice_items');
    }
};