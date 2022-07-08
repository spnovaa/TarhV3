<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookDistributorShopInvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_distributor_shop_invoice', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('book_id');
            $table->bigInteger('distributor_shop_invoice_id');

            $table->unsignedBigInteger('count')->default(0);
            $table->boolean('dist_accept')->default(false);
            $table->unsignedBigInteger('row_sum')->default(0);
            $table->integer('discount_percent')->default(0);

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
        Schema::dropIfExists('book_distributor_shop_invoice');
    }
}
