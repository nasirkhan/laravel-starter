<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();

            // Basic Information
            $table->string('name'); // e.g., "Header Menu", "Footer Menu", "Admin Sidebar"
            $table->string('slug')->unique(); // e.g., "header-menu", "footer-menu"
            $table->text('description')->nullable(); // Description of the menu purpose

            // Location & Display
            $table->string('location'); // e.g., "header", "footer", "sidebar", "mobile"
            $table->string('theme')->default('default'); // Theme variant (if multiple themes)
            $table->text('css_classes')->nullable(); // CSS classes for the menu container
            $table->json('settings')->nullable(); // Additional menu settings (max_depth, etc.)

            // Access Control (for the entire menu group)
            $table->json('permissions')->nullable(); // Required permissions to see this menu
            $table->json('roles')->nullable(); // Required roles to see this menu
            $table->boolean('is_public')->default(true); // Can guests see this menu?

            // Status & Visibility
            $table->boolean('is_active')->default(true);
            $table->boolean('is_visible')->default(true);

            // Multi-language Support
            $table->string('locale')->nullable();

            // Metadata
            $table->text('note')->nullable(); // Admin notes
            $table->tinyInteger('status')->default(1); // 0=disabled, 1=enabled, 2=draft

            // Audit Fields
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->integer('deleted_by')->unsigned()->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index(['location', 'is_active']);
            $table->index(['locale']);
            $table->index(['is_public', 'is_visible']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menus');
    }
};
