@extends('layouts.admin')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Daftar Produk</h1>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-box"></i> Kelola Produk</h4>
                </div>
                <div class="card-body">
                    @if(auth()->user()->role === 'warehouse_staff')
                    <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">
                        <i class="fas fa-plus-circle"></i> Tambah Produk
                    </a>
                    @endif
                    <div class="table-responsive">
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
                                    <td>{{ $product->store->name ?? 'Tidak ada' }}</td>
                                    <td>
                                        @can('edit-product', $product)
                                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @endcan

                                        @can('delete-product', $product)
                                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn =btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                        @endcan
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
