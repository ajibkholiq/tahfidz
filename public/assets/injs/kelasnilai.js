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
                    url: "/api/kelas",
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
                    <button id="bt-manage" class="btn btn-outline btn-primary btn-sm  fa fa-eye" data-kelas="${data.kelas}"> Lihat</button>
                  <div> `;
                        },
                    },
                    {
                        title: "Nama Kelas",
                        data: "kelas"
                    },
                    {
                        title: "Wali Kelas",
                        data: "nama"
                    },
                    {
                        title: "Tingkat Kelas",
                        data: "tingkat"
                    },


                ],
            });
        });
        $("body").on("click", "#bt-manage", function() {
            window.location.href = "/kelas/" + $(this).data("kelas") + "/nilai";
        });
      