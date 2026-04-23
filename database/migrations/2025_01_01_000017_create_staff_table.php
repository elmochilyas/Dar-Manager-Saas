<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->char('property_id', 36);
            $table->char('user_id', 36);
            $table->date('hire_date');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->decimal('salary', 10, 2)->nullable();
            $table->string('phone', 20)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('property_id', 'fk_staff_property')
                ->references('id')
                ->on('properties')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('user_id', 'fk_staff_user')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->index('status', 'idx_staff_status');
            $table->index(['property_id', 'user_id'], 'uniq_staff_per_property');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};