<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Add indexes to users table for improved query performance.
     * Note: username already has index from add_profile_columns migration.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Index for authentication queries
            $table->index('email');

            // Indexes for foreign keys (audit trail)
            $table->index('created_by');
            $table->index('updated_by');
            $table->index('deleted_by');

            // Indexes for frequently queried columns
            $table->index('status'); // Filter active users
            $table->index('last_login'); // Sort by last login
            $table->index('email_verified_at'); // Filter verified users

            // Composite index for common query (status + last_login)
            $table->index(['status', 'last_login'], 'users_status_login_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop composite index
            $table->dropIndex('users_status_login_index');

            // Drop single column indexes
            $table->dropIndex(['email']);
            $table->dropIndex(['created_by']);
            $table->dropIndex(['updated_by']);
            $table->dropIndex(['deleted_by']);
            $table->dropIndex(['status']);
            $table->dropIndex(['last_login']);
            $table->dropIndex(['email_verified_at']);
        });
    }
};
