@extends('layouts.akun')

@section('content')
<div class="container">
    <h1>Daftar Stores</h1>
    <a href="{{ route('stores.create') }}" class="btn btn-primary mb-3">Tambah Store</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama</th>
                <th>Lokasi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($stores as $store)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $store->name }}</td>
                <td>{{ $store->location }}</td>
                <td>
                    <a href="{{ route('stores.edit', $store) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('stores.destroy', $store) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
