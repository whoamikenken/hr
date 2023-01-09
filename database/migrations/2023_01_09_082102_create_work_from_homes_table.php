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
        Schema::create('work_from_homes', function (Blueprint $table) {
            $table->id();
            $table->string('applied_by', 20)->nullable();
            $table->string('employee_id', 20)->nullable();
            $table->string('purpose', 100)->nullable();
            $table->string('work_done', 250)->nullable();
            $table->text('accomplishment_file')->nullable();
            $table->string('office_head', 20)->nullable();
            $table->integer('read_office_head')->nullable()->default(0);
            $table->integer('email_office_head')->nullable()->default(0);
            $table->integer('read_employee')->nullable()->default(1);
            $table->integer('email_employee')->nullable()->default(1);
            $table->string('status', 20)->nullable()->default("PENDING");
            $table->date('date_approved')->nullable();
            $table->date('date')->nullable();
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
        Schema::dropIfExists('work_from_homes');
    }
};
