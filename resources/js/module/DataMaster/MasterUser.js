import { base_url } from "../base_url.js";

window.getDataUsers = function () {
    $("#tbl_users").DataTable({
        pageLength: 10,
        lengthChange: true,
        bFilter: true,
        destroy: true,
        processing: true,
        serverSide: true,
        oLanguage: {
            sZeroRecords: "Tidak Ada Data",
            sSearch: "Pencarian _INPUT_",
            sLengthMenu: "_MENU_",
            sInfo: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
            sInfoEmpty: "",
            oPaginate: {
                sNext: "<i class='fa fa-angle-right'></i>",
                sPrevious: "<i class='fa fa-angle-left'></i>",
            },
        },
        ajax: {
            url: base_url + "/get-data-users",
            type: "GET",
        },
        columns: [
            {
                data: "DT_RowIndex",
                name: "DT_Row_Index",
                className: "text-center",
                orderable: false,
                searchable: false,
            },
            {
                data: "username",
            },
            {
                data: "email",
            },
            {
                data: "nama_lengkap",
            },
            {
                data: "action",
                orderable: false,
                className: "text-center",
                searchable: false,
            },
        ],
    });
};

window.ShowDataMasterUsers = function (){
    $("#username").removeAttr('readonly');
    $("#password").val("")
    $("#is_edit").val(false);
    $("#username").val("");
    $("#email").val("");
    $("#nama_jenis").val("");
    $("#no_hp").val("");
    $("#nama_lengkap").val("");
    $("#MasterUsersModal").modal("show");
    $("#note-password").hide();
    $("#password_old").val("");


}

window.simpanDatauser = function (e) {
    e.preventDefault();
    let form_data = $("#form_tambah_user").serializeArray();
    // console.log()
    let databaru = serializeObject(form_data);
    if (databaru?.is_edit === "true") {
        $.ajax({
            url: base_url + "/master-users/"+databaru.username,
            type: "PUT",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            data: form_data,
            success: function (respons) {
                if (respons.status == "berhasil") {
                    $("#MasterUsersModal").modal("hide");
                    ToastNotification("success", "Data Berhasil Diedit");
                    getDataUsers();
                    $("#form_tambah_user")[0].reset();
                } else {
                    ToastNotification("info", respons.pesan);
                    return false;
                }
            },
            error: function (respons, textStatus, errorThrown) {
                ToastNotification("info", respons.responseJSON.pesan);
            },
        });
    } else {
        $.ajax({
            url: base_url + "/master-users",
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            data: form_data,
            success: function (respons) {
                if (respons.status == "berhasil") {
                    $("#MasterUsersModal").modal("hide");
                    ToastNotification("success", "Data Berhasil Disimpan");
                    getDataUsers();
                    $("#form_tambah_user")[0].reset();
                } else {
                    ToastNotification("info", respons.pesan);
                    return false;
                }
            },
            error: function (respons, textStatus, errorThrown) {
                ToastNotification("info", respons.responseJSON.pesan);
            },
        });
    }
}

window.hapusDtaUsers = function(e) {
    Swal.fire({
        icon: 'info',
        title: 'Apakah Anda Ingin Mneghapus Data Ini ?',
        showCancelButton: true,
        confirmButtonText: 'Hapus',
      }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
            $.ajax({
                url: base_url + "/master-users/" + e,
                type: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                success: function (respons) {
                    if (respons.status == "berhasil") {
                        ToastNotification("success", "Data Berhasil Di Hapus");
                        getDataUsers();
                    } else {
                        ToastNotification("error", respons.pesan);
                        return false;
                    }
                },
                error: function (respons, textStatus, errorThrown) {
                    ToastNotification("error", respons.responseJSON.pesan);
                },
            });
        } 
      })
}

window.showModalEditUsers = function (e){
    $.ajax({
        url: base_url + "/master-users/" + e,
        type: "GET",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (respons) {
            if (respons.status == "berhasil") {
                respons.data.forEach((el) => {
                    $("#username").attr('readonly', 'readonly');
                    $("#note-password").show();
                    $("#is_edit").val(true);
                    $("#username").val(el.username);
                    $("#email").val(el.email);
                    $("#nama_jenis").val(el.nama_jenis);
                    $("#no_hp").val(el.no_hp);
                    $("#nama_lengkap").val(el.nama_lengkap);
                    $("#password_old").val(el.password);
                });
                $("#MasterUsersModal").modal("show");
            } else {
                ToastNotification("error", respons.pesan);
                return false;
            }
        },
        error: function (respons, textStatus, errorThrown) {
            ToastNotification("error", respons.responseJSON.pesan);
        },
    });
}