<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('property_subscriptions', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->char('property_id', 36)->unique();
            $table->enum('plan', ['starter', 'pro', 'enterprise'])->default('starter');
            $table->string('billing_email', 255);
            $table->enum('status', ['active', 'expired', 'cancelled'])->default('active');
            $table->date('renewal_date');
            $table->timestamps();

            $table->foreign('property_id', 'fk_subscriptions_property')
                ->references('id')
                ->on('properties')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->index('status', 'idx_subscription_status');
            $table->index('renewal_date', 'idx_subscription_renewal_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('property_subscriptions');
    }
};