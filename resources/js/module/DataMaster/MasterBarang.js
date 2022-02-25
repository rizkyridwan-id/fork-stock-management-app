import { base_url } from "../base_url.js";

window.showModalDataBarang = function () {
    $("#kode_supplier").val("").change();
    $("#kode_barang").val("");
    $("#nama_barang").val("");
    $("#keterangan_barang").val("");
    $("#stock").val("");
    $("#is_edit").val(false);
    $("#MasterModalTambahBarang").modal("show");
};

window.showModalEditDataBarang = function (e) {
    $.ajax({
        url: base_url + "/master-barang/" + e,
        type: "GET",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (respons) {
            if (respons.status == "berhasil") {
                respons.data.forEach((el) => {
                    $("#is_edit").val(true);
                    $("#kode_barang").val(el.kode_barang);
                    $("#nama_barang").val(el.nama_barang);
                    $("#keterangan_barang").val(el.keterangan_barang);
                    $("#stock").val(el.stock);
                    var newOption = new Option('CP0012', el.kode_supplier, true, true);
                    $('#kode_supplier').append(newOption).trigger('change');
                });
                $("#MasterModalTambahBarang").modal("show");
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
window.simpanDataBarang = function (e) {
    e.preventDefault();
    let form_data = $("#form_tambah_barang").serializeArray();
    let databaru = serializeObject(form_data);
    if (databaru?.is_edit === "true") {
        $.ajax({
            url: base_url + "/master-barang/" + databaru.kode_barang,
            type: "PUT",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            data: form_data,
            success: function (respons) {
                if (respons.status == "berhasil") {
                    $("#MasterModalTambahBarang").modal("hide");
                    ToastNotification("success", "Data Berhasil Diedit");
                    getDataBarang();
                    $("#form_tambah_barang")[0].reset();
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
            url: base_url + "/master-barang",
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            data: form_data,
            success: function (respons) {
                if (respons.status == "berhasil") {
                    $("#MasterModalTambahBarang").modal("hide");
                    ToastNotification("success", "Data Berhasil Disimpan");
                    getDataBarang();
                    $("#form_tambah_barang")[0].reset();
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
};
window.getDataBarang = function () {
    $("#tbl_barang").DataTable({
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
            url: base_url + "/get-data-barang",
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
                data: "kode_barang",
            },
            {
                data: "nama_barang",
            },
            {
                data: "stock",
            },
            {
                data: "keterangan_barang",
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

window.hapusDataBarang = function (e) {
    Swal.fire({
        icon: "info",
        title: "Apakah Anda Ingin Mneghapus Data Ini ?",
        showCancelButton: true,
        confirmButtonText: "Hapus",
    }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
            $.ajax({
                url: base_url + "/master-barang/" + e,
                type: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                success: function (respons) {
                    if (respons.status == "berhasil") {
                        ToastNotification("success", "Data Berhasil Di Hapus");
                        getDataBarang();
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
    });
};

$(document).ready(function () {
    $("#kode_supplier_barang").select2({
        placeholder: "Pilih Kode Supplier",
        theme: "bootstrap4",
        ajax: {
            url: base_url + "/get-datasupplierAjax",
            type: "post",
            dataType: "json",
            delay: 250,
            data: function (params) {
                return {
                    _token: $('meta[name="csrf-token"]').attr("content"),
                    search: params.term, // search term
                };
            },
            processResults: function (response) {
                return {
                    results: response,
                };
            },
            cache: true,
        },
    });
});
