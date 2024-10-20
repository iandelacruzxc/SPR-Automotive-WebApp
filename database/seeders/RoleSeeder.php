<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();

        DB::table('roles')->insert([
            [
                'name' => 'admin',
                'guard' => 'web',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'user',
                'guard' => 'web',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'mechanic',
                'guard' => 'web',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
