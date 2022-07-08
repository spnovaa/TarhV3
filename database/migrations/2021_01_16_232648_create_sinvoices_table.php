<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSinvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sinvoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('barcode')->nullable();
            $table->bigInteger('shop_id')->nullable();
            $table->bigInteger('distributor_id')->nullable();
            $table->boolean('pending')->default(true);
            $table->boolean('shop_confirm')->default(false);
            $table->string('book_name')->nullable();
            $table->string('writer')->nullable();
            $table->string('publisher')->nullable();
            $table->bigInteger('fee')->nullable();
            $table->bigInteger('order_count')->default(0);
            $table->bigInteger('order_disc_percent')->default(0);
            $table->bigInteger('order_discount')->default(0);
            $table->boolean('dist_seen')->default(0);
            $table->boolean('dist_accept')->default(0);
            $table->string('transition_number')->default(0);
            $table->bigInteger('porterage')->default(0);
            $table->integer('porterage_type')->default(1);
            $table->integer('order_type')->default(1);

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
        Schema::dropIfExists('sinvoices');
    }
}
