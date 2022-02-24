import { base_url } from "../base_url.js";

window.ShowModalDivisi = function () {
    $("#kode_divisi").removeAttr("readonly");
    $("#kode_divsi").val("");
    $("#nama_divisi").val("");
    $("#is_edit").val(false);
    $("#MasterDivisisModal").modal("show");
};

window.simpanDivisi = function (e) {
    e.preventDefault();
    let form_data = $("#form_tambah_divisi").serializeArray();
    let databaru = serializeObject(form_data);
    if (databaru?.is_edit === "true") {
        $.ajax({
            url: base_url + "/master-divisi/" + databaru.kode_divisi,
            type: "PUT",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            data: form_data,
            success: function (respons) {
                if (respons.status == "berhasil") {
                    $("#MasterDivisisModal").modal("hide");
                    ToastNotification("success", "Data Berhasil Diedit");
                    getDataDivisi();
                    $("#form_tambah_divisi")[0].reset();
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
            url: base_url + "/master-divisi",
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            data: form_data,
            success: function (respons) {
                if (respons.status == "berhasil") {
                    $("#MasterDivisisModal").modal("hide");
                    ToastNotification("success", "Data Berhasil Disimpan");
                    getDataDivisi();
                    $("#form_tambah_divisi")[0].reset();
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

window.getDataDivisi = function () {
    $("#tbl_divisi").DataTable({
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
            url: base_url + "/get-data-divisi",
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
                data: "kode_divisi",
            },
            {
                data: "nama_divisi",
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

window.showModalEditDivisi = function (e){
    $.ajax({
        url: base_url + "/master-divisi/" + e,
        type: "GET",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (respons) {
            if (respons.status == "berhasil") {
                respons.data.forEach((el) => {
                    $("#kode_divisi").attr('readonly', 'readonly');
                    $("#is_edit").val(true);
                    $("#kode_divisi").val(el.kode_divisi);
                    $("#nama_divisi").val(el.nama_divisi);
                });
                $("#MasterDivisisModal").modal("show");
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

window.hapusDataDivisi= function (e){
    Swal.fire({
        icon: 'info',
        title: 'Apakah Anda Ingin Mneghapus Data Ini ?',
        showCancelButton: true,
        confirmButtonText: 'Hapus',
      }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
            $.ajax({
                url: base_url + "/master-divisi/" + e,
                type: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                success: function (respons) {
                    if (respons.status == "berhasil") {
                        ToastNotification("success", "Data Berhasil Di Hapus");
                        getDataDivisi();
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