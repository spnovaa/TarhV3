<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
        DB::table('admins')->insert([
            'tel' => '09140230411',
            'password' => Hash::make('Isna1994'),
            'name' => 'مجتبی به نشان'
        ]);
        DB::table('settings')->insert([
            'tarh_name' => 'حیات حسینی',
            'safir_active' => true,
            'shop_active' => true,
            'dist_active' => true


        ]);
        DB::table('books')->insert([
            'book_name' => 'ملت عشق',
            'writer' => 'الیف شافاک',
            'publisher' => 'ققنوس',
            'fee' => '75000',
            'barcode' => '9789643119195',
            'editor' => 'مدیریت'
        ]);
//        DB::table('distributors')->insert([
//            'tel' => '09211148982',
//            'password' => Hash::make('Isna1994'),
//            'name' => 'پخش شهید کاظمی'
//        ]);
        DB::table('shops')->insert([
            'tel' => '09211148982',
            'password' => Hash::make('Isna1994'),
            'name' => 'مصطفی',
            'last_name' => 'رحمتی',
            'shop_name' => 'هرندیه'
        ]);
    }
}
