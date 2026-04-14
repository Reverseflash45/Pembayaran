@extends('layouts.app')
@section('content')
<div class="container">
    <h3>Tambah Customer 1 (Simpan BLOB ke DB)</h3>
    <form id="formBlob">
        @csrf
        <input type="text" name="nama" placeholder="Nama" class="form-control mb-2" required>
        <textarea name="alamat" placeholder="Alamat" class="form-control mb-2"></textarea>
        <div id="my_camera"></div>
        <button type="button" class="btn btn-primary mt-2" onclick="take_snapshot()">Ambil Foto</button>
        <input type="hidden" name="image" class="image-tag">
        <div id="results" class="mt-2"></div>
        <button type="submit" class="btn btn-success mt-2">Simpan ke DB (Blob)</button>
    </form>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js"></script>
<script>
    Webcam.set({ width: 320, height: 240, image_format: 'jpeg', jpeg_quality: 90 });
    Webcam.attach('#my_camera');
    function take_snapshot() {
        Webcam.snap(function(data_uri) {
            document.querySelector(".image-tag").value = data_uri;
            document.getElementById('results').innerHTML = '<img src="'+data_uri+'"/>';
        });
    }
    document.getElementById('formBlob').onsubmit = function(e) {
        e.preventDefault();
        fetch("{{ route('customer.store1') }}", {
            method: "POST",
            body: new FormData(this),
            headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}" }
        }).then(res => res.json()).then(data => { alert(data.success); location.href="{{ route('customer.index') }}"; });
    };
</script>
@endsection