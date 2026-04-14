@extends('layouts.app') {{-- Sesuaikan dengan nama layout lu, misal layouts.app atau layouts.main --}}

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">Tambah Customer (Akses Kamera)</div>
        <div class="card-body">
            <form action="{{ route('customer.store') }}" method="POST">
                @csrf
                <div class="form-group mb-3">
                    <label>Nama Customer</label>
                    <input type="text" name="nama" class="form-control" required>
                </div>
                <div class="form-group mb-3">
                    <label>Alamat</label>
                    <textarea name="alamat" class="form-control"></textarea>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label>Kamera</label>
                        <div id="my_camera" class="border" style="width: 320px; height: 240px;"></div>
                        <br/>
                        <button type="button" class="btn btn-primary" onclick="take_snapshot()">Ambil Foto</button>
                        <input type="hidden" name="image" class="image-tag">
                    </div>
                    <div class="col-md-6 text-center">
                        <label>Hasil Snapshot</label>
                        <div id="results" class="border" style="width: 320px; height: 240px; line-height: 240px; background: #eee;">Hasil akan muncul di sini</div>
                    </div>
                </div>

                <button type="submit" class="btn btn-success mt-4 w-100">Simpan Data Customer</button>
            </form>
        </div>
    </div>
</div>

{{-- Script Webcam.js --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js"></script>
<script>
    Webcam.set({
        width: 320,
        height: 240,
        image_format: 'jpeg',
        jpeg_quality: 90
    });
    Webcam.attach('#my_camera');

    function take_snapshot() {
        Webcam.snap(function(data_uri) {
            document.querySelector(".image-tag").value = data_uri;
            document.getElementById('results').innerHTML = '<img src="'+data_uri+'" style="width:320px; height:240px;"/>';
        });
    }
</script>
@endsection