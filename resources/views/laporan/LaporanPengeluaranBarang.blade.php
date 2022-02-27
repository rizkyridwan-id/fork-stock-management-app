@extends('layouts.index')
@section('title', 'Laporan Pengeluaran Barang')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Data Laporan Pengeluaran Barang</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="card">
            <div class="card-body">
                {!! Form::open(['route' => 'cetak-laporan-pengeluaran', 'method' => 'POST']) !!}
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label>Tanggal Dari</label>
                            {!! Form::date('tgl_dari', date('Y-m-d'), ['placeholder' => 'Masukan Tanggak', 'class' => 'form-control' ,'required']) !!}
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label>Tanggal Sampai</label>
                            {!! Form::date('tgl_sampai', date('Y-m-d'), ['placeholder' => 'Masukan Tanggak', 'class' => 'form-control' ,'required']) !!}

                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <button type="submit" class="btn btn-block btn-primary">Cari Laporan</button>
                        </div>
                    </div>

                </div>
                {!! Form::close() !!}
            </div>
            <!-- /.card-body -->
        </div>
    </section>
@stop
