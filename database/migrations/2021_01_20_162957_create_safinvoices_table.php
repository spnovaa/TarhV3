<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSafinvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('safinvoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('barcode')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->bigInteger('shop_id')->nullable();
            $table->boolean('pending')->default(true);
            $table->boolean('safir_confirm')->default(false);
            $table->string('book_name')->nullable();
            $table->string('writer')->nullable();
            $table->string('publisher')->nullable();
            $table->bigInteger('fee')->nullable();
            $table->bigInteger('order_count')->default(0);
            $table->bigInteger('inv_accept')->default(0);
            $table->bigInteger('tarh_accept')->default(0);
            $table->bigInteger('accept_sum')->default(0);
            $table->boolean('shop_seen')->default(0);
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
        Schema::dropIfExists('safinvoices');
    }
}
