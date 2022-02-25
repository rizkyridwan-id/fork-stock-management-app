import { base_url } from "./base_url.js";

window.showModalPenerimaanBarang = function () {
    $("#kode_supplier").val("").change();
    $("#kode_barang").val("");
    $("#nama_barang").val("");
    $("#keterangan_barang").val("");
    $("#stock").val("");
    $("#is_edit").val(false);
    $("#ModalPenerimaanBarang").modal("show");
};


window.simpanPenerimaanBarang = function (e) {
    e.preventDefault();
    let form_data = $("#form_penerimaan_barang").serializeArray();
    $.ajax({
        url: base_url + "/penerimaan-barang",
        type: "POST",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: form_data,
        success: function (respons) {
            if (respons.status == "berhasil") {
                $("#ModalPenerimaanBarang").modal("hide");
                ToastNotification("success", "Data Berhasil Disimpan");
                getDataPenerimaanBarang();
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

$(document).ready(function () {
    $('.carisupplier').change(function(){
        $.ajax({
            url: base_url + "/get-barang-by-kode-supplier",
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            data : {
                kode_supplier : $(this).val()
            },
            success: function (respons) {
                $('#kode_barang_terima_barang').val(null).trigger('change');
                $("#kode_barang_terima_barang").empty().trigger('change')
                
                $("#kode_barang_terima_barang").select2({
                    placeholder: "Pilih Data Barang ...",
                    theme: "bootstrap4",
                    data: respons,
                    allowClear: true
                });
            },
            error: function (respons, textStatus, errorThrown) {
                console.log(respons)
                ToastNotification("error", respons.responseJSON.pesan);
            },
        });

    })
});


window.getDataPenerimaanBarang = function () {
    $("#tbl_penerimaan_barang").DataTable({
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
            url: base_url + "/get-data-penerimaan-barang",
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
                data: "no_penerimaan",
            },
            {
                data: "kode_barang",
            },
            {
                data: "tgl_terima",
            },
            {
                data: "stock",
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
