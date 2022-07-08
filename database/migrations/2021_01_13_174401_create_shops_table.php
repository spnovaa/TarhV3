<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('password');
            $table->boolean('admin_accept')->default(false);
            $table->boolean('active')->default(false);

            //personal information
            $table->string('name')->default('');
            $table->string('last_name')->default('');
            $table->string('shop_name')->default('');
            $table->string('national_id')->default('');
            $table->string('tel')->unique()->default('');
            $table->string('shop_tel')->default('');
            $table->string('profile_image')->nullable();

            //living place information
            $table->string('living_state')->default('');
            $table->string('living_city')->default('');
            $table->string('living_area')->nullable();
            $table->string('living_street')->nullable();

            //other
            $table->boolean('sent_flag')->default(false);
            $table->float('percentage')->default(0);
            $table->string('shabaID')->nullable();
            $table->string('credit_card')->nullable();

            $table->string('shop_surface')->default('0');
            $table->string('shop_zip')->default('0');


            $table->boolean('sent_report')->default(false);

            $table->rememberToken();
            $table->timestamps();
            $table->timestamp('email_verified_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shops');
    }
}
