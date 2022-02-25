import { base_url } from "../base_url.js";

window.showModalSupplier = function () {
    $("#kode_supplier").removeAttr("readonly");
    $("#kode_supplier").val("");
    $("#nama_supllier").val("");
    $("#is_edit").val(false);
    $("#MasterSupplierModal").modal("show");
}

window.getDataSupplier = function () {
    $("#tbl_supplier").DataTable({
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
            url: base_url + "/get-data-supplier",
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
                data: "kode_supplier",
            },
            {
                data: "nama_supplier",
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

window.simpanDataSupplier = function (e) {
    e.preventDefault();
    let form_data = $("#form_tambah_supplier").serializeArray();
    let databaru = serializeObject(form_data);
    if (databaru?.is_edit === "true") {
        $.ajax({
            url: base_url + "/master-supplier/" + databaru.kode_supplier,
            type: "PUT",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            data: form_data,
            success: function (respons) {
                if (respons.status == "berhasil") {
                    $("#MasterSupplierModal").modal("hide");
                    ToastNotification("success", "Data Berhasil Diedit");
                    getDataSupplier();
                    $("#form_tambah_supplier")[0].reset();
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
            url: base_url + "/master-supplier",
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            data: form_data,
            success: function (respons) {
                if (respons.status == "berhasil") {
                    $("#MasterSupplierModal").modal("hide");
                    ToastNotification("success", "Data Berhasil Disimpan");
                    getDataSupplier();
                    $("#form_tambah_supplier")[0].reset();
                } else {
                    ToastNotification("info", respons.pesan);
                    return false;
                }
            },
            error: function (respons, textStatus, errorThrown) {
                console.log(respons);
                ToastNotification(
                    "info",
                    respons.responseJSON?.pesan ||
                        "Terjadi Kesalahan Saat Menyimpan Data"
                );
            },
        });
    }
}

window.hapusDataSupplier = function (e) {
    Swal.fire({
        icon: 'info',
        title: 'Apakah Anda Ingin Mneghapus Data Ini ?',
        showCancelButton: true,
        confirmButtonText: 'Hapus',
      }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
            $.ajax({
                url: base_url + "/master-supplier/" + e,
                type: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                success: function (respons) {
                    if (respons.status == "berhasil") {
                        ToastNotification("success", "Data Berhasil Di Hapus");
                        getDataSupplier();
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

window.shwoModalEditSupplier = function (e){
    $.ajax({
        url: base_url + "/master-supplier/" + e,
        type: "GET",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (respons) {
            if (respons.status == "berhasil") {
                respons.data.forEach((el) => {
                    $("#kode_supplier").attr('readonly', 'readonly');
                    $("#is_edit").val(true);
                    $("#kode_supplier").val(el.kode_supplier);
                    $("#nama_supplier").val(el.nama_supplier);
                });
                $("#MasterSupplierModal").modal("show");
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