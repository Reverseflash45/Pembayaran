@extends('layouts.app')
@section('content')
<div class="container mt-5">
    <h2>Admin Antrian</h2>
    <table class="table">
        @foreach($antrians as $a)
        <tr>
            <td>{{ $a->nomor }}</td> <td>{{ $a->nama }}</td>
            <td>
                <form action="/antrian/panggil/{{ $a->id }}" method="POST">
                    @csrf <button class="btn btn-success">Panggil</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endsection