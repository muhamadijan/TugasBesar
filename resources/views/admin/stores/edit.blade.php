@extends('layouts.akun')

@section('content')
<div class="container">
    <h1>Edit Store</h1>
    <form action="{{ route('stores.update', $store) }}" method="POST">
        @csrf
        @method('PATCH')
        <div class="form-group">
            <label for="name">Nama</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $store->name }}" required>
        </div>
        <div class="form-group">
            <label for="location">Lokasi</label>
            <input type="text" name="location" id="location" class="form-control" value="{{ $store->location }}" required>
        </div>
        <button type="submit" class="btn btn-success mt-3">Simpan</button>
        <a href="{{ route('stores.index') }}" class="btn btn-secondary mt-3">Batal</a>
    </form>
</div>
@endsection
