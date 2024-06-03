let table;
document.addEventListener("DOMContentLoaded", function () {
    var path = window.location.pathname;
    var segments = path.split("/");
    table = new DataTable("#data-table", {
        dom: "ftipl",
        processing: false,
        ordering: true,
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "All"],
        ],
        language: {
            emptyTable:
                "Tidak ada data! pastikan semester dan tahun pelajaran ada yang aktif",
        },
        ajax: {
            url: "/api/nilai/" + segments[2],
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
            {
                title: "Action",
                data: null,
                render: function (data, type, row) {
                    return `
                    <div style="display:flex; gap:8px; justify-content: center">
                    <button id="perbaikan" class="btn btn-outline btn-sm btn-primary fa fa-pencil" data-id="${data.uuid}" data-nama="${data.nama}"> Perbaikan</button> 
                   `;
                },
            },
            {
                title: "Nama",
                data: "nama",
            },
            {
                title: "Kelas",
                data: "kelas",
            },
            {
                title: "Surat",
                data: "surat",
            },
            {
                title: "Kefasihan",
                data: "kefasihan",
            },
            {
                title: "Tajwid",
                data: "tajwid",
            },
            {
                title: "Kelancaran",
                data: "kelancaran",
            },
            {
                title: "Capaian",
                data: "capaian",
            },
        ],
    });
});
let uuid;
$(document).on("click", "#perbaikan", function () {
    uuid = $(this).data("id");
    $.ajax({
        url: "/api/hafalan/" + uuid,
        type: "get",
        success: (data) => {
            $("#nama").val($(this).data("nama"));
            $("#kefasihan").val(data.kefasihan);
            $("#tajwid").val(data.tajwid);
            $("#kelancaran").val(data.kelancaran);
            $("#catatan").val(data.remark);
            $("#modal-manual").modal("show");
            console.log(data);

            // console.log
            // toastr.success("Berhasil dihapus!", "Data Kelas");
        },
    });
});
$(document).on("click", "#save", function () {
    $.ajax({
        url: "/api/hafalan/" + uuid,
        type: "PUT",
        data: {
            kefasihan: $("#kefasihan").val(),
            tajwid: $("#tajwid").val(),
            kelancaran: $("#kelancaran").val(),
            remark: $("#catatan").val(),
        },
        success: (data) => {
            $("#modal-manual").modal("hide");
            table.ajax.reload();
            toastr.success("Berhasil disimpan!", "Perbaikan");
        },
    });
});
