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
        $data = [
            array('kode_divisi' => 'DVS-001','nama_divisi' => "APOTEKER"),
            array('kode_divisi' => 'DVS-002','nama_divisi' => "KEUANGAN"),
            array('kode_divisi' => 'DVS-003','nama_divisi' => "PENJAUALAN")
        ];
        foreach ($data as $row) {
            ModelDivisi::create($row);
        }
    }
}
