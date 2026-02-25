<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Add indexes to user_providers table for improved query performance.
     * user_id already has a FK constraint but benefits from an explicit index here.
     */
    public function up(): void
    {
        Schema::table('user_providers', function (Blueprint $table) {
            // Index for lookups by user (e.g. list a user's linked providers)
            $table->index('user_id');

            // Index for OAuth callback lookups by provider + provider_id
            $table->index(['provider', 'provider_id'], 'user_providers_provider_provider_id_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_providers', function (Blueprint $table) {
            $table->dropIndex('user_providers_provider_provider_id_index');
            $table->dropIndex(['user_id']);
        });
    }
};
