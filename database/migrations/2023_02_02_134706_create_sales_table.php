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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('date')->nullable();
            $table->string('academic_year')->nullable();
            $table->string('session')->nullable();
            $table->string('alloted_category')->nullable();
            $table->string('voucher_type')->nullable();
            $table->string('voucher_no')->nullable();
            $table->string('roll_no')->nullable();
            $table->string('admno_uniqueId')->nullable();
            $table->string('status')->nullable();
            $table->string('fee_category')->nullable();
            $table->string('faculty')->nullable();
            $table->string('program')->nullable();
            $table->string('department')->nullable();
            $table->string('batch')->nullable();
            $table->string('receipt_no')->nullable();
            $table->string('fee_head')->nullable();
            $table->string('due_amount')->nullable();
            $table->string('paid_amount')->nullable();
            $table->string('concession_amount')->nullable();
            $table->string('scholarship_amount')->nullable();
            $table->string('reverse_concession_amount')->nullable();
            $table->string('write_off_amount')->nullable();
            $table->string('adjusted_amount')->nullable();
            $table->string('refund_amount')->nullable();
            $table->string('fund_trancfer_amount')->nullable();
            $table->string('remarks')->nullable();
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
        Schema::dropIfExists('sales');
    }
};
