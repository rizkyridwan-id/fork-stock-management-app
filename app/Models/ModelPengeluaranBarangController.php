<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelPengeluaranBarangController extends Model
{
    use HasFactory;
    protected $table = 'tbl_pengeluaran_barang';
    protected $fillable = [
        'no_pengeluaran','kode_barang','jumlah','tgl_keluar','kode_divisi','keterangan','username'
    ];
}
