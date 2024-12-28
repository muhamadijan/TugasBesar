@extends('layouts.akun')

@section('content')
<div class="container">
    <h1>Tambah Store</h1>
    <form action="{{ route('stores.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Nama</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="location">Lokasi</label>
            <input type="text" name="location" id="location" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success mt-3">Simpan</button>
        <a href="{{ route('stores.index') }}" class="btn btn-secondary mt-3">Batal</a>
    </form>
</div>
@endsection
