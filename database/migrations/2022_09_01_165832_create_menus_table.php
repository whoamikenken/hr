<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->integer('menu_id')->nullable();
            $table->string('root', 20)->nullable()->default('NULL');
            $table->string('title', 20)->nullable()->default('NULL');
            $table->string('link', 50)->nullable()->default('NULL');
            $table->string('description', 100)->nullable()->default('NULL');
            $table->string('icon', 40)->nullable()->default('<i class="bi bi-motherboard"></i>');
            $table->string('status', 20)->nullable()->default('show');
            $table->integer('order')->nullable();
            $table->timestamp('updated_at')->nullable()->useCurrent();
            $table->timestamp('created_at')->nullable()->useCurrent();
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
