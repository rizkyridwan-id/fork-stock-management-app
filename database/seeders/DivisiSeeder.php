<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ModelDivisi;
class DivisiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $divisi = ModelDivisi::create([
            'kode_divisi' => 'DVS_APOTEK',
            'nama_divisi' => "APOTEKER",
        ]);
    }
}
