<div class="modal fade" role="dialog" id="ModalPenerimaanBarang">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Penerimaan Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="form_penerimaan_barang" onsubmit="simpanPenerimaanBarang(event)">
                    {{-- @csrf --}}
                    <div class="row">
                        <div class="col-12">
                            <input class="form-control" id="is_edit" autocomplete="off" type="hidden" name="is_edit">
                        </div>
                        <div class="col-12">
                            <label> Kode Supplier </label>
                            <select class="form-control carisupplier" id="kode_supplier_barang" name="kode_supplier">
                                <option value=""> Silahkan Pilih Supplier </option>
                                @foreach($datasupplier as $item)
                                <option value="{{$item->kode_supplier}}">{{$item->nama_supplier}}</option>
                              @endforeach
                            </select>
                            <br>
                        </div>
                        <div class="col-12">
                            <label> Kode Barang </label>
                            <select class="form-control" id="kode_barang_terima_barang" name="kode_barang">
                                <option value=""> Silahkan Pilih Kode Barang </option>
                            {{-- @foreach($databarang as $item)
                                <option value="{{$item->kode_barang}}">{{$item->nama_barang}}</option>
                              @endforeach --}}
                            </select>
                            <br>
                        </div>
                        <div class="col-12">
                            <label> Stock </label>
                            <input class="form-control" id="stock" autocomplete="off" type="number" name="stock"
                                placeholder="Stock" required>
                            <br>
                        </div>
                        <div class="col-12">
                            <label> Tanggal Terima </label>
                            <input class="form-control" id="tgl_terima_barang" autocomplete="off" type="date"
                                name="tgl_terima" placeholder="Tangal Terima Barang" required>
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
