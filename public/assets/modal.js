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
            emptyTable: "Tidak ada data",
        },
        ajax: {
            url: "/api/siswa/kelas/" + segments[2],
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
            { title: "NIS", data: "nis" },
            { title: "Nama", data: "nama" },
            { title: "Kelas", data: "kelas" },
            { title: "Nama Ayah", data: "nama_ayah" },
            { title: "Nama Ibu", data: "nama_ibu" },
            { title: "No Hp", data: "no_hp" },
            {
                title: "Alamat",
                data: "alamat",
            },
            { title: "Keterangan", data: "remark" },
            {
                title: "Action",    
                data: null,
                render: function (data, type, row) {


                    return `
                    <div style="display:flex; gap:8px; justify-content: center">
                   <button id="bt-qrcode" class="btn btn-outline btn-sm btn-primary fa fa-qrcode" data-nis="${data.nis}" data-nama="${data.nama}" ></button> 
                   <button id="bt-hapus" class="btn btn-outline btn-sm btn-danger fa fa-trash-o" data-id="${data.uuid}"></button> 
                    <button id="bt-edit" class="btn btn-outline btn-sm btn-warning fa fa-pencil " data-uuid="${data.uuid}"></button></div>
                   `;
                },
            },
        ],
    });

});

$("#btn-add").click(() => {
    $("#add-siswa").modal("show");
});
$("#naik").click(() => {
    $("#naik-kelas").modal("show");
});
$("#naik-save").click(() => {
    $.ajax({
        url: "/api/siswa/naik/kelas",
        type: "post",
        data : {
            asal : $('#asal').val(),
            tujuan : $('#tujuan').val(),
        },
        success: () => {
            toastr.success("Berhasil Naik Kelas!", "Siswa");
            table.ajax.reload();
            $("#naik-kelas").modal("hide");

        },
    });
});
$(document).on("click", "#bt-hapus", function () {
    let uuid = $(this).data("id");
    $.ajax({
        url: "/api/siswa/" + uuid,
        type: "DELETE",
        success: () => {
            toastr.success("Berhasil dihapus!", "Data Siswa");
            table.ajax.reload();
        },
    });
});
var uuid;
$("body").on("click", "#bt-edit", function () {
    $("#edit-alamat").hide();
    $.ajax({
        url: "/api/siswa/" + $(this).data("uuid"),
        type: "GET",
        success: (data) => {
            uuid = data.uuid;
            $("#nama").val(data.nama);
            $("#ayah").val(data.nama_ayah);
            $("#kelasEdit").val(data.id_kelas);
            $("#ibu").val(data.nama_ibu);
            $("#nohp").val(data.no_hp);
            $("#alamat").val(data.alamat);
            $("#remark").val(data.remark);
            $("#edit-siswa").modal("show");
        },
    });
});
$("#ubahsiswa").click(function () {
    $.ajax({
        url: "/api/siswa/" + uuid,
        type: "PUT",
        data: {
            nama: $("#nama").val(),
            ayah: $("#ayah").val(),
            ibu: $("#ibu").val(),
            nohp: $("#nohp").val(),
            alamat: $("#alamat").val(),
            kelas: $("#kelasEdit").val(),
            remark: $("#remark").val(),
        },
        success: (response) => {
            $("#edit-siswa").modal("hide");
            toastr.success("Berhasil diubah!", "Data Siswa");
            table.ajax.reload();
            console.log(response);
        },
    });
});
$('#import').click(function (){
    $('#import-modal').modal('show');

});
let nama;

$(document).on("click", "#bt-qrcode", function () {
    nama = $(this).data('nama');
    nama = nama.replace(" ","_");
    nis = $(this).data('nis');
    url =$('#modal-qr').data('url');
    var container = document.getElementById("qrcode-img");
    container.innerHTML = "";
    var qrcode = new QRCode( container, {
        text: url+"/capaian/"+nama,
        width: 280,
        height: 280,
        colorDark: "#000000",
        colorLight: "#ffffff",
        correctLevel: QRCode.CorrectLevel.H // Atur tingkat koreksi jika diperlukan
    });

    $('#modal-qr').modal('show');

});
$("#qr-save").click(() => {
    downloadQRCode(nama);
});

function downloadQRCode(nama) {
    var canvas = document.getElementById("qrcode-img").getElementsByTagName("canvas")[0];
    var url = canvas.toDataURL("image/png").replace("image/png", "image/octet-stream");
    var link = document.createElement("a");
    link.download = "qrcode_"+nama+".png";
    link.href = url;
    link.click();
}
