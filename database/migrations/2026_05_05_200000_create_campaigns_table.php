<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('campaigns', function (Blueprint $table): void {
            $table->id();
            $table->enum('type', ['marketing', 'social']);
            $table->enum('channel', ['email', 'sms', 'facebook', 'instagram']);
            $table->string('name');
            $table->string('audience')->nullable();
            $table->string('subject')->nullable();
            $table->text('content');
            $table->string('media_path')->nullable();
            $table->dateTime('scheduled_at')->nullable()->index();
            $table->enum('status', ['draft', 'scheduled', 'processing', 'sent', 'failed'])->default('draft')->index();
            $table->string('trigger_event')->nullable()->index();
            $table->boolean('is_active')->default(true)->index();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('campaigns');
    }
};
