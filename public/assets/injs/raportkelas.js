document.addEventListener("DOMContentLoaded", function() {
    table = new DataTable("#data-table", {
        dom: "tpl",
        columnDefs: [{
                width: "100px",
                targets: 1
            },
            {
                width: "20x",
                targets: 0
            },
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
            url: "/api/cetak/raport",
            type: "GET",
        },
        columns: [{
                title: "No",
                data: null,
                render: function(data, type, row, meta) {
                    return meta.row + 1; // Mengembalikan nomor baris, dimulai dari 1
                },
            },
            {
                title: "Action",
                data: null,
                render: function(data, type, row) {
                    return `
            <div style="display: flex ; gap:5px;justify-content:center">
            <a class="btn btn-outline btn-primary btn-sm" href='/cetak/${data.kelas}'>Export</button>
            <div> `;
                },
            },
            {
                title: "Nama Kelas",
                data: "kelas"
            },
            {
                title: "Tingkat Kelas",
                data: "tingkat"
            },{
                title: "Semester",
                data: "semester"
            },{
                title: "Tahun Pelajaran",
                data: "tahun_ajaran"
            },


        ],
    });
});
$("body").on("click", "#bt-manage", function() {
    window.location.href = "/nilai/" + $(this).data("kelas")+"/sikap";
});
