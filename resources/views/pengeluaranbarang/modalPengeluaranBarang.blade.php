<div class="modal fade" role="dialog" id="ModalPengeluaranBarang">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pengeluaran Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="form_pengeluaran_barang" onsubmit="simpanPengeluaranBarang(event)">
                    <div class="row">
                        <div class="col-12">
                            <input class="form-control" id="is_edit" autocomplete="off" type="hidden" name="is_edit">
                        </div>
                        <div class="col-12">
                            <label> Kode Divisi </label>
                            <select class="form-control" id="kode_divisi_pengeluaran_barang" name="kode_divisi">
                                <option value=""> Silahkan Pilih Supplier </option>
                                @foreach($divisi as $item)
                                <option value="{{$item->kode_divisi}}">{{$item->nama_divisi}}</option>
                              @endforeach
                            </select>
                            <br>
                        </div>
                        <div class="col-12">
                            <label> Kode Barang </label>
                            <select class="form-control" id="kode_barang_pengeluaran_barang" name="kode_barang">
                                <option value=""> Silahkan Pilih Kode Barang </option>
                            </select>
                            <br>
                        </div>
                        {{-- {{session()->get('datauser')->username}} --}}
                        <div class="col-12">
                            <label> Jumlah </label>
                            <input class="form-control" id="jumlah" autocomplete="off" type="number"
                                name="jumlah" placeholder="Masukan Jumalh" required>
                            <br>
                        </div>
                        <div class="col-12">
                            <label> Keterangan </label>
                            <input class="form-control" id="keterangan_penerima" autocomplete="off" type="text"
                                name="keterangan_penerima" placeholder="Keterangan Penerima" required>
                            <br>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
            </form>
        </div>
    </div>
</div>
