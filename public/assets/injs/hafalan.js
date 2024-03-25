let siswa, kelas ,table,audioName;
document.addEventListener("DOMContentLoaded", function () {
    table = new DataTable("#data-table", {
        dom: "tpl",
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
            { title: "NIS", data: "nis" },
            { title: "Nama", data: "nama" },
            { title: "Kelas", data: "kelas" },
            {
                title: "Action",
                data: null,
                render: function (data, type, row) {
                    return `
                    <div style="display:flex; gap:8px; justify-content: center">
                    <button id="auto" class="btn btn-outline btn-sm btn-primary " data-id="${data.uuid}" data-nama="${data.nama}">Dengarkan</button>
                    <button id="manual" class="btn btn-outline btn-sm btn-primary " data-uuid="${data.uuid}" data-namaa="${data.nama}">Manual</button>
                     </div>
                   `;
                },
            },
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
    siswa = $(this).data("id");
    $("#nama").val($(this).data("nama"));
    $("#modal-dengar").modal("show");
});
$("body").on("click", "#manual", function () {
    siswa = $(this).data("uuid");
    $("#namam").val($(this).data("namaa"));
    $("#modal-manual").modal("show");
});
$("#kelas").on("change", () => {
    kls = $("#kelas").val();
    kls == "" ? (url = "/api/getSiswa") : (url = "/api/kelas/" + kls);
    table.ajax.url(url).load();
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
$('#save').on('click',()=>{
    $.ajax({
        url: "/api/hafalan",
        type: "post",
        data: {
            siswa : siswa ,
            surat: $("#surat").val(),
            kefasihan: $("#kefasihan").val(),
            tajwid :$("#tajwid").val(),
            kelancaran :$("#kelancaran").val(),
            audio: audioName,
            remark : $("#catatan").val()
            },
        success: (data) => {
            $("#modal-dengar").modal("hide");
            $("#nilai").hide();

            toastr.success("Terima Kasih!", data.message);
            table.ajax.reload();
        },
    });


});
$('#save-manual').on('click',()=>{
    $.ajax({
        url: "/api/hafalan",
        type: "post",
        data: {
            siswa : siswa ,
            surat: $("#suratm").val(),
            kefasihan: $("#kefasihanm").val(),
            tajwid :$("#tajwidm").val(),
            kelancaran :$("#kelancaranm").val(),
            remark : $("#catatanm").val()
            },
        success: (data) => {
            $("#modal-manual").modal("hide");
            $("#kefasihanm").val('');
            $("#tajwidm").val('');
            $("#kelancaranm").val('');
            $("#catatanm").val('');
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
