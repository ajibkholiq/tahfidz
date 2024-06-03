let table;
document.addEventListener("DOMContentLoaded", function () {
    table = new DataTable("#data-table", {
        dom: "tpl",
        columnDefs: [
            { width: "20x", targets: 0},
        ],
        processing: false,
        ordering: true,
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "All"],
        ],
        language: {
            emptyTable: "Tidak ada data",
        },
        ajax: {
            url: "/api/surat",
            type: "GET",
        },
        columns: [
            {
                title: "No",
                data: null,
                render: function (data, type, row, meta) {
                    return meta.row + 1; // Mengembalikan nomor baris, dimulai dari 1
                },
            },
            { title: "Nama Surat", data: "nama" },
            { title: "Nomor Surat", data: "no_surat" },
            { title: "Jumlah Ayat", data: "ayat" },
            { title: "Target Kelas", data: "kelas" },
            { title: "Keterangan", data: "remark" },
            {
                title: "Action",
                data: null,
                render: function (data, type, row) {
                    return `
                    <div style="display:flex; gap:8px; justify-content: center">
                    <button id="bt-edit" class="btn btn-outline btn-sm btn-warning fa fa-pencil " data-uuid="${data.uuid}"></button>
                   <button id="bt-hapus" class="btn btn-outline btn-sm btn-danger fa fa-trash-o" data-id="${data.uuid}"></button> </div>
                   `;
                },
            },
        ],
    });
});
let no_surat;
$("body").on("click", "#bt-edit", function () {
    $.ajax({
        url: "/api/surat/" + $(this).data("uuid"),
        type: "GET",
        success: (data) => {
            $("#uuid").val(data.uuid);
            $("#surat").val(data.nama);
            
            no_surat =data.no_surat;
            $("#ayat").val(data.ayat);
            $("#tingkat").val(data.kelas);
            $("#remarke").val(data.remark); 
            $("#edit-kelas").modal("show");
        },
    });
});
$("#kelas-save").on("click", () => {
    $.ajax({
        url: "/api/surat/" + $("#uuid").val(),
        type: "PUT",
        data: {
            nama : $("#surat").val(),
            no_surat: no_surat,
            ayat : $("#ayat").val(),
            tingkat : $("#tingkat").val(),
            remark : $("#remark").val(),
            },
        success: (response) => {
            $("#edit-kelas").modal("hide");
            toastr.success("Berhasil diubah!", "Data Surat");

            console.log(response);
            table.ajax.reload();
        },
    });
});
$(document).on("click", "#bt-hapus", function () {
    let uuid = $(this).data("id");
    $.ajax({
        url: "/api/surat/" + uuid,
        type: "DELETE",
        success: () => {
            toastr.success("Berhasil dihapus!", "Data Kelas");
            table.ajax.reload();
        },
    });
});
