import { base_url } from "../base_url.js";

window.ShowModalMasterJenis = function (e) {
    $('#kode_jenis').removeAttr('readonly');
    $("#kode_kategori").removeAttr('disabled');
    $("#is_edit").val(false);
    $("#MasterJenisModal").modal("show");
    $("#kode_kategori").val("").change();
    $("#kode_jenis").val("");
    $("#nama_jenis").val("");
};
window.showModalEditJenis = function (e) {
    $.ajax({
        url: base_url + "/master-jenis/" + e,
        type: "GET",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (respons) {
            if (respons.status == "berhasil") {
                $("#kode_jenis").attr('readonly', 'readonly');
                $("#kode_kategori").attr('disabled', 'disabled');
                respons.data.forEach((el) => {
                    $("#is_edit").val(true);
                    $("#kode_kategori").val(el.kode_kategori).change();
                    $("#kode_jenis").val(el.kode_jenis);
                    $("#nama_jenis").val(el.nama_jenis);
                });
                $("#MasterJenisModal").modal("show");
            } else {
                ToastNotification("error", respons.pesan);
                return false;
            }
        },
        error: function (respons, textStatus, errorThrown) {
            ToastNotification("error", respons.responseJSON.pesan);
        },
    });
};

window.getDataJenis = function () {
    $("#tbl_jenis").DataTable({
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
            url: base_url + "/get-data-jenis",
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
                data: "kode_kategori",
            },
            {
                data: "kode_jenis",
            },
            {
                data: "nama_jenis",
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
window.simpanDataJenis = function (e) {
    e.preventDefault();
    let form_data = $("#form_tambah_jenis").serializeArray();
    // console.log()
    let databaru = serializeObject(form_data);
    if (databaru?.is_edit === "true") {
        $.ajax({
            url: base_url + "/master-jenis/"+databaru.kode_jenis,
            type: "PUT",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            data: form_data,
            success: function (respons) {
                if (respons.status == "berhasil") {
                    $("#MasterJenisModal").modal("hide");
                    ToastNotification("success", "Data Berhasil Diedit");
                    getDataJenis();
                    $("#form_tambah_jenis")[0].reset();
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
            url: base_url + "/master-jenis",
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            data: form_data,
            success: function (respons) {
                if (respons.status == "berhasil") {
                    $("#MasterJenisModal").modal("hide");
                    ToastNotification("success", "Data Berhasil Disimpan");
                    getDataJenis();
                    $("#form_tambah_jenis")[0].reset();
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
};

window.hapusDataJenis = function (e) {
    Swal.fire({
        icon: 'info',
        title: 'Apakah Anda Ingin Mneghapus Data Ini ?',
        showCancelButton: true,
        confirmButtonText: 'Hapus',
      }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
            $.ajax({
                url: base_url + "/master-jenis/" + e,
                type: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                success: function (respons) {
                    if (respons.status == "berhasil") {
                        ToastNotification("success", "Data Berhasil Di Hapus");
                        getDataJenis();
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
  
};


