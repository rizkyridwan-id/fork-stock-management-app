<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ModelBarang;
class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            array('kode_supplier' => 'SP-01', 'kode_barang' => 'BRG001', 'nama_barang' => "MASKER N05", 'stock' => 20, 'keterangan_barang' => "MASKER UNTUK DIJUAL",),
            array('kode_supplier' => 'SP-02', 'kode_barang' => 'BRG002', 'nama_barang' => "MASKER N05", 'stock' => 20, 'keterangan_barang' => "MASKER UNTUK DIJUAL",)
        ];
        foreach ($data as $row) {
            ModelBarang::create($row);
        }
    }
}
