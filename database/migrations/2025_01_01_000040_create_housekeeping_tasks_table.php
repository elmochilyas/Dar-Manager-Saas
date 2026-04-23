<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('housekeeping_tasks', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->char('property_id', 36);
            $table->char('room_id', 36);
            $table->enum('task_type', ['clean', 'inspect', 'repair', 'stock_refresh']);
            $table->enum('status', ['pending', 'in_progress', 'completed', 'blocked'])->default('pending');
            $table->char('assigned_to', 36)->nullable();
            $table->char('assigned_by', 36);
            $table->enum('priority', ['urgent', 'normal', 'low'])->default('normal');
            $table->timestamp('due_date');
            $table->timestamp('completed_at')->nullable();
            $table->text('notes')->nullable();
            $table->string('photo_path', 255)->nullable();
            $table->timestamps();

            $table->foreign('property_id', 'fk_housekeeping_property')
                ->references('id')
                ->on('properties')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('room_id', 'fk_housekeeping_room')
                ->references('id')
                ->on('rooms')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('assigned_to', 'fk_housekeeping_assigned_to')
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('assigned_by', 'fk_housekeeping_assigned_by')
                ->references('id')
                ->on('users')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->index('status', 'idx_housekeeping_status');
            $table->index('due_date', 'idx_housekeeping_due_date');
            $table->index('priority', 'idx_housekeeping_priority');
            $table->index('completed_at', 'idx_housekeeping_completed_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('housekeeping_tasks');
    }
};