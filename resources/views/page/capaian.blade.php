<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Capaian | SITahfidz</title>

    <link href="{{ URL::asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <link href="{{ URL::asset('assets/css/animate.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/css/style.css') }}" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <!--datatable responsive css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">


</head>

<body class="gray-bg">

    <div class="row" style="display:flex; justify-content: center">
        <div class="col-xs-12 col-sm-10 m-md">
            <div class="ibox float-e-margins" style="border-radius: 50px">

                <div class="ibox-content">
                    <h3>Capaian</h3>
                    <div class="hr-line-dashed"></div>

                    <div class="row">
                        <div class="col-lg-12" style="margin-bottom: 20px">
                            <div class="form-group">
                                <div class="col-sm-6">
                                    <div class="row">
                                        <label class="col-sm-2 control-label" style="padding-top:8px">Kelas</label>
                                        <div class="col-lg-10">
                                        <select name="kelas" id="kelas" class="form-control">
                                            <option value="" readonly>~Kelas~</option>
                                            @foreach ($tingkat as $kelas)
                                                <option value="{{ $kelas->kelas }}">{{ $kelas->kelas }}</option>
                                            @endforeach
                                        </select>
                                        </div>
                                        <style>
                                            @media (max-width: 767px) {
                                                #scan , #lihat,#cari {
                                                    margin-top: 10px;
                                                    width: auto;
                                                }
                                            }
                                        </style>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row" style="gap: 0">
                                        <div class="col-xs-8">
                                            <input type="text" class="form-control" id="cari"
                                                placeholder="Cari">
                                        </div>
                                        <div class="col-xs-4">
                                            <button id="lihat" class="btn btn-lg btn-primary fa fa-search">
                                                Lihat</button>
                                        </div>
                                    </div>                                    
                                </div>
                                <div class="col-md-1">
                                    <button class="btn btn-primary  btn-lg fa fa-qrcode" id="scan"> Scan
                                        QR</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12" style="margin-top: 10px; margin-bottom:30px">
                            <div class="row">
                                <div class="col-sm-12 mt-3">
                                    <div class="table-responsive">
                                        <table id="data-table" class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nis</th>
                                                    <th>Nama</th>
                                                    <th>Kelas</th>
                                                    <th>Action</th>

                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div id="scan-qr" data-url="{{ url('') }}" class="modal modal-large in" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span
                            class="sr-only">Close</span></button>
                </div>
                <div class="modal-body">
                    <h4>Scan QR code Siswa</h4>
                    <div class="form-horizontal">
                        <div class="hr-line-dashed"></div>
                        <div>
                            <video id="video" width="100%" height="auto"></video>
                            <canvas id="canvas" style="display:none;"></canvas>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <div class="col-sm-9 col-sm-offset-3" style="text-align: end">
                                <button class="btn btn-primary" id="switch">Ganti Kamera</button>

                                <button class="btn btn-primary" id="close">Keluar</button>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="{{ URL::asset('assets/js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/bootstrap.min.js') }}"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script> {{-- print --}}
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jsqr/dist/jsQR.min.js"></script>
<script src="{{ URL::asset('assets/js/plugins/typehead/bootstrap3-typeahead.min.js') }}"></script>

<script>
    let table;
    document.addEventListener("DOMContentLoaded", function() {

        table = new DataTable("#data-table", {
            dom: "tpl",
            columnDefs: [{
                    width: "20px",
                    targets: 0
                }, // Menentukan lebar kolom nomor
                {
                    width: "100px",
                    targets: 4
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
                url: "/api/getSiswa",
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
                    title: "NIS",
                    data: "nis"
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
                    title: "Action",
                    data: null,
                    render: function(data, type, row) {
                        return `
                    <div style="display:flex; gap:8px; justify-content: center">
                    <a  class="btn btn-outline btn-sm btn-primary" href="/capaian/${data.nama}">Lihat</button></a>
                     </div>
                   `;
                    },
                },

            ],
        });
        $.ajax({
            url: '/api/getSiswa',
            type: 'get',
            success: (data) => {
                siswa = data.data;
                $('#cari').typeahead({
                    source: siswa.map(a => a.nama),
                })
            }
        });
    });

    $('#lihat').click(() => {
        window.location.href = '/capaian/' + $('#cari').val();
    })

    $("#kelas").on("change", () => {
        kls = $("#kelas").val();

        kls == '' ? url = "/api/getSiswa" : url = "/api/siswa/kelas/" + kls;
        table.ajax.url(url).load();
    });
    $("#scan").click(() => {
        $("#scan-qr").modal("show");
        var scanning = true; // Variabel boolean untuk menandai pemindaian QR code
        var video = document.getElementById("video");
        var canvas = document.getElementById("canvas");
        var switchCameraBtn = document.getElementById("switch");

        navigator.mediaDevices.getUserMedia({
                video: true
            })
            .then(function(stream) {
                video.srcObject = stream;
                video.play();

                var context = canvas.getContext("2d");

                // Function to stop scanning
                function stopScanning(hide) {
                    scanning = false;
                    stream.getTracks().forEach((track) => track.stop()); // Stop video stream
                    context.clearRect(0, 0, canvas.width, canvas.height);
                    if (hide) $("#scan-qr").modal("hide");
                }

                // Function to switch camera
                function switchCamera() {
                    stopScanning(false); // Stop current scanning
                    const facingMode = video.srcObject.getVideoTracks()[0].getSettings().facingMode;
                    const newFacingMode = facingMode === "user" ? "environment" :
                        "user"; // Toggle between "user" and "environment"
                    const constraints = {
                        video: {
                            facingMode: newFacingMode
                        }
                    };
                    navigator.mediaDevices.getUserMedia(constraints)
                        .then(function(newStream) {
                            video.srcObject = newStream;
                            video.play();
                            scanning = true; // Restart scanning
                            scanQRCode(); // Start scanning again
                        })
                        .catch(function(error) {
                            console.error("Error switching camera:", error);
                        });
                }

                // Continuously scan for QR codes
                function scanQRCode() {
                    if (!scanning) return; // Stop scanning if scanning is false
                    context.drawImage(video, 0, 0, canvas.width, canvas.height);
                    var imageData = context.getImageData(
                        0,
                        0,
                        canvas.width,
                        canvas.height
                    );
                    var code = jsQR(
                        imageData.data,
                        imageData.width,
                        imageData.height
                    );
                    if (code) {
                        window.location.href = code.data;
                        stopScanning(true); // Stop scanning when QR code detected
                        // Do something with the QR code data
                    } else {
                        // If QR code not detected, continue scanning
                        requestAnimationFrame(scanQRCode);
                    }
                }

                // Start scanning
                scanQRCode();

                // Event listener for closing modal
                $("#close").click(() => {
                    stopScanning(true);
                });

                // Event listener for switch camera button
                switchCameraBtn.addEventListener("click", switchCamera);
            })
            .catch(function(err) {
                console.error("Error accessing the camera:", err);
            });
    });
</script>

</html>
