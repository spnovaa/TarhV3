<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookDistributorShopInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_distributor_shop_invoices', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('book_id');
            $table->unsignedBigInteger('distributor_shop_invoice_id');
            $table->unsignedBigInteger('count');
            $table->unsignedBigInteger('dist_accept');
            $table->unsignedBigInteger('shop_id');
            $table->unsignedBigInteger('item_amount_sum');
            $table->unsignedBigInteger('discount_percent');

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
        Schema::dropIfExists('book_distributor_shop_invoices');
    }
}
