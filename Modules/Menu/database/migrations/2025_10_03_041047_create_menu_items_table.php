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
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();

            // Relationship
            $table->foreignId('menu_id')->constrained()->onDelete('cascade');
            $table->foreignId('parent_id')->nullable()->constrained('menu_items')->onDelete('cascade');

            // Basic Information
            $table->string('name'); // Display text
            $table->string('slug')->nullable(); // For URL generation
            $table->text('description')->nullable(); // Tooltip or description

            // Navigation Properties
            $table->string('type')->default('link'); // link, dropdown, divider, heading, external
            $table->string('url')->nullable(); // Direct URL
            $table->string('route_name')->nullable(); // Laravel route name
            $table->json('route_parameters')->nullable(); // Route parameters
            $table->boolean('opens_new_tab')->default(false); // Target _blank

            // Hierarchy & Ordering
            $table->integer('sort_order')->default(0);
            $table->integer('depth')->default(0); // For nested menus
            $table->string('path')->nullable(); // Materialized path for quick queries

            // Display Properties
            $table->string('icon')->nullable(); // Icon class (e.g., "fas fa-home")
            $table->string('badge_text')->nullable(); // Badge text (e.g., "New", "3")
            $table->string('badge_color')->nullable(); // Badge color class
            $table->text('css_classes')->nullable(); // Additional CSS classes
            $table->json('html_attributes')->nullable(); // Custom HTML attributes

            // Access Control (per menu item)
            $table->json('permissions')->nullable(); // Required permissions
            $table->json('roles')->nullable(); // Required roles

            // Conditional Display
            $table->boolean('is_visible')->default(true);
            $table->boolean('is_active')->default(true);

            // Multi-language Support
            $table->string('locale')->nullable();

            // SEO (for pages)
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();

            // Additional Data
            $table->json('custom_data')->nullable(); // Store custom properties
            $table->text('note')->nullable(); // Admin notes
            $table->tinyInteger('status')->default(1); // 0=disabled, 1=enabled, 2=draft

            // Audit Fields
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->integer('deleted_by')->unsigned()->nullable();

            $table->timestamps();
            $table->softDeletes();

            // // Indexes for Performance
            // $table->index(['menu_id', 'parent_id', 'sort_order']);
            // $table->index(['menu_id', 'is_visible', 'is_active']);
            // $table->index(['type', 'status']);
            // $table->index(['locale', 'translation_group']);
            // $table->index(['visible_from', 'visible_until']);
            // $table->index(['requires_auth', 'is_guest_accessible']);

            // // Composite index for hierarchy queries
            // $table->index(['menu_id', 'depth', 'path']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menu_items');
    }
};
