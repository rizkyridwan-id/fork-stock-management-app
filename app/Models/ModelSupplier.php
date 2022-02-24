<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelSupplier extends Model
{
    use HasFactory;
    protected $table = 'tbl_supplier';
    protected $fillable = [
        'kode_supplier','nama_supplier'
    ];
}
