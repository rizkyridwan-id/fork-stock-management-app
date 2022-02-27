<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelBarang extends Model
{
    use HasFactory;
    protected $table = 'tbl_barang';
    protected $fillable = [
        'kode_supplier','kode_barang','nama_barang','keterangan_barang','stock','harga_satuan'
    ];
}
