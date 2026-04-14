@extends('layouts.app')

@section('content')
<div class="page-header">
    <h3 class="page-title"> Daftar Barang & Tag Harga </h3>
</div>

<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Cetak Label TnJ 108</h4>
                
                {{-- Form Cetak --}}
                <form action="{{ route('barang.cetak') }}" method="POST" target="_blank">
                    @csrf
                    <div class="row mb-4">
                        <div class="col-md-2">
                            <label>Mulai Kolom (X)</label>
                            <input type="number" name="x" class="form-control" min="1" max="5" value="1">
                        </div>
                        <div class="col-md-2">
                            <label>Mulai Baris (Y)</label>
                            <input type="number" name="y" class="form-control" min="1" max="8" value="1">
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-gradient-danger btn-icon-text mt-4">
                                <i class="mdi mdi-printer btn-icon-prepend"></i> Cetak Label PDF
                            </button>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover text-center">
                            <thead>
                                <tr>
                                    <th>Pilih</th>
                                    <th>ID</th>
                                    <th>Nama Menu</th>
                                    <th>Harga</th>
                                    <th>Barcode Preview</th> {{-- Kolom Barcode --}}
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    // Panggil generator HTML untuk preview di web
                                    $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
                                @endphp

                                @foreach($barangs as $b)
                                <tr>
                                    <td>
                                        <input type="checkbox" name="ids[]" value="{{ $b->idmenu }}">
                                    </td>
                                    <td>{{ $b->idmenu }}</td>
                                    <td>{{ $b->nama_menu }}</td>
                                    <td>Rp {{ number_format($b->harga, 0, ',', '.') }}</td>
                                    <td>
                                        <div class="d-flex flex-column align-items-center">
                                            {{-- Render Barcode di sini --}}
                                            {!! $generator->getBarcode($b->idmenu, $generator::TYPE_CODE_128) !!}
                                            <small class="mt-1">{{ $b->idmenu }}</small>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection