<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->char('user_id', 36)->nullable();
            $table->enum('type', ['sms', 'email', 'whatsapp']);
            $table->string('recipient', 255);
            $table->string('subject', 255)->nullable();
            $table->text('body');
            $table->enum('status', ['pending', 'sent', 'failed'])->default('pending');
            $table->timestamp('sent_at')->nullable();
            $table->text('error_message')->nullable();
            $table->timestamps();

            $table->foreign('user_id', 'fk_notifications_user')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->index('status', 'idx_notification_status');
            $table->index('sent_at', 'idx_notification_sent_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};