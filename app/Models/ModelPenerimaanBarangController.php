<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelPenerimaanBarangController extends Model
{
    use HasFactory;
    protected $table = 'tbl_penerimaan_barang';
    protected $fillable = [
        'no_penerimaan','kode_supplier','kode_barang','tgl_terima','stock','username','keterangan'
    ];
}
