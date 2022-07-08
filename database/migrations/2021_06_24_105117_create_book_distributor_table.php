<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookDistributorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_distributor', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('book_id');
            $table->unsignedBigInteger('distributor_id');
            $table->bigInteger('dist_inv')->default(0);
            $table->bigInteger('dist_disc_percent')->default(0);
            $table->bigInteger('dist_sold')->default(0);
            $table->bigInteger('dist_driven')->default(0);
            $table->bigInteger('dist_entry')->default(0);

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
        Schema::dropIfExists('book_distributor');
    }
}
