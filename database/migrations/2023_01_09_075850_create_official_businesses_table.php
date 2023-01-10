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
        Schema::create('official_businesses', function (Blueprint $table) {
            $table->id();
            // $table->string('applied_by', 20)->nullable();
            // $table->string('date_from', 20)->nullable();
            // $table->string('date', 100)->nullable();
            // $table->string('expense', 100)->nullable()->default(0);
            // $table->string('item', 100)->nullable();
            // $table->string('charge_currency', 100)->nullable()->default('HKD');
            // $table->string('charge', 20)->nullable()->default('0');
            // $table->string('comission_currency', 100)->nullable()->default('HKD');
            // $table->string('comission', 20)->nullable()->default('0');
            // $table->string('claim_status', 100)->nullable()->default('PENDING');
            // $table->string('payment_type', 100)->nullable()->default('');
            // $table->string('cheque_number', 100)->nullable()->default('');
            // $table->text('payment_doc')->nullable();
            // $table->integer('read_finance')->nullable()->default(0);
            // $table->integer('read_cost')->nullable()->default(0);
            // $table->integer('email_finance')->nullable()->default(0);
            // $table->integer('email_cost')->nullable()->default(0);
            // $table->date('date_issued')->nullable();
            // $table->date('date')->nullable();
            // $table->timestamp('updated_at')->nullable()->useCurrent();
            // $table->string('updated_by', 50)->nullable();
            // $table->timestamp('created_at')->nullable()->useCurrent();
            // $table->string('created_by', 50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('official_businesses');
    }
};
