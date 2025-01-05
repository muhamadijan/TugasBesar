@extends('layouts.akun')

@section('content')
<div class="container">
    <h1>Daftar Produk</h1>
    @if(auth()->user()->role === 'warehouse_staff')
    <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">Tambah Produk</a>
@endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama</th>
                <th>SKU</th>
                <th>Stok</th>
                <th>Harga</th>
                <th>Toko</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->sku }}</td>
                <td>{{ $product->stock }}</td>
                <td>{{ number_format($product->price, 2) }}</td>
                <td>{{ $product->store->name }}</td>
                <td>
                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus produk ini?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $products->links() }}
</div>
@endsection
