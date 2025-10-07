<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            
            // The user who performed the action.
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // The type of model that was changed (e.g., 'App\Models\Family', 'App\Models\Charge').
            $table->string('auditable_type');
            
            // The ID of the specific record that was changed in its original table.
            $table->unsignedBigInteger('auditable_id');
            
            // This index is key for performance, allowing you to quickly find all changes for a specific record.
            $table->index(['auditable_type', 'auditable_id']);
            
            // The type of action that occurred (e.g., 'created', 'updated', 'deleted', 'processed').
            $table->string('action');
            
            // The original values of the data before the change. Nullable because some actions (like deletion) don't have old values.
            $table->json('old_values')->nullable();
            
            // The new values of the data after the change. Nullable for actions like deletion.
            $table->json('new_values')->nullable();
            
            // Laravel's built-in timestamps for created_at and updated_at.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
