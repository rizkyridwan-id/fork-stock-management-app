@extends('layouts.index')
@section('content')
@section('title', 'Dashboard')

<div class="row">
    <div class="col-lg-4 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
            <div class="inner">
                <h3> <?= $data['databarang'] ?></h3>
                <p>Data Barang</p>
            </div>
            <div class="icon">
                <i class="nav-icon  fas fa-box-archive"></i>
            </div>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-4 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
            <div class="inner">
                <h3><?= $data['databarangterima'] ?></h3>

                <p>Barang Diterima Hari Ini</p>
            </div>
            <div class="icon">
                <i class="nav-icon  fas fa-box-archive"></i>
            </div>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-4 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
            <div class="inner">
                <h3><?= $data['datapengeluaranbarang'] ?></h3>
                <p>Barang Keluar Hari Ini</p>
            </div>
            <div class="icon">
                <i class="nav-icon  fas fa-box-archive"></i>
            </div>
        </div>
    </div>
  
</div>

@stop
