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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('name');
            $table->string('fname');
            $table->string('lname');
            $table->string('gender')->nullable();
            $table->string('user_type');
            $table->string('status')->default('unverified');
            $table->string('email')->unique();
            $table->text('user_image')->nullable();
            $table->string('read', 250)->nullable();
            $table->string('add', 250)->nullable();
            $table->string('delete', 250)->nullable();
            $table->string('edit', 250)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->rememberToken();
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
};
