<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_pengeluaran_barang', function (Blueprint $table) {
            $table->id();
            $table->string('no_pengeluaran');
            $table->string('kode_barang');
            $table->string('jumlah');
            $table->string('tgl_keluar');
            $table->integer('kode_divisi');
            $table->string('atas_nama');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_pengeluaran_barang');
    }
};
