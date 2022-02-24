import { base_url } from "../base_url.js";

window.simpanDataKategori = function (e) {
    e.preventDefault();
    let form_data = $("#form_tambah_kategori").serializeArray();
    // console.log()
    let databaru = serializeObject(form_data);
    if (databaru?.is_edit === "true") {
        $.ajax({
            url: base_url + "/master-kategori/"+databaru.kode_kategori,
            type: "PUT",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            data: form_data,
            success: function (respons) {
                if (respons.status == "berhasil") {
                    $("#MasterKategoriModal").modal("hide");
                    ToastNotification("success", "Data Berhasil Diedit");
                    getDataKategori();
                    $("#form_tambah_kategori")[0].reset();
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
            url: base_url + "/master-kategori",
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            data: form_data,
            success: function (respons) {
                if (respons.status == "berhasil") {
                    $("#MasterKategoriModal").modal("hide");
                    ToastNotification("success", "Data Berhasil Disimpan");
                    getDataKategori();
                    $("#form_tambah_kategori")[0].reset();
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

window.ShowModalMasterKategori = function (e) {
    $('#kode_kategori').removeAttr('readonly');
    $("#is_edit").val(false);
    $("#kode_kategori").val("");
    $("#nama_kategori").val("");
    $("#MasterKategoriModal").modal("show");
};

window.getDataKategori = function () {
    $("#tbl_kaetgori").DataTable({
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
            url: base_url + "/get-data-kategori",
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
                data: "nama_kategori",
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

window.hapusDataKategori = function (e) {
    Swal.fire({
        icon: 'info',
        title: 'Apakah Anda Ingin Mneghapus Data Ini ?',
        showCancelButton: true,
        confirmButtonText: 'Hapus',
      }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
            $.ajax({
                url: base_url + "/master-kategori/" + e,
                type: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                success: function (respons) {
                    if (respons.status == "berhasil") {
                        ToastNotification("success", "Data Berhasil Di Hapus");
                        getDataKategori();
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

window.showModalEditKategori = function (e) {
    $.ajax({
        url: base_url + "/master-kategori/" + e,
        type: "GET",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (respons) {
            if (respons.status == "berhasil") {
                $("#kode_kategori").attr('readonly', 'readonly');
                respons.data.forEach((el) => {
                    $("#is_edit").val(true);
                    $("#kode_kategori").val(el.kode_kategori);
                    $("#nama_kategori").val(el.nama_kategori);
                });
                $("#MasterKategoriModal").modal("show");
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