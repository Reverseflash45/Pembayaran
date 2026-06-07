@extends('layouts.app')
@section('content')
<div class="container text-center mt-5">
    <button onclick="mulaiPapan()" class="btn btn-danger">Aktifkan Suara</button>
    <div class="card p-5 mt-3">
        <h1 id="nomor">-</h1> 
        <h2 id="nama">-</h2>
    </div>
    <audio id="audio" src="/tingdong.mp3"></audio>
</div>

<script>
    let isAktif = false; 
    let lastId = null;

    function mulaiPapan() { 
        isAktif = true; 
        alert('Papan Antrian Aktif');
    }

    const source = new EventSource("{{ route('sse.antrian') }}");
    
    source.addEventListener('queue-update', function(event) {
        try {
            const data = JSON.parse(event.data);
            if(data.dipanggil) {
                if(data.dipanggil.id !== lastId) {
                    document.getElementById('nomor').innerText = data.dipanggil.nomor;
                    document.getElementById('nama').innerText = data.dipanggil.nama;
                    
                    if(isAktif) {
                        lastId = data.dipanggil.id;
                        playSuara(data.dipanggil.nomor, data.dipanggil.nama);
                    }
                }
            }
        } catch (e) {
            console.log("Menunggu data...");
        }
    });

    function playSuara(nomor, nama) {
        window.speechSynthesis.cancel();
        const audio = document.getElementById('audio');
        audio.play().catch(e => console.log('Izin audio diperlukan'));
        
        audio.onended = () => {
            const msg = new SpeechSynthesisUtterance('Nomor antrian ' + nomor + ', atas nama ' + nama + ', silakan masuk.');
            msg.lang = 'id-ID';
            window.speechSynthesis.speak(msg);
        };
    }
</script>
@endsection