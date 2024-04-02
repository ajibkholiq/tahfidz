let siswa, kelas, table,tableNilai, audioName;
    document.addEventListener("DOMContentLoaded", function () {
        tableNilai = new DataTable("#data-nilai", {
            dom: "ftpl",
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
                url: "/api/nilai",
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
    table = new DataTable("#data-table", {
        dom: "ftpl",
        columnDefs: [
            { width: "20px", targets: 0 }, // Menentukan lebar kolom nomor
            { width: "100px", targets: 4 },
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
                    <button id="manual" class="btn btn-outline btn-sm btn-primary " data-uuid="${data.uuid}" data-namaa="${data.nama}">Ziyadah</button>
                     </div>
                   `;
                },
            },
            { title: "NIS", data: "nis" },
            { title: "Nama", data: "nama" },
            { title: "Kelas", data: "kelas" },
           
        ],
    });
    $.ajax({
        url: "/api/surat/",
        type: "GET",
        success: (data) => {
            $("#suratm").empty();
            $.each(data.data, (i, val) => {
                $("#suratm").append(
                    ` <option value="${val.no_surat}">${val.nama}</option> `
                );
            });
            $("#surat").empty();
            $.each(data.data, (i, val) => {
                $("#surat").append(
                    ` <option value="${val.no_surat}">${val.nama}</option> `
                );
            });
        },
    });
});
$("body").on("click", "#auto", function () {
    $("#modal-manual").modal("hide");
    $("#nama").val(siswa);
    $("#modal-dengar").modal("show");
});
$("body").on("click", "#manual", function () {
    siswa = $(this).data("namaa")
    manualShow(siswa);
});
function manualShow(sis) {
    siswa = sis;
    $("#namam").val(siswa);
    $("#modal-manual").modal("show");
}
$("#kelas").on("change", () => {
    kls = $("#kelas").val();
    if (kls == ""){
        url = "/api/getSiswa";
        nl = "/api/nilai"
    }
    else {
        url = "/api/siswa/kelas/" + kls;
        nl = "/api/nilai/" + kls;
    }
    table.ajax.url(url).load();
    tableNilai.ajax.url(nl).load()

    $.ajax({
        url: "/api/getsurat/" + kls,
        type: "GET",
        success: (data) => {
            $("#suratm").empty();
            $.each(data.data, (i, val) => {
                $("#suratm").append(
                    ` <option value="${val.no_surat}">${val.nama}</option> `
                );
            });
            $("#surat").empty();
            $.each(data.data, (i, val) => {
                $("#surat").append(
                    ` <option value="${val.no_surat}">${val.nama}</option> `
                );
            });
        },
    });
});
//
$("#save").on("click", () => {
    $.ajax({
        url: "/api/hafalan",
        type: "post",
        data: {
            siswa: siswa,
            surat: $("#surat").val(),
            kefasihan: $("#kefasihan").val(),
            tajwid: $("#tajwid").val(),
            kelancaran: $("#kelancaran").val(),
            audio: audioName,
            remark: $("#catatan").val(),
        },
        success: (data) => {
            $("#modal-dengar").modal("hide");
            $("#nilai").hide();

            toastr.success("Terima Kasih!", data.message);
            table.ajax.reload();
        },
    });
});
$("#save-manual").on("click", () => {
    $.ajax({
        url: "/api/hafalan",
        type: "post",
        data: {
            siswa: siswa,
            surat: $("#suratm").val(),
            kefasihan: $("#kefasihanm").val(),
            tajwid: $("#tajwidm").val(),
            kelancaran: $("#kelancaranm").val(),
            remark: $("#catatanm").val(),
        },
        success: (data) => {
            $("#modal-manual").modal("hide");
            $("#kefasihanm").val("");
            $("#tajwidm").val("");
            $("#kelancaranm").val("");
            $("#catatanm").val("");
            toastr.success(data.message, "Terima Kasih!");
            table.ajax.reload();
        },
    });
});

window.onload = function () {
    const startButton = document.getElementById("start");
    const stopButton = document.getElementById("stop");
    const outputDiv = document.getElementById("output");
    const output = document.getElementById("text");

    let mediaRecorder;
    let text = "";
    let audioChunks = [];
    if (!("webkitSpeechRecognition" in window)) {
        outputDiv.innerHTML =
            "Speech recognition not supported. Please use Chrome or Edge.";
    } else {
        const recognition = new webkitSpeechRecognition();
        recognition.continuous = true;
        recognition.interimResults = true;
        recognition.lang = "ar-SA";

        recognition.onstart = function () {
            output.innerHTML = "Listening...";
        };

        recognition.onerror = function (event) {
            output.innerHTML = "Error occurred: " + event.error;
        };

        recognition.onresult = function (event) {
            let interimTranscript = "";
            for (let i = event.resultIndex; i < event.results.length; ++i) {
                if (event.results[i].isFinal) {
                    let a = event.results[i][0].transcript;
                    text += a;
                    output.innerHTML = a;
                } else {
                    interimTranscript += event.results[i][0].transcript;
                }
            }
            if (interimTranscript !== "") {
                output.innerHTML = interimTranscript;
            }
        };

        startButton.onclick = function () {
            $("#audio").hide();
            $("#save").hide();
            $("#nilai").hide();
            recognition.start();
            outputDiv.innerHTML = "Merekam...";
            navigator.mediaDevices
                .getUserMedia({ audio: true })
                .then(function (stream) {
                    mediaRecorder = new MediaRecorder(stream);
                    mediaRecorder.start();
                    mediaRecorder.addEventListener(
                        "dataavailable",
                        function (event) {
                            if (event.data.size > 0) {
                                audioChunks.push(event.data);
                            }
                        }
                    );

                    mediaRecorder.addEventListener("stop", function () {
                        const audioBlob = new Blob(audioChunks, {
                            type: "audio/wav",
                        });
                        // text = speechToText(audioBlob); // dari open ai
                        text = text.replace("بسم الله الرحمن الرحيم", "");
                        evaluasi($("#surat").val(), text, audioBlob);
                        text = "";
                    });
                    startButton.disabled = true;
                    stopButton.disabled = false;
                })
                .catch(function (error) {
                    console.error("Error accessing microphone:", error);
                });
        };

        stopButton.onclick = function () {
            if (mediaRecorder.state !== "inactive") {
                mediaRecorder.stop();
                recognition.stop();
                audioChunks = [];
            }
            outputDiv.innerHTML = "";
            output.innerHTML = text;

            $("#save").show();
            stopButton.disabled = true;
            startButton.disabled = false;
        };
    }
};
function speechToText(surat) {
    let text;
    let formData = new FormData();
    formData.append("model", "whisper-1");
    formData.append("file", surat, "audio.wav");
    formData.append("language", "ar");

    $.ajax({
        url: "https://api.openai.com/v1/audio/transcriptions",
        type: "POST",
        headers: {
            Authorization:
                "Bearer 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",
        },
        data: formData,
        contentType: false,
        processData: false,
        success: (data) => {
            text = data.text;
        },
    });
    return text;
}
// Function to send the recognized speech to server
function evaluasi(surat, text, audio = null) {
    let formData = new FormData();
    formData.append("no_surat", surat);
    formData.append("siswa", siswa);
    formData.append("audio", audio, "audio.wav");
    formData.append("text", text);

    $.ajax({
        url: "/api/evaluasi",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (data) {
            nilai = data.data.nilai;
            audioName = data.data.audio;
            $("#kefasihan").val(nilai.kefasihan);
            $("#tajwid").val(nilai.tajwid);
            $("#kelancaran").val(nilai.kelancaran);
            $("#audio").attr("src", "audio/siswa/" + audioName);
            $("#audio").show();
            $("#nilai").show();
            toastr.success("Berhasil Mengevaluasi!", "Nilai Didapatkan");
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
            toastr.error("Terjadi kesalahan saat mengirim data.", "Error");
        },
    });
}
$("#scan").click(() => {
    $("#scan-qr").modal("show");
    var scanning = true; // Variabel boolean untuk menandai pemindaian QR code
    var video = document.getElementById("video");
    var canvas = document.getElementById("canvas");
    var switchCameraBtn = document.getElementById("switch");

    navigator.mediaDevices.getUserMedia({ video: true })
        .then(function (stream) {
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
                const newFacingMode = facingMode === "user" ? "environment" : "user"; // Toggle between "user" and "environment"
                const constraints = {
                    video: { facingMode: newFacingMode }
                };
                navigator.mediaDevices.getUserMedia(constraints)
                    .then(function (newStream) {
                        video.srcObject = newStream;
                        video.play();
                        scanning = true; // Restart scanning
                        scanQRCode(); // Start scanning again
                    })
                    .catch(function (error) {
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
                    nama = code.data
                    url = $('#scan-qr').data('url');
                    siswa = nama.replace(url+"/capaian/",'');
                    siswa = siswa.replace('_'," ");
                    manualShow(siswa);
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
        .catch(function (err) {
            console.error("Error accessing the camera:", err);
        });
});

// $("#scan").click(() => {
//     $("#scan-qr").modal("show");
//     var scanning = true; // Variabel boolean untuk menandai pemindaian QR code
//     var scanning = true; // Variabel boolean untuk menandai pemindaian QR code
//     var video = document.getElementById("video");
//     var cameraSelect = document.getElementById("cameraSelect");

//     // Fungsi untuk mengubah kamera
//     async function switchCamera() {
//         const constraints = {
//             video: {
//                 facingMode: cameraSelect.value // Menggunakan nilai dari opsi terpilih
//             }
//         };

//         // Dapatkan media dari kamera yang dipilih
//         const stream = await navigator.mediaDevices.getUserMedia(constraints);

//         // Atur sumber media video
//         video.srcObject = stream;
//     }

//     // Panggil fungsi switchCamera() saat opsi kamera dipilih berubah
//     cameraSelect.addEventListener('change', switchCamera);

//     // Panggil switchCamera() untuk mengatur kamera default saat halaman dimuat
//     switchCamera();

//     navigator.mediaDevices
//         .getUserMedia({ video: true })
//         .then(function (stream) {
//             var video = document.getElementById("video");
//             video.srcObject = stream;
//             video.play();

//             var canvas = document.getElementById("canvas");
//             var context = canvas.getContext("2d");

//             // Function to stop scanning
//             function stopScanning() {
//                 scanning = false;
//                 stream.getTracks().forEach((track) => track.stop()); // Stop video stream
//                 context.clearRect(0, 0, canvas.width, canvas.height);
//                 $("#scan-qr").modal("hide");

//             }

//             // Continuously scan for QR codes
//             function scanQRCode() {
//                 if (!scanning) return; // Stop scanning if scanning is false
//                 context.drawImage(video, 0, 0, canvas.width, canvas.height);
//                 var imageData = context.getImageData(
//                     0,
//                     0,
//                     canvas.width,
//                     canvas.height
//                 );
//                 var code = jsQR(
//                     imageData.data,
//                     imageData.width,
//                     imageData.height
//                 );
//                 if (code) {
//                     nama = code.data
//                     url = $('#scan-qr').data('url');
//                     siswa = nama.replace(url+"/capaian/",'');
//                     siswa = siswa.replace('_'," ");
//                     manualShow(siswa);
//                     stopScanning(); // Stop scanning when QR code detected
//                     // Do something with the QR code data
//                 } else {
//                     // If QR code not detected, continue scanning
//                     requestAnimationFrame(scanQRCode);
//                 }
//             }

//             // Start scanning
//             scanQRCode();
//             $("#close").click(() => {
//                 stopScanning();
//             });
//         })
//         .catch(function (err) {
//             console.error("Error accessing the camera:", err);
//         });
// });
