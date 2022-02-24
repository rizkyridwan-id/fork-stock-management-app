<div class="modal fade" tabindex="-1" role="dialog" id="MasterDivisisModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data Divisi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="form_tambah_divisi" onsubmit="simpanDivisi(event)">
                    {{-- @csrf --}}
                    <div class="row">
                        <div class="col-12">
                            <input class="form-control" id="is_edit" autocomplete="off" type="hidden" name="is_edit">
                        </div>
                        <div class="col-12">
                            <label> Kode Divisi </label>
                            <input class="form-control" id="kode_divisi" autocomplete="off" type="text" name="kode_divisi"
                                placeholder="Kode Divisi" required>
                            <br>
                        </div>
                        <div class="col-12">
                            <label> Nama Divisi </label>
                            <input class="form-control" id="nama_divisi" autocomplete="off" type="text"
                                name="nama_divisi" placeholder="Nama Divisi" required>
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
