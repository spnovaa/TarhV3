<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDistProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dist_profiles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('distributor_id')->index();
            $table->string('national_id')->default('');

            $table->string('profile_image')->default('');
            $table->string('name')->default('');
            $table->string('last_name')->default('');

            $table->string('living_state')->default('');
            $table->string('living_city')->default('');
            $table->string('living_area')->default('');
            $table->string('living_street')->default('');
            $table->string('shabaID')->default('');
            $table->string('company_zip')->default('');
            $table->string('credit_card')->default('');
            $table->string('company_tel')->default('');

            $table->foreign('distributor_id')->references('id')->on('distributors');
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
        Schema::dropIfExists('dist_profiles');
    }
}
