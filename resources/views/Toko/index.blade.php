@extends('layouts.app')

@section('content')
<div class="page-header">
    <h3 class="page-title"> Master Data Toko (Geolocation) </h3>
</div>

<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h4 class="card-title mb-4">Tambah Toko Baru</h4>
                <form action="{{ route('toko.store') }}" method="POST">
                    @csrf
                    <div class="row align-items-end">
                        <div class="col-md-2 mb-3">
                            <label class="fw-bold">Barcode (ID)</label>
                            <input type="text" name="barcode" class="form-control" required>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="fw-bold">Nama Toko</label>
                            <input type="text" name="nama_toko" class="form-control" required>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="fw-bold">Latitude</label>
                            <input type="number" step="any" name="latitude" id="latitude" class="form-control" required readonly>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="fw-bold">Longitude</label>
                            <input type="number" step="any" name="longitude" id="longitude" class="form-control" required readonly>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="fw-bold">Accuracy (m)</label>
                            <input type="number" name="accuracy" id="accuracy" class="form-control" required readonly>
                        </div>
                        <div class="col-md-2 mb-3 d-flex flex-column">
                            <button type="button" class="btn btn-sm btn-info fw-bold text-white mb-2" onclick="getLocation()">
                                <i class="mdi mdi-crosshairs-gps"></i> Ambil Lokasi
                            </button>
                            <button type="submit" class="btn btn-sm btn-gradient-primary">
                                <i class="mdi mdi-content-save"></i> Save Data
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <small id="loc-status" class="text-danger fw-bold"></small>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-12 grid-margin stretch-card mt-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h4 class="card-title mb-4">List Toko</h4>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover text-center">
                        <thead class="table-dark">
                            <tr>
                                <th>Barcode</th>
                                <th>Nama Toko</th>
                                <th>Latitude</th>
                                <th>Longitude</th>
                                <th>Accuracy</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tokos as $toko)
                            <tr>
                                <td class="align-middle fw-bold">{{ $toko->barcode }}</td>
                                <td class="align-middle">{{ $toko->nama_toko }}</td>
                                <td class="align-middle">{{ $toko->latitude }}</td>
                                <td class="align-middle">{{ $toko->longitude }}</td>
                                <td class="align-middle text-success fw-bold">{{ $toko->accuracy }} m</td>
                                <td class="align-middle">
                                    <button class="btn btn-sm btn-gradient-info fw-bold" onclick="cetakBarcode('{{ $toko->barcode }}')">
                                        <i class="mdi mdi-printer"></i> Cetak Barcode
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function cetakBarcode(barcode) {
        let printWindow = window.open('', '_blank');
        printWindow.document.write(`
            <html>
                <head><title>Cetak Barcode</title></head>
                <body style="text-align:center; padding-top: 50px; font-family: sans-serif;">
                    <h2>${barcode}</h2>
                    <img src="https://barcode.tec-it.com/barcode.ashx?data=${barcode}&code=Code128" alt="Barcode" />
                    <br><br>
                    <button onclick="window.print()" style="padding: 10px 20px; font-size: 16px; cursor: pointer; background-color: #007bff; color: white; border: none; border-radius: 5px;">Print Kertas Label</button>
                </body>
            </html>
        `);
        printWindow.document.close();
    }

    function getAccuratePosition(targetAccuracy = 50, maxWait = 20000) {
        return new Promise((resolve, reject) => {
            let bestResult = null;
            const startTime = Date.now();
            const watchId = navigator.geolocation.watchPosition(
                (position) => {
                    const acc = position.coords.accuracy;
                    if (!bestResult || acc < bestResult.coords.accuracy) {
                        bestResult = position;
                    }
                    if (acc <= targetAccuracy) {
                        navigator.geolocation.clearWatch(watchId);
                        resolve(bestResult);
                    }
                    if (Date.now() - startTime >= maxWait) {
                        navigator.geolocation.clearWatch(watchId);
                        if (bestResult) resolve(bestResult);
                        else reject(new Error("Timeout, tidak dapat posisi"));
                    }
                },
                (error) => reject(error),
                { enableHighAccuracy: true, maximumAge: 0, timeout: maxWait }
            );
        });
    }

    async function getLocation() {
        const statusText = document.getElementById('loc-status');
        statusText.innerText = "Mencari lokasi paling akurat... (Mohon izinkan akses lokasi di browser)";
        statusText.className = "text-warning fw-bold";
        
        try {
            const pos = await getAccuratePosition(50);
            document.getElementById('latitude').value = pos.coords.latitude;
            document.getElementById('longitude').value = pos.coords.longitude;
            document.getElementById('accuracy').value = Math.round(pos.coords.accuracy);
            statusText.innerText = "Lokasi berhasil ditemukan!";
            statusText.className = "text-success fw-bold";
        } catch (error) {
            statusText.innerText = "Gagal: " + error.message;
            statusText.className = "text-danger fw-bold";
        }
    }
</script>
@endsection