@extends('layouts.index')
@section('title', 'Laporan Penerimaan Barang')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Data Laporan Penerimaan Barang</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="card">
            <div class="card-body">
                <form action="{{ url('cetak-laporan-penerimaan-barang') }}">
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label>Tanggal Dari</label>
                                <input type="date" class="form-control">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Tanggal Sampai</label>
                                <input type="date" class="form-control">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <button type="submit" class="btn btn-block btn-primary">Cari Laporan</button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
            
            <!-- /.card-body -->
        </div>
    </section>
@stop
