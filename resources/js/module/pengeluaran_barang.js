import { base_url } from "./base_url.js";

window.showModalPengeluaranBarang = function (){
    $("#is_edit").val(false);
    $("#ModalPengeluaranBarang").modal("show");
}

$(document).ready(function () {
    $("#kode_barang_pengeluaran_barang").select2({
        placeholder: "Pilih Kode Barang",
        theme: "bootstrap4",
        ajax: {
            url: base_url + "/get-dataBarangAjax",
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
    $("#kode_divisi_pengeluaran_barang").select2({
        placeholder: "Pilih Kode Barang",
        theme: "bootstrap4",
        ajax: {
            url: base_url + "/get-datadivisiAjax",
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

window.simpanPengeluaranBarang = function (e) {
    e.preventDefault();
    let form_data = $("#form_pengeluaran_barang").serializeArray();
    $.ajax({
        url: base_url + "/pengeluaran-barang",
        type: "POST",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: form_data,
        success: function (respons) {
            if (respons.status == "berhasil") {
                $("#ModalPengeluaranBarang").modal("hide");
                ToastNotification("success", "Data Berhasil Disimpan");
                getPengeluaranBarang()
                $("#form_pengeluaran_barang")[0].reset();
                var newOption = new Option('','', true, true);
                $('#kode_divisi_pengeluaran_barang').append(newOption).trigger('change');
            } else {
                ToastNotification("info", respons?.data);
                return false;
            }
        },
        error: function (respons, textStatus, errorThrown) {
            console.log(respons);
            ToastNotification(
                "info",
                respons.responseJSON?.data ||
                    "Terjadi Kesalahan Saat Menyimpan Data"
            );
        },
    });
}


window.getPengeluaranBarang = function () {
    $("#tbl_pengeluaran_barang").DataTable({
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
            url: base_url + "/get-data-pengeluaran-barang",
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
                data: "no_pengeluaran",
            },
            {
                data: "kode_barang",
            },
            {
                data: "jumlah",
            },
            {
                data: "tgl_keluar",
            },
            {
                data: "kode_divisi",
            },
            {
                data: "keterangan",
            },
           
        ],
    });
};