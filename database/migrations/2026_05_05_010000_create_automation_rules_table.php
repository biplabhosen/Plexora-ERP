<?php

use App\Models\AutomationRule;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('automation_rules', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('event', [
                AutomationRule::EVENT_ORDER_PLACED,
                AutomationRule::EVENT_RFQ_CREATED,
                AutomationRule::EVENT_STOCK_LOW,
            ]);
            $table->string('condition')->nullable();
            $table->enum('action', [
                AutomationRule::ACTION_SEND_EMAIL,
                AutomationRule::ACTION_NOTIFY_SUPPLIER,
                AutomationRule::ACTION_NOTIFY_ADMIN,
                AutomationRule::ACTION_LOG_ONLY,
            ]);
            $table->string('target')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['event', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('automation_rules');
    }
};
