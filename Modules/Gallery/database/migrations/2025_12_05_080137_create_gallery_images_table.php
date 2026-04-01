<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gallery_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gallery_id')->constrained()->onDelete('cascade');
            
            $table->string('image_path');
            $table->string('thumbnail_path')->nullable();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->text('alt_text')->nullable();
            
            $table->integer('order')->default(0);
            $table->boolean('is_featured')->default(false);
            
            $table->integer('width')->nullable();
            $table->integer('height')->nullable();
            $table->integer('file_size')->nullable();
            
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable();
            
            $table->timestamps();
            
            // Indexes
            $table->index('gallery_id');
            $table->index('order');
            $table->index('is_featured');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gallery_images');
    }
};
