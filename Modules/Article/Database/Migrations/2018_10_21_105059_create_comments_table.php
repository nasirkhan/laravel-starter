<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id')->unsigned();

            $table->string('name');
            $table->string('slug')->nullable();
            $table->text('comment')->nullable();

            $table->integer('post_id')->unsigned()->nullable();
            $table->string('post_name')->nullable();

            $table->integer('user_id')->unsigned()->nullable();
            $table->string('user_name')->nullable();

            $table->string('order')->nullable();
            $table->tinyInteger('status')->default(0);

            $table->integer('moderated_by')->unsigned()->nullable();
            $table->datetime('moderated_at')->nullable();

            $table->timestamp('published_at')->nullable();

            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->integer('deleted_by')->unsigned()->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
