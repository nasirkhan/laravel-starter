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
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->nullable()->index()->after('id');
            $table->string('first_name')->nullable()->after('name');
            $table->string('last_name')->nullable()->after('first_name');

            $table->string('mobile')->nullable()->after('password');
            $table->string('gender')->nullable()->after('mobile');
            $table->date('date_of_birth')->nullable()->after('gender');
            $table->text('address')->nullable()->after('date_of_birth');
            $table->text('bio')->nullable()->after('address');
            $table->json('social_profiles')->nullable()->after('bio');
            $table->string('avatar')->nullable()->after('social_profiles');

            $table->string('last_ip')->nullable()->after('avatar');
            $table->integer('login_count')->default(0)->after('last_ip');
            $table->timestamp('last_login')->nullable()->after('login_count');

            $table->tinyInteger('status')->default(1)->unsigned()->after('last_login');

            $table->integer('created_by')->unsigned()->nullable()->after('status');
            $table->integer('updated_by')->unsigned()->nullable()->after('created_by');
            $table->integer('deleted_by')->unsigned()->nullable()->after('updated_by');

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['username', 'first_name', 'last_name', 'mobile', 'gender', 'date_of_birth', 'address', 'bio', 'social_profiles', 'avatar', 'status', 'created_by', 'updated_by', 'deleted_by', 'deleted_at']);
        });
    }
};
