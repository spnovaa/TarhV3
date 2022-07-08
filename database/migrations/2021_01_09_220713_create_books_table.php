<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('book_name')->nullable();
            $table->string('writer')->nullable();
            $table->string('publisher')->nullable();
            $table->bigInteger('fee')->nullable();
            $table->string('barcode')->nullable();
            $table->string('editor')->nullable();
//            $table->bigInteger('dist_inv')->default(0);
//            $table->bigInteger('dist_sold')->default(0);
//            $table->bigInteger('dist_driven')->default(0);
            $table->boolean('edited')->default(false);
            $table->boolean('deleted')->default(false);
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
        Schema::dropIfExists('books');
    }
}
