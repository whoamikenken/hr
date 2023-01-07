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

        Schema::disableForeignKeyConstraints();

        Schema::dropIfExists('schedules');

        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->string('code', 40)->nullable();
            $table->string('description', 100)->nullable();
            $table->timestamp('updated_at')->nullable()->useCurrent();
            $table->string('modified_by', 50)->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->string('created_by', 50)->nullable();
        });

        Schema::dropIfExists('schedules_detail');

        Schema::create('schedules_detail', function (Blueprint $table) {
            $table->id();
            // $table->unsignedBigInteger('schedid');
            $table->foreignId('schedid')
            ->constrained('schedules')
            ->onDelete('cascade');
            $table->time('starttime', $precision = 0)->nullable();
            $table->time('endtime', $precision = 0)->nullable();
            $table->time('tardy_start', $precision = 0)->nullable();
            $table->time('absent_start', $precision = 0)->nullable();
            $table->string('dayofweek', 20)->nullable();
            $table->integer('idx')->nullable();
            $table->double('hours', 8, 2)->nullable();
            $table->string('description', 100)->nullable();
            $table->timestamp('updated_at')->nullable()->useCurrent();
            $table->string('modified_by', 50)->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->string('created_by', 50)->nullable();
        });

        Schema::dropIfExists('schedules_detail_employee');

        Schema::create('schedules_detail_employee', function (Blueprint $table) {
            $table->id();
            $table->string('employee_id', 20)->nullable();
            $table->time('starttime', $precision = 0)->nullable();
            $table->time('endtime', $precision = 0)->nullable();
            $table->time('tardy_start', $precision = 0)->nullable();
            $table->time('absent_start', $precision = 0)->nullable();
            $table->string('dayofweek', 20)->nullable();
            $table->integer('idx')->nullable();
            $table->string('description', 100)->nullable();
            $table->timestamp('updated_at')->nullable()->useCurrent();
            $table->string('modified_by', 50)->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->string('created_by', 50)->nullable();
        });

        Schema::enableForeignKeyConstraints();
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();

        Schema::dropIfExists('schedules');
        
        Schema::dropIfExists('schedules_detail');

        Schema::dropIfExists('schedules_detail_employee');
    }
};
