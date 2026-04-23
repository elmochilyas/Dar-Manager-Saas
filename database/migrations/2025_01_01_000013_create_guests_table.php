<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('guests', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->char('property_id', 36);
            $table->string('email', 255);
            $table->string('phone', 20)->nullable();
            $table->string('full_name', 255);
            $table->string('cin', 255)->nullable();
            $table->string('passport_num', 255)->nullable();
            $table->string('nationality', 100)->nullable();
            $table->enum('gender', ['M', 'F', 'Other'])->nullable();
            $table->date('birth_date')->nullable();
            $table->text('address')->nullable();
            $table->boolean('is_repeat_guest')->default(false);
            $table->integer('loyalty_points')->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('property_id', 'fk_guests_property')
                ->references('id')
                ->on('properties')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->index('email', 'idx_email');
            $table->index('phone', 'idx_phone');
            $table->index(['property_id', 'cin', 'deleted_at'], 'uniq_cin_per_property');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guests');
    }
};