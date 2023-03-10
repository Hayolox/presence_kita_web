<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'AKIL',
            'email' => 'akiklii72@gmail.com',
            'password' => Hash::make('1234'),
        ]);

        DB::table('semesters')->insert([
            'name' => 'ganjil',
        ]);

        DB::table('semesters')->insert([
            'name' => 'genap',
        ]);

        DB::table('semesters')->insert([
            'name' => 'none',
        ]);

        DB::table('rooms')->insert([
            'name' => 'FT 9',
            'latitude' => 'DAWDAWD',
            'longitude' => 'DAWDAWD'
        ]);

        DB::table('majors')->insert([
            'name' => 'Teknik informatika',
        ]);
    }
}
