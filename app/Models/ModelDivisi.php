<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelDivisi extends Model
{
    use HasFactory;
    protected $table = 'tbl_divisi';
    protected $fillable = [
        'kode_divisi','nama_divisi'
    ];
}
