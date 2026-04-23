<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fiche_de_police_records', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->char('reservation_id', 36);
            $table->char('guest_id', 36);
            $table->char('property_id', 36);
            $table->string('fiche_number', 100)->unique();
            $table->timestamp('issued_date');
            $table->json('data');
            $table->string('pdf_path', 255)->nullable();
            $table->enum('status', ['pending', 'submitted', 'archived'])->default('pending');
            $table->timestamps();

            $table->foreign('reservation_id', 'fk_fiche_reservation')
                ->references('id')
                ->on('reservations')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('guest_id', 'fk_fiche_guest')
                ->references('id')
                ->on('guests')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('property_id', 'fk_fiche_property')
                ->references('id')
                ->on('properties')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->index('issued_date', 'idx_fiche_issued_date');
            $table->index('status', 'idx_fiche_status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fiche_de_police_records');
    }
};