<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasTable('suppliers')) {
            return;
        }

        Schema::table('suppliers', function (Blueprint $table) {
            if (! Schema::hasColumn('suppliers', 'contact_person')) {
                $table->string('contact_person')->after('company_name');
            }

            if (! Schema::hasColumn('suppliers', 'email')) {
                $table->string('email')->nullable()->after('phone');
            }

            if (! Schema::hasColumn('suppliers', 'business_type')) {
                $table->string('business_type')->nullable()->after('address');
            }

            if (! Schema::hasColumn('suppliers', 'trade_license')) {
                $table->string('trade_license')->nullable()->after('business_type');
            }

            if (! Schema::hasColumn('suppliers', 'status')) {
                $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending')->after('trade_license');
            }

            if (! Schema::hasColumn('suppliers', 'approved_by')) {
                $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete()->after('status');
            }

            if (! Schema::hasColumn('suppliers', 'approved_at')) {
                $table->timestamp('approved_at')->nullable()->after('approved_by');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasTable('suppliers')) {
            return;
        }

        Schema::table('suppliers', function (Blueprint $table) {
            $columns = ['approved_at', 'approved_by', 'status', 'trade_license', 'business_type', 'email', 'contact_person'];

            foreach ($columns as $column) {
                if (Schema::hasColumn('suppliers', $column)) {
                    if ($column === 'approved_by') {
                        $table->dropConstrainedForeignId($column);
                    } else {
                        $table->dropColumn($column);
                    }
                }
            }
        });
    }
};
