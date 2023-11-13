<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'Andriyani',
                'guru_id' => '1',
                'email' => 'andriyani@smp.ac.id',
                'password' => Hash::make('password'),
                'level' => 'admin',
                'status' => 'aktif',
            ],
        ];

        DB::table('users')->insert($data);
    }
}
