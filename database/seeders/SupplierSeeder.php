<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ModelSupplier;
class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            array('kode_supplier' => 'SP-01', 'nama_supplier' => "PT-Jaya Maskerku",),
            array('kode_supplier' => 'SP-02','nama_supplier' => "PT Jaya FarmasiKu",)
        ];
        foreach ($data as $row) {
            ModelSupplier::create($row);
        }
    }
}
