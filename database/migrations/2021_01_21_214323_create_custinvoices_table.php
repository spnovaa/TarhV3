<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustinvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custinvoices', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('shop_id')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->bigInteger('customer_id')->nullable();

            $table->string('barcode')->nullable();
            $table->string('book_name')->nullable();
            $table->string('writer')->nullable();
            $table->string('publisher')->nullable();
            $table->bigInteger('fee')->nullable();
            $table->bigInteger('order_count')->default(0);
            $table->bigInteger('shop_inv')->nullable();
            $table->bigInteger('shop_lib')->nullable();
            $table->bigInteger('order_discount')->default(0);
            $table->string('transition_number')->default(0);

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
        Schema::dropIfExists('custinvoices');
    }
}
