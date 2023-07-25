<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->string('name', 35);
            // $table->string('username', 35)->nullable();
            $table->string('email', 40)->unique();
            // $table->string('roles', 10)->nullable();

            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            $table->string('phone', 13)->nullable();
            $table->string('alamat')->nullable();

            $table->timestamp('last_seen')->nullable();

            $table->rememberToken();

            $table->foreignId('current_team_id')->nullable();
            $table->text('profile_photo_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
