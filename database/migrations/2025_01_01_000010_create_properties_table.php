<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->char('owner_id', 36);
            $table->string('slug', 100)->unique();
            $table->string('name', 255);
            $table->text('location')->nullable();
            $table->string('city', 100)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('iban', 34)->nullable();
            $table->string('registration_num', 50)->nullable();
            $table->integer('num_rooms')->nullable();
            $table->integer('num_floors')->nullable();
            $table->decimal('stars_rating', 3, 1)->nullable();
            $table->longText('description')->nullable();
            $table->string('timezone', 50)->default('Africa/Casablanca');
            $table->char('currency_code', 3)->default('MAD');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->string('logo_path', 255)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('owner_id', 'fk_properties_owner')
                ->references('id')
                ->on('users')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->index('slug', 'idx_property_slug');
            $table->index('status', 'idx_property_status');
            $table->index(['slug', 'deleted_at'], 'uniq_property_slug_deleted');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};