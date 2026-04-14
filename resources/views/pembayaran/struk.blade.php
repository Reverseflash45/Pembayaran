<div class="text-center" style="margin-top: 20px;">
    <div>
        {!! QrCode::size(150)->generate($pesanan->idpesanan) !!}
    </div>
    <p>Scan untuk verifikasi pesanan #{{ $pesanan->idpesanan }}</p>
</div>