<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDistributorShopTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('distributor_shop', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('distributor_id');
            $table->bigInteger('shop_id');

            $table->bigInteger('net_balance')->nullable();
            $table->bigInteger('porterage_balance')->nullable();

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
        Schema::dropIfExists('distributor_shop');
    }
}
