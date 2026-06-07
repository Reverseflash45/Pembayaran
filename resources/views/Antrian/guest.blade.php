@extends('layouts.app')
@section('content')
<div class="container mt-5">
    <h2>Ambil Antrian</h2>
    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
    <form action="" method="POST"> @csrf
        <input type="text" name="nama" class="form-control" placeholder="Nama" required>
        <button class="btn btn-primary mt-2">Daftar</button>
    </form>
</div>
@endsection