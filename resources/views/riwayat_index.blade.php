@extends('layouts.app')

@section('content')
<div class="page-header">
  <h3 class="page-title"> Riwayat Pesanan </h3>
</div>
<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Daftar Transaksi</h4>
        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>ID Pesanan</th>
                <th>Customer</th>
                <th>Waktu</th>
                <th>Total</th>
                <th>Status & QR</th> {{-- Gue tambahin biar jelas --}}
              </tr>
            </thead>
            <tbody>
              @foreach($pesanans as $p)
              <tr>
                <td>{{ $p->idpesanan }}</td>
                <td>{{ $p->nama_customer }}</td>
                <td>{{ $p->timestamp }}</td>
                <td>Rp {{ number_format($p->total) }}</td>
                <td>
<td>
  <label class="badge {{ $p->status_bayar == 'Lunas' ? 'badge-success' : 'badge-warning' }}">
    {{ ucfirst($p->status_bayar) }}
  </label>

  @if($p->status_bayar == 'Lunas')
    <div class="mt-2">
      <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#qrModal{{ $p->idpesanan }}">
        {!! SimpleSoftwareIO\QrCode\Facades\QrCode::size(50)->generate($p->idpesanan) !!}
      </a>
      <br>
      <small class="text-muted">Klik untuk perbesar</small>
    </div>

    <div class="modal fade" id="qrModal{{ $p->idpesanan }}" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center p-4">
          <div class="modal-header border-0">
            <h5 class="modal-title w-100">QR Code Pesanan #{{ $p->idpesanan }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            {!! SimpleSoftwareIO\QrCode\Facades\QrCode::size(250)->generate($p->idpesanan) !!}
            <h4 class="mt-4 fw-bold">ID: {{ $p->idpesanan }}</h4>
            <p class="text-muted">{{ $p->nama_customer }} - Rp {{ number_format($p->total) }}</p>
          </div>
          <div class="modal-footer border-0 justify-content-center">
            <button type="button" class="btn btn-gradient-primary btn-sm" data-bs-dismiss="modal">Tutup</button>
          </div>
        </div>
      </div>
    </div>
  @endif
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
@endsection