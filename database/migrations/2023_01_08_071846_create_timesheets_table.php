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
        Schema::dropIfExists('timesheets_trail');

        Schema::create('timesheets_trail', function (Blueprint $table) {
            $table->id();
            $table->string('employee_id', 20)->nullable();
            $table->dateTime('log_time', $precision = 0)->nullable();
            $table->string('local_time')->nullable();
            $table->string('log_type', 100)->nullable()->default('IN');
            $table->string('username', 100)->nullable();
            $table->string('ip', 100)->nullable();
            $table->string('location', 100)->nullable();
            $table->string('machine_type', 100)->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
        });

        Schema::dropIfExists('timesheets');

        Schema::create('timesheets', function (Blueprint $table) {
            $table->id();
            $table->string('employee_id', 20)->nullable();
            $table->dateTime('time_in', $precision = 0)->nullable();
            $table->dateTime('time_out', $precision = 0)->nullable();
            $table->string('machine_in', 100)->nullable();
            $table->string('machine_out', 100)->nullable();
            $table->string('ip_in', 100)->nullable();
            $table->string('ip_out', 100)->nullable();
            $table->string('location_in', 100)->nullable();
            $table->string('location_out', 100)->nullable();
            $table->string('machine_type', 100)->nullable();
            $table->string('type', 100)->nullable();
            $table->string('username', 100)->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
        });

        Schema::dropIfExists('timesheets_trail_history');

        Schema::create('timesheets_trail_history', function (Blueprint $table) {
            $table->id();
            $table->string('employee_id', 20)->nullable();
            $table->dateTime('log_time', $precision = 0)->nullable();
            $table->string('local_time')->nullable();
            $table->string('log_type', 100)->nullable()->default('IN');
            $table->string('username', 100)->nullable();
            $table->string('ip', 100)->nullable();
            $table->string('location', 100)->nullable();
            $table->string('machine_type', 100)->nullable();
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
        Schema::dropIfExists('timesheets');
        Schema::dropIfExists('timesheets_trail');
    }
};
