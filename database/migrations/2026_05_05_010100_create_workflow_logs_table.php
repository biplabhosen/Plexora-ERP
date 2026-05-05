<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('workflow_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('automation_rule_id')->nullable()->constrained()->nullOnDelete();
            $table->string('event');
            $table->enum('status', ['success', 'failed']);
            $table->text('message')->nullable();
            $table->timestamps();

            $table->index(['event', 'status']);
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('workflow_logs');
    }
};
