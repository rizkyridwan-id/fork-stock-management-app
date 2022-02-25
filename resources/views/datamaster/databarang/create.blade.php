<div class="modal fade" role="dialog" id="MasterModalTambahBarang">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="form_tambah_barang" onsubmit="simpanDataBarang(event)">
                    {{-- @csrf --}}
                    <div class="row">
                        <div class="col-12">
                            <input class="form-control" id="kode_barang" autocomplete="off" type="hidden" name="kode_barang">
                            <input class="form-control" id="is_edit" autocomplete="off" type="hidden" name="is_edit">
                        </div>
                        <div class="col-12">
                            <label> Kode Supplier </label>
                            <select class="form-control" id="kode_supplier_barang" name="kode_supplier">
                                @foreach($datasupplier as $item)
                                <option value="{{$item->kode_supplier}}">{{$item->nama_supplier}}</option>
                              @endforeach
                            </select>
                            <br>
                        </div>
                        <div class="col-12">
                            <label> Nama Barang </label>
                            <input class="form-control" id="nama_barang" autocomplete="off" type="text"
                                name="nama_barang" placeholder="Nama Barang" required>
                            <br>
                        </div>
                        <div class="col-12">
                            <label> Stock </label>
                            <input class="form-control" id="stock" autocomplete="off" type="number" name="stock"
                                placeholder="Stock" required>
                            <br>
                        </div>
                        <div class="col-12">
                            <label> Keterangan </label>
                            <input class="form-control" id="keterangan_barang" autocomplete="off" type="text"
                                name="keterangan_barang" placeholder="Keterangan Barang" required>
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
<script type="text/javascript">

</script>
