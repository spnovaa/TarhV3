<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDistributorShopInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('distributor_shop_invoices', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('shop_id');
            $table->unsignedBigInteger('distributor_id');
            $table->boolean('pending')->default(true);
            $table->boolean('shop_confirm')->default(false); //true when shop approves the shipment.
            $table->boolean('dist_seen')->default(false);
            $table->string('dist_comment')->default('');
            $table->string('shop_comment')->default('');
            $table->string('transition_id')->default('');
            $table->integer('order_type')->default(1);
            $table->bigInteger('porterage_amount')->default(0);
            $table->integer('porterage_type')->default(1);
            $table->bigInteger('overall')->default(0);

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
        Schema::dropIfExists('distributor_shop_invoices');
    }
}
