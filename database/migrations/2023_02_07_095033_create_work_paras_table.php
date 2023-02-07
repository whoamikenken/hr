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
        Schema::create('work_paras', function (Blueprint $table) {
            $table->id();
            $table->string('description', 20)->nullable();
            $table->string('latitude', 50)->nullable();
            $table->string('longitude', 50)->nullable();
            $table->timestamp('updated_at')->nullable()->useCurrent();
            $table->string('updated_by', 50)->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->string('created_by', 50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('work_paras');
    }
};
