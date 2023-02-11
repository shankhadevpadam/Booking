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
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->after('email')->nullable();
            $table->boolean('is_admin')->after('phone')->default(false);
            $table->string('type')->after('is_admin')->nullable();
            $table->integer('country_id')->after('type')->nullable();
            $table->string('token')->after('password')->nullable();
            $table->timestamp('approved_at')->after('email_verified_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone', 'is_admin', 'country_id', 'token', 'approved_at']);
        });
    }
};
