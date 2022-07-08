<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('tarh_name')->nullable();
            $table->string('safir_tarh_name')->default("سفیر خوشه");
            $table->string('shop_tarh_name')->default("فروشگاه خوشه");
            $table->string('dist_tarh_name')->default("پخشی خوشه");


            $table->boolean('safir_active')->default(1);
            $table->boolean('shop_active')->default(1);
            $table->boolean('dist_active')->default(1);

            $table->boolean('shop_lib_sell_active')->default(1);
            $table->boolean('shop_direct_sell_active')->default(1);

            $table->bigInteger('safir_percentage')->default(0);
            $table->bigInteger('shop_percentage')->default(0);
            $table->bigInteger('dist_percentage')->default(0);

            $table->bigInteger('customer_percentage')->default(0);
            $table->bigInteger('customer_percentage_limit')->default(0);
            $table->bigInteger('customer_buy_count_limit')->default(0);
            $table->bigInteger('customer_buy_count_limit_per_book')->nullable();
            $table->boolean('can_shop_add_book')->default(1);

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
        Schema::dropIfExists('settings');
    }
}
