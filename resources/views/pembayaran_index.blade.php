@extends('layouts.app')

@section('content')
<div class="page-header">
  <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white me-2">
      <i class="mdi mdi-home"></i>
    </span> Pemesanan Makanan Online
  </h3>
</div>

<div class="row">
  <div class="col-md-8 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Daftar Menu</h4>
        <div class="row">
          @foreach($menus as $m)
          <div class="col-md-6 mb-4">
            <div class="card border shadow-sm">
              <div class="card-body p-3">
                <h5 class="mb-1">{{ $m->nama_menu }}</h5>
                <p class="text-muted small">Vendor: {{ $m->vendor->nama_vendor }}</p>
                <h4 class="text-primary">Rp {{ number_format($m->harga) }}</h4>
                <button class="btn btn-gradient-primary btn-sm w-100 mt-2 btn-tambah" 
                        data-id="{{ $m->idmenu }}" 
                        data-nama="{{ $m->nama_menu }}" 
                        data-harga="{{ $m->harga }}">
                    + Tambah
                </button>
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-4 grid-margin stretch-card">
    <div class="card bg-gradient-danger card-img-holder text-white">
      <div class="card-body">
        <h4 class="font-weight-normal mb-3">Ringkasan Belanja <i class="mdi mdi-cart-outline mdi-24px float-right"></i></h4>
        <h6 class="card-text">Customer: <span id="guest-id">Guest_0000001</span></h6>
        <hr>
        
        <ul id="list-keranjang" class="list-group list-group-flush text-dark mb-3">
            </ul>

        <div class="d-flex justify-content-between align-items-center">
            <h5>Total:</h5>
            <h5 id="total-harga">Rp 0</h5>
        </div>

        <button id="bayar-btn" class="btn btn-light w-100 mt-4 fw-bold text-danger" disabled>
            BAYAR SEKARANG
        </button>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
    let keranjang = [];
    let totalHarga = 0;

    // 1. Logika Klik Tombol Tambah
    document.querySelectorAll('.btn-tambah').forEach(button => {
        button.onclick = function() {
            const id = this.getAttribute('data-id');
            const nama = this.getAttribute('data-nama');
            const harga = parseInt(this.getAttribute('data-harga'));

            keranjang.push({ id, nama, harga });
            totalHarga += harga;

            updateTampilanKeranjang();
        }
    });

    function updateTampilanKeranjang() {
        const list = document.getElementById('list-keranjang');
        const btnBayar = document.getElementById('bayar-btn');
        list.innerHTML = '';

        keranjang.forEach((item, index) => {
            list.innerHTML += `<li class="list-group-item d-flex justify-content-between align-items-center small">
                ${item.nama} <span>Rp ${item.harga.toLocaleString()}</span>
            </li>`;
        });

        document.getElementById('total-harga').innerText = `Rp ${totalHarga.toLocaleString()}`;
        
        // Aktifkan tombol bayar jika ada item
        btnBayar.disabled = keranjang.length === 0;
    }

    // 2. Logika Klik Tombol Bayar (Integrasi Midtrans)
    document.getElementById('bayar-btn').onclick = function() {
        this.innerHTML = '<i class="mdi mdi-loading mdi-spin"></i> Loading...';
        
        fetch("{{ route('checkout') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                total_bayar: totalHarga,
                items: keranjang
            })
        })
        .then(response => response.json())
        .then(data => {
            this.innerHTML = 'BAYAR SEKARANG';
            
            // Panggil popup Midtrans
            window.snap.pay(data.token, {
                onSuccess: function(result){ 
                    alert("Pembayaran Berhasil!"); 
                    window.location.reload(); 
                },
                onPending: function(result){ 
                    alert("Selesaikan pembayaranmu."); 
                },
                onError: function(result){ 
                    alert("Pembayaran Gagal."); 
                }
            });
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan sistem.');
            this.innerHTML = 'BAYAR SEKARANG';
        });
    };
</script>
@endpush