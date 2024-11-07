<?php

namespace Database\Seeders;

use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            ['name' => 'Admin','email'=>'admin@gmail.com','password'=>Hash::make('12345678'),'created_at'=>now(),'updated_at'=>now()]
        ]);
    }
}
