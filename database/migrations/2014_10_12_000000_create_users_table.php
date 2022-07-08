<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->string('email')->unique();
            $table->string('password');
            $table->boolean('admin_accept')->default(false);
            $table->boolean('active')->default(false);
            $table->bigInteger('code')->unique()->nullable();


            //personal information
            $table->string('name')->default('');
            $table->string('last_name')->default('');
            $table->string('fathers_name')->default('');
            $table->boolean('gender')->default(true);
            $table->string('national_id')->default('');
            $table->string('tel')->unique()->default('');
            $table->string('born_date')->default('');
            $table->string('profile_image')->nullable();

            //living place information
            $table->string('living_address')->default('');
            $table->string('living_state')->default('');
            $table->string('living_city')->default('');
            $table->string('living_area')->nullable();
            $table->string('living_street')->nullable();
            $table->string('living_alley')->nullable();
            $table->string('living_plaque')->nullable();
            $table->string('living_zip')->nullable();

            //education information
            $table->string('educated_at')->default('');
            $table->integer('education_grade')->default(0);//0:no,1:diploma,2:kardani,3:lisans,4:arshad,5:doctora
            $table->string('education_city')->default('');
            $table->string('education_branch')->default('');

            //background
            $table->integer('selling_background')->default(0);
            $table->string('book_background')->nullable();
            $table->string('last_read_3b')->nullable();
            $table->string('suggestion')->nullable();

            //other
            $table->string('moarref')->nullable();
            $table->string('payamresan')->nullable();
            $table->string('payamresan_phone')->nullable();
            $table->string('instagram')->nullable();

            $table->boolean('sent_flag')->default(false);
            $table->float('percentage')->default(0);
            $table->string('shabaID')->nullable();
            $table->boolean('sent_report')->default(false);

            //heyat info
            $table->string('heyat_name')->default('');
            $table->string('manager_name')->default('');
            $table->string('manager_tel')->default('');
            $table->string('heyat_adress')->default('');

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
        Schema::dropIfExists('users');
    }
}
