let tablesmt;
document.addEventListener("DOMContentLoaded", function () {
    tablesmt = new DataTable("#data-smt", {
        dom: "tpl",
        columnDefs: [
            { width: "20x", targets: 0},
            { width: "20x", targets: 3},
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
            url: "/api/semester",
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
            { title: "Semester", data: "semester" },
            { title: "Status", data: "status" },
            { title: "Keterangan", data: "remark" },
            {
                title: "Action",
                data: null,
                render: function (data, type, row) {
                    var clas;
                    if (data.status === "AKTIF") {
                        a = 'Non Aktifkan'
                        clas = "btn-warning";
                    } else {
                        a = 'Aktifkan'

                        clas = "btn-primary ";
                    }
                    return `
                    <div style="display:flex; gap:8px; justify-content: center">
                    <button id="bt-edit-sm" class="btn btn-outline btn-sm ${clas}" data-uuid="${data.uuid}" data-status ="${data.status}" ">${a}</button>

                   <button id="bt-hapus-sm" class="btn btn-outline btn-sm btn-danger fa fa-trash-o" data-id="${data.uuid}"></button> 
                    </div>
                   `;
                },
            },
        ],
    });
});
$("body").on("click", "#bt-edit-sm", function () {
    let uuid = $(this).data("uuid");
    let statu = $(this).data("status");
    $.ajax({
        url: "/api/semester/" + uuid,
        type: "PUT",
        data: {
            status: statu,
           
        },
        success: function () {
            if (statu == "AKTIF") {
                toastr.success("Berhasil dinonaktifkan!", "Semester");
            } else {
                toastr.success("Berhasil diaktifkan!", "Semester");
            }
            tablesmt.ajax.reload();
        },
    });
});

$(document).on("click", "#bt-hapus-sm", function () {
    let uuid = $(this).data("id");
    $.ajax({
        url: "/api/semester/" + uuid,
        type: "DELETE",
        data: {
            _token: $("input[name='_token']").val(),
            _method: "DELETE",
        },
        success: () => {
            toastr.success("Berhasil dihapus!", "Semester");
            tablesmt.ajax.reload();
        },
    });
});
