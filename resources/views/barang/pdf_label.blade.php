@extends('layouts.app') {{-- Atau ganti ke layout khusus print kalau ada --}}

@section('content')
<style>
    /* Paksa sembunyikan Navbar & Sidebar pas di-print */
    @media print {
        .navbar, .sidebar, .footer, .btn, .page-header {
            display: none !important;
        }
        .content-wrapper {
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
        }
        body {
            background: white !important;
        }
    }

    /* CSS Label TnJ 108 */
    @page { 
        size: 21cm 29.7cm; 
        margin: 0; 
    }
    
    .label-table {
        border-collapse: collapse;
        table-layout: fixed;
        width: 19cm;
        margin-left: 0.5cm;
        margin-top: 0.5cm;
        background: white;
    }

    .label-table td { 
        width: 3.8cm; 
        height: 1.9cm; 
        border: 0.1pt solid #ccc; 
        text-align: center; 
        vertical-align: middle; 
        padding: 5px; 
        box-sizing: border-box; 
        overflow: hidden;
    }

    .barcode-img { width: 80%; height: 25px; margin-bottom: 2px; }
    .text-id { font-size: 8px; font-weight: bold; display: block; }
    .text-nama { font-size: 7px; display: block; text-transform: uppercase; }
    .text-harga { font-size: 9px; font-weight: bold; display: block; }
</style>

<div class="d-print-none mb-3">
    <button onclick="window.print()" class="btn btn-primary">Klik Print Lagi Kalau Gak Muncul</button>
</div>

<table class="label-table">
    @php
        $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
        $idx = 0;
        $currentCell = 1;
    @endphp

    @for ($row = 0; $row < 8; $row++)
        <tr>
            @for ($col = 0; $col < 5; $col++)
                <td>
                    @if ($currentCell > $skip && isset($barangs[$idx]))
                        @php
                            $b = $barangs[$idx];
                            $id = $b->idmenu;
                            $nama = $b->nama_menu;
                            $barcode = base64_encode($generator->getBarcode($id, $generator::TYPE_CODE_128));
                            $idx++;
                        @endphp
                        <img src="data:image/png;base64,{{ $barcode }}" class="barcode-img">
                        <span class="text-id">{{ $id }}</span>
                        <span class="text-nama">{{ \Illuminate\Support\Str::limit($nama, 20) }}</span>
                        <span class="text-harga">Rp {{ number_format($b->harga, 0, ',', '.') }}</span>
                    @endif
                </td>
                @php $currentCell++; @endphp
            @endfor
        </tr>
    @endfor
</table>

<script>
    // Langsung print pas halaman ke-load
    window.onload = function() {
        window.print();
    }
</script>
@endsection