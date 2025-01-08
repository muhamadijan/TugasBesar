@extends('layouts.admin')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit Produk</h1>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-edit"></i> Form Edit Produk</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('products.update', $product->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="store_id">Toko</label>
                            <select name="store_id" id="store_id" class="form-control" required>
                                @foreach ($stores as $store)
                                    <option value="{{ $store->id }}" {{ $store->id == $product->store_id ? 'selected' : '' }}>
                                        {{ $store->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="name">Nama Produk</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ $product->name }}" required>
                        </div>

                        <div class="form-group">
                            <label for="sku">SKU</label>
                            <input type="text" name="sku" id="sku" class="form-control" value="{{ $product->sku }}" required>
                        </div>

                        <div class="form-group">
                            <label for="stock">Stok</label>
                            <input type="number" name="stock" id="stock" class="form-control" value="{{ $product->stock }}" required>
                        </div>

                        <div class="form-group">
                            <label for="price">Harga</label>
                            <input type="number" step="0.01" name="price" id="price" class="form-control" value="{{ $product->price }}" required>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Perbarui
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
