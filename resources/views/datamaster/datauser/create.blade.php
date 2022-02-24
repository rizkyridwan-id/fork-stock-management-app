<div class="modal fade" tabindex="-1" role="dialog" id="MasterUsersModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="form_tambah_user" onsubmit="simpanDatauser(event)">
                    {{-- @csrf --}}
                    <div class="row">
                        <div class="col-12">
                            <input class="form-control" id="password_old" autocomplete="off" type="hidden"
                                name="password_old">
                            <input class="form-control" id="is_edit" autocomplete="off" type="hidden" name="is_edit">
                        </div>
                        <div class="col-12">
                            <label> Username </label>
                            <input class="form-control" id="username" autocomplete="off" type="text" name="username"
                                placeholder="Username" required>
                            <br>
                        </div>
                        <div class="col-12">
                            <label> Nama Lengkap </label>
                            <input class="form-control" id="nama_lengkap" autocomplete="off" type="text"
                                name="nama_lengkap" placeholder="Nama Lengkap" required>
                            <br>
                        </div>
                        <div class="col-12" id="passwordhidden">
                            <label> Password </label>
                            <input class="form-control" id="password" autocomplete="off" type="password"
                                name="password" placeholder="Password">
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
