@extends('layouts.app')

@section('content')
<style>
    /* BUNGKUSAN UTAMA */
    #reader {
        border: none !important;
        background: transparent !important;
        width: 100% !important;
    }

    /* BIKIN KAMERA JADI ROUNDED & KECE */
    #reader video {
        border-radius: 15px !important;
        box-shadow: 0 10px 20px rgba(0,0,0,0.15) !important;
        object-fit: cover !important;
        width: 100% !important;
        max-height: 350px !important;
        margin-bottom: 20px !important;
    }

    /* NGERAPIHIN DROPDOWN PILIH KAMERA */
    #reader select {
        display: block;
        width: 80% !important;
        margin: 0 auto 15px auto !important;
        padding: 10px 15px !important;
        border-radius: 30px !important;
        border: 1px solid #e3e3e3 !important;
        background: #f8f9fa !important;
        color: #495057 !important;
        font-family: inherit !important;
        font-size: 14px !important;
        outline: none !important;
    }

    /* TOMBOL START/STOP CAMERA */
    #reader button {
        background: linear-gradient(to right, #da8cff, #9a55ff) !important;
        border: none !important;
        color: white !important;
        padding: 10px 30px !important;
        border-radius: 30px !important;
        font-weight: 600 !important;
        letter-spacing: 0.5px !important;
        box-shadow: 0 4px 15px rgba(154, 85, 255, 0.4) !important;
        transition: all 0.3s ease !important;
        margin-bottom: 10px !important;
    }
    #reader button:hover {
        transform: translateY(-2px) !important;
        box-shadow: 0 6px 20px rgba(154, 85, 255, 0.6) !important;
    }

    /* =========================================
       TOMBOL UPLOAD GALERI (YANG TADI ILANG)
       ========================================= */
    
    /* Jangan di-hide header-nya, cukup hide title teksnya aja */
    #reader__header { display: block !important; }
    #reader__title { display: none !important; }

    /* Bikin tulisan "Scan an Image File" jadi tombol cakep */
    #reader a {
        display: inline-block !important;
        margin: 15px 0 !important;
        padding: 10px 25px !important;
        background: #fff !important;
        color: #9a55ff !important;
        border: 2px solid #9a55ff !important;
        border-radius: 30px !important;
        font-weight: bold !important;
        text-decoration: none !important;
        transition: 0.3s !important;
    }
    #reader a:hover {
        background: #9a55ff !important;
        color: #fff !important;
    }

    /* Kotak pas milih file dari galeri */
    #reader__dashboard_section_fsr input[type="file"] {
        display: block !important;
        width: 100% !important;
        padding: 15px !important;
        border: 2px dashed #9a55ff !important;
        border-radius: 15px !important;
        background: #fcf9ff !important;
        color: #9a55ff !important;
        font-weight: bold !important;
        cursor: pointer !important;
        margin-top: 15px !important;
    }

    /* KARTU HASIL SCAN */
    .result-card-custom {
        border: none;
        border-radius: 15px;
        background: linear-gradient(135deg, #f6f8fd 0%, #f1f5f9 100%);
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }
</style>

<div class="page-header">
    <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white me-2">
            <i class="mdi mdi-barcode-scan"></i>
        </span> 
        Scanner Barcode
    </h3>
</div>

<div class="row">
    {{-- KOLOM KAMERA / UPLOAD --}}
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card shadow-sm" style="border-radius: 15px;">
            <div class="card-body text-center p-4">
                <h4 class="card-title text-dark mb-4">Arahkan Kamera atau Upload Barcode</h4>
                
                {{-- Tempat Kamera / File Input --}}
                <div id="reader"></div>

                {{-- Audio Beep --}}
                <audio id="beepSound" src="/audio/beep.mp3" preload="auto"></audio>
                
                {{-- Tombol Scan Ulang (Muncul pas sukses) --}}
                <button id="btnRestart" class="btn btn-gradient-info mt-4 w-100" style="display: none; border-radius: 30px;" onclick="location.reload()">
                    <i class="mdi mdi-refresh me-1"></i> Ulangi Scan
                </button>
            </div>
        </div>
    </div>

    {{-- KOLOM HASIL SCAN --}}
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card result-card-custom" id="resultCard" style="display: none;">
            <div class="card-body text-center d-flex flex-column justify-content-center p-5">
                <div class="mb-4">
                    <div style="width: 80px; height: 80px; background: #1bcfb4; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; box-shadow: 0 5px 15px rgba(27, 207, 180, 0.4);">
                        <i class="mdi mdi-check text-white" style="font-size: 50px;"></i>
                    </div>
                    <h3 class="text-success mt-4 font-weight-bold">Scan Berhasil!</h3>
                </div>
                
                <div class="bg-white p-4 rounded-3 shadow-sm mt-2">
                    <div class="mb-3 border-bottom pb-3">
                        <p class="text-muted mb-1 text-uppercase" style="font-size: 12px; letter-spacing: 1px;">ID Barang</p>
                        <h4 id="resId" class="font-weight-bold text-dark mb-0">-</h4>
                    </div>
                    <div class="mb-3 border-bottom pb-3">
                        <p class="text-muted mb-1 text-uppercase" style="font-size: 12px; letter-spacing: 1px;">Nama Menu</p>
                        <h4 id="resNama" class="font-weight-bold text-primary mb-0">-</h4>
                    </div>
                    <div class="mt-3">
                        <p class="text-muted mb-1 text-uppercase" style="font-size: 12px; letter-spacing: 1px;">Harga</p>
                        <h2 id="resHarga" class="font-weight-bold text-danger mb-0">-</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

<script>
    let html5QrcodeScanner = new Html5QrcodeScanner(
        "reader", { fps: 10, qrbox: {width: 250, height: 100} }, false
    );

    function onScanSuccess(decodedText, decodedResult) {
        // Bunyi BEEP!
        document.getElementById('beepSound').play();

        // Matiin Kamera/Form
        html5QrcodeScanner.clear().then(() => {
            
            // Ambil data ke database
            fetch(`/scan-barcode/get/${decodedText}`)
                .then(response => response.json())
                .then(res => {
                    if(res.success) {
                        document.getElementById('resId').innerText = res.data.idmenu;
                        document.getElementById('resNama').innerText = res.data.nama_menu;
                        document.getElementById('resHarga').innerText = "Rp " + Number(res.data.harga).toLocaleString('id-ID');
                        
                        document.getElementById('resultCard').style.display = 'flex';
                        document.getElementById('btnRestart').style.display = 'inline-block';
                    } else {
                        alert("Barcode terbaca: " + decodedText + " tapi data tidak ditemukan di database!");
                        document.getElementById('btnRestart').style.display = 'inline-block';
                    }
                }).catch(err => console.error("Error Fetch:", err));

        }).catch(error => console.error("Gagal mematikan scanner.", error));
    }

    function onScanFailure(error) {
        // Biarin kosong biar gak menu-menuhin console
    }

    html5QrcodeScanner.render(onScanSuccess, onScanFailure);
</script>
@endsection