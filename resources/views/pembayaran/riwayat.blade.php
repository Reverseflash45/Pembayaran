@foreach($pesanans as $p)
<tr>
    <td>{{ $p->idpesanan }}</td>
    <td>{{ $p->nama_customer }}</td>
    <td>Rp {{ number_format($p->total) }}</td>
<td>
    @if($p->status_bayar == 'Lunas')
        <label class="badge badge-success text-white">Lunas</label>
        <div class="mt-3">

    {!! SimpleSoftwareIO\QrCode\Facades\QrCode::size(80)->generate($p->idpesanan) !!}
            <br>
            <small class="text-muted">Scan ID: {{ $p->idpesanan }}</small>
        </div>
    @else
        <label class="badge badge-warning text-white">Pending</label>
    @endif
</td>
@endforeach