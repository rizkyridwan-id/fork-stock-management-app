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

$(document).ready(function () {
    $('.carisupplier').change(function(){
        // console.log()
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
                if (respons.status == "berhasil") {
                    let hasil = []
                    respons.data.forEach((el) => {
                        let row = {
                            'id' : el.kode_barang,
                            'text' : el.nama_barang
                        }
                        hasil.push(row)
                    });
                //    console.log(hasil)
                $("#kode_barang_terima_barang").select2({
                    placeholder: "Pilih Data Barang ...",
                    theme: "bootstrap4",
                    data: [{id : "", text:""}]
                });
                    setTimeout(() => {
                        $("#kode_barang_terima_barang").select2({
                            placeholder: "Pilih Data Barang ...",
                            theme: "bootstrap4",
                            data: hasil
                        });
                    }, 300);
                } else {
                    ToastNotification("error", respons.pesan);
                    return false;
                }
            },
            error: function (respons, textStatus, errorThrown) {
                ToastNotification("error", respons.responseJSON.pesan);
            },
        });

    })
});

