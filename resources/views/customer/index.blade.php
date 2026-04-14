@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header bg-dark text-white d-flex justify-content-between">
        <h5 class="mb-0">Data Customer</h5>
        <div>
            <a href="{{ route('customer.create1') }}" class="btn btn-info btn-sm">Tambah (Blob)</a>
            <a href="{{ route('customer.create2') }}" class="btn btn-success btn-sm">Tambah (Path)</a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Foto</th>
                    <th>Tipe Simpan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($customers as $c)
                <tr>
                    <td>{{ $c->nama }}</td>
                    <td>
                        @if($c->foto_blob)
                            {{-- Nampilin BLOB --}}
                            <img src="data:image/png;base64,{{ base64_encode($c->foto_blob) }}" width="80">
                        @elseif($c->foto)
                            {{-- Nampilin Path --}}
                            <img src="{{ asset('storage/customers/'.$c->foto) }}" width="80">
                        @endif
                    </td>
                    <td>
                        <span class="badge {{ $c->foto_blob ? 'bg-info' : 'bg-success' }}">
                            {{ $c->foto_blob ? 'Database (Blob)' : 'Folder (Path)' }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection