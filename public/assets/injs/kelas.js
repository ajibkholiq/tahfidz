let table;
document.addEventListener("DOMContentLoaded", function () {
    table = new DataTable("#data-table", {
        dom: "tpl",
        columnDefs: [
            { width: "150px", targets: 5 },
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
            url: "/api/kelas",
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
            { title: "Nama Kelas", data: "kelas" },
            { title: "Wali Kelas", data: "nama" },
            { title: "Tingkat Kelas", data: "tingkat" },
            { title: "Keterangan", data: "remark" },
            {
                title: "Action",
                data: null,
                render: function (data, type, row) {
                    return `
                    <div style="display: flex ; gap:5px;justify-content:center">
                    <button id="bt-manage" class="btn btn-outline btn-primary btn-sm  fa fa-gear" data-kelas="${data.kelas}"> Kelola</button>
                    <button id="bt-edit" class="btn btn-outline btn-warning btn-sm fa fa-pencil " data-uuid="${data.uuid}"></button>
                    <button id="bt-hapus" class="btn btn-outline btn-danger btn-sm fa fa-trash-o" data-id="${data.uuid}"></button>
                  <div> `;
                },
            },
        ],
    });
});
$("body").on("click", "#bt-edit", function () {
    $.ajax({
        url: "/api/kelas/" + $(this).data("uuid"),
        type: "GET",
        success: (data) => {
            $("#uuid").val(data.uuid);
            $("#kelase").val(data.kelas);
            $("#tingkate").val(data.tingkat);
            $("#walie").val(data.user_id);
            $("#remarke").val(data.remark); 
            $("#edit-kelas").modal("show");
        },
    });
});
$("#kelas-save").on("click", () => {
    $.ajax({
        url: "/api/kelas/" + $("#uuid").val(),
        type: "PUT",
        data: {
            kelas: $("#kelase").val(),
            kode: $("#tingkate").val(),
            tingkat: $("#tingkate").val(),
            wali: $("#walie").val(),
            remark: $("#remarke").val(),
            },
        success: (response) => {
            $("#edit-kelas").modal("hide");
            toastr.success("Berhasil diubah!", "Data Kelas");

            console.log(response);
            table.ajax.reload();
        },
    });
});
$(document).on("click", "#bt-hapus", function () {
    let uuid = $(this).data("id");
    $.ajax({
        url: "/api/kelas/" + uuid,
        type: "DELETE",
        data: {
            _token: $("input[name='_token']").val(),
            _method: "DELETE",
        },
        success: () => {
            toastr.success("Berhasil dihapus!", "Data Kelas");
            table.ajax.reload();
        },
    });
});
$("body").on("click", "#bt-manage", function () {
    window.location.href = "/kelas/"+$(this).data("kelas")+"/siswa";
});
