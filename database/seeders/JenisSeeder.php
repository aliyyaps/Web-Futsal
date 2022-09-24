<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('jenis')->insert([
            'nama' => 'Rumput Sintetis',
            'deskripsi' => 'Deskripsi jenis arena dengan lantai dari rumput sintetis',
            'images' => 'imagesJenis/1.jpeg',
        ]);
        DB::table('jenis')->insert([
            'nama' => 'Vinyl',
            'deskripsi' => 'Deskripsi jenis arena dengan lantai dari vinyl',
            'images' => 'imagesJenis/2.jpg',
        ]);
    }
}
