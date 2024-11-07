<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Insert two roles into the roles table

        DB::table('roles')->insert([
            ['name' => 'Admin','created_at'=>now(),'updated_at'=>now()],
            ['name' => 'User','created_at'=>now(),'updated_at'=>now()],
        ]);
    }
}
