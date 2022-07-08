<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDistFinancialProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dist_financial_profiles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('distributor_id')->index();

            $table->string('shaba_id')->default('');
            $table->float('percentage')->default(0);
            $table->float('sell_amount')->default(0);
            $table->float('returned_amount')->default(0);
            $table->integer('sell_count')->default(0);
            $table->integer('returned_count')->default(0);
            $table->float('shop_checkout_overall')->default(0);
            $table->float('shop_debtor_overall')->default(0);
            $table->float('shop_creditor_overall')->default(0);
            $table->timestamps();

            $table->foreign('distributor_id')->references('id')->on('distributors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dist_financial_profiles');
    }
}
