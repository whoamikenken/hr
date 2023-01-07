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
        Schema::create('batch_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('sched_id', 30)->nullable();
            $table->string('campus', 30)->nullable();
            $table->string('adviser', 30)->nullable();
            $table->string('yearlevel', 30)->nullable();
            $table->string('course', 30)->nullable();
            $table->string('section', 30)->nullable();
            $table->string('student_count', 30)->nullable();
            $table->timestamp('updated_at')->nullable()->useCurrent();
            $table->string('modified_by', 30)->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->string('created_by', 30)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('batch_schedules');
    }
};
