<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class PemeriksaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');
        $data = DB::table('balita')->where('kabupaten', 3571)->get();
        foreach($data as $balita){
            DB::table('pemeriksaan')->insert([
                'id' => Str::uuid(),
                'balita_id' => $balita->id,
                'tgl_pengukuran' => '2023-06-15',
                'tinggi' => rand(50, 100),
                'berat' => rand(5, 20),
                'usia'  => $faker->randomElement(['3', '4']),
                'bb_u' => $faker->randomElement(['Berat badan lebih', 'Berat badan sangat kurang', 'Berat badan kurang', 'Berat badan normal']),
                'tb_u' => $faker->randomElement(['Tinggi', 'Pendek', 'Sangat pendek', 'Tinggi badan normal']),
                'bb_tb' => $faker->randomElement(['Gizi buruk', 'Obesitas', 'Gizi kurang', 'Gizi baik', 'Resiko gizi lebih', 'Gizi lebih', 'Gizi normal']),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
