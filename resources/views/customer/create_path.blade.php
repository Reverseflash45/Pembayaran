@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card">
        <div class="card-header bg-success text-white">
            <h4 class="mb-0">Tambah Customer 2 (Simpan FILE PATH ke Folder)</h4>
        </div>
        <div class="card-body">
            <form id="formPath">
                @csrf
                <div class="mb-3">
                    <label>Nama Customer</label>
                    <input type="text" name="nama" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Alamat</label>
                    <textarea name="alamat" class="form-control"></textarea>
                </div>

                <div class="row text-center">
                    <div class="col-md-6">
                        <label>Kamera</label>
                        <div id="my_camera" class="mx-auto border" style="width:320px; height:240px;"></div>
                        <button type="button" class="btn btn-primary btn-sm mt-2" onclick="take_snapshot()">AMBIL FOTO</button>
                        <input type="hidden" name="image" class="image-tag">
                    </div>
                    <div class="col-md-6">
                        <label>Hasil Snapshot</label>
                        <div id="results" class="mx-auto border" style="width:320px; height:240px; background:#f8f9fa; line-height:240px;">Foto muncul di sini</div>
                    </div>
                </div>

                <button type="submit" class="btn btn-success mt-4 w-100">SIMPAN (FILE PATH)</button>
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

    // Ajax untuk simpan PATH
    document.getElementById('formPath').onsubmit = function(e) {
        e.preventDefault();
        let formData = new FormData(this);

        fetch("{{ route('customer.store2') }}", {
            method: "POST",
            body: formData,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        })
        .then(response => response.json())
        .then(data => {
            alert(data.success);
            window.location.href = "{{ route('customer.index') }}";
        })
        .catch(err => alert("Error: Pastikan foto sudah diambil!"));
    };
</script>
@endsection