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
        Schema::create('tbl_penerimaan_barang', function (Blueprint $table) {
            $table->id();
            $table->string('no_penerimaan');
            $table->string('kode_supplier');
            $table->string('kode_barang');
            $table->string('tgl_terima');
            $table->integer('stock');
            $table->string('username');
            $table->string('keterangan');
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
        Schema::dropIfExists('tbl_penerimaan_barang');
    }
};
