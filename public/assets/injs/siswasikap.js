let table;
document.addEventListener("DOMContentLoaded", function() {
    var path = window.location.pathname;
    var segments = path.split('/');
    table = new DataTable("#data-table", {
        columnDefs: [{
            width: "250px",
            targets: 7
        }, 
    
    ],
        dom: "ftipl",
        processing: false,
        ordering: true,
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "All"],
        ],
        language: {
            emptyTable: "Tidak ada data! pastikan semester dan tahun pelajaran ada yang aktif",
        },
        ajax: {
            url: "/api/nilai/" + segments[2] + "/sikap",
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
        <div style="display:flex; gap:8px; justify-content: center">
        <button id="perbaikan" class="btn btn-outline btn-sm btn-primary fa fa-pencil" data-id="${data.uuid}" data-nama="${data.nama}"> Perbaikan</button> 
       `;
                },
            },
            {
                title: "Nama",
                data: "nama"
            },
            {
                title: "Kelas",
                data: "kelas"
            },
            {
                title: "Pengetahuan",
                data: "pengetahuan"
            }, {
                title: "Sikap",
                data: "sikap"
            }, {
                title: "Keterampilan",
                data: "keterampilan"
            },
            {
                title: "Catatan",
                data: "remark"

            },
            {
                title: "Semester/Tahun",
                data: null,
                render : function (data){
                    return data.semester+"/"+data.tahun_pelajaran
                }

            }
            

        ],
    });


});
let uuid;
$(document).on("click", "#perbaikan", function() {
    uuid = $(this).data("id");
    $.ajax({
        url: "/api/nilai/sikap/" + uuid,
        type: "get",
        success: (data) => {
            $("#siswap").val($(this).data('nama'));
            $("#pengetahuanp").val(data.pengetahuan);
            $("#sikapp").val(data.sikap);
            $("#keterampilanp").val(data.keterampilan);
            $("#catatan").val(data.remark);
            $('#modal-p').modal('show');

            // console.log
            // toastr.success("Berhasil dihapus!", "Data Kelas");
        },
    });
});
$(document).on("click", "#save", function() {
    $.ajax({
        url: "/api/nilai/sikap",
        type: "post",
        data: {
            siswa: $("#siswa").val(),
            pengetahuan: $("#pengetahuan").val(),
            sikap: $("#sikap").val(),
            keterampilan: $("#keterampilan").val(),
            remark: $("#catatan").val(),
        },
        success: (data) => {
            $('#modal').modal('hide');
            table.ajax.reload();
            toastr.success("Berhasil disimpan!", "Success");
        },
    });
});
$(document).on("click", "#save-p", function() {
    $.ajax({
        url: "/api/nilai/sikap/"+uuid,
        type: "Put",
        data: {
            pengetahuan: $("#pengetahuanp").val(),
            sikap: $("#sikapp").val(),
            keterampilan: $("#keterampilanp").val(),
            remark: $("#catatanp").val(),
            
        },
        success: (data) => {
            $('#modal-p').modal('hide');

            table.ajax.reload();
            toastr.success("Berhasil disimpan!", "Perbaikan");
        },
    });
});