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
        Schema::table('contact', function (Blueprint $table) {
            $table->foreignId('contact_category_id')
                ->nullable()
                ->after('id')
                ->constrained('contact_categories')
                ->nullOnDelete();

            // Ticket-like workflow status.
            $table->enum('status', ['open', 'in_progress', 'closed'])
                ->default('open')
                ->after('message');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contact', function (Blueprint $table) {
            $table->dropForeign(['contact_category_id']);
            $table->dropColumn(['contact_category_id', 'status']);
        });
    }
};
