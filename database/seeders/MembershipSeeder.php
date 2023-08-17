<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MembershipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('memberships')->insert([
            'name' => 'Free',
            'price' => '0',
            'tax' => '0',
        ]);

        DB::table('memberships')->insert([
            'name' => 'Premium',
            'price' => '100000',
            'tax' => '10',
        ]);
    }
}
