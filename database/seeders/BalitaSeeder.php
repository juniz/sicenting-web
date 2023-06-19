<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class BalitaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');

        for($i=0;$i<=20;$i++){
            DB::table('balita')->insert([
                'id' => Str::uuid(),
                'user_id' => '022ff91e-95d0-437f-9b5b-e738d1cbc3b5',
                'nama' => $faker->name,
                'jns_kelamin' => $faker->randomElement(['L', 'P']),
                'tgl_lahir' => $faker->dateTimeBetween($startDate = '-4 months', $endDate = '-3 months', $timezone = 'Asia/Jakarta')->format('Y-m-d'),
                'nama_ortu' => $faker->name,
                'alamat' => $faker->address,
                'kabupaten' => 3517,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
