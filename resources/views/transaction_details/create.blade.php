@extends('layouts.akun')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Tambah Detail Transaksi</h1>
    <form action="{{ route('transaction_details.store') }}" method="POST">
        @csrf
        <!-- Dropdown untuk Transaksi -->
        <div class="mb-3">
            <label for="transaction_id" class="form-label">Transaksi</label>
            <select name="transaction_id" id="transaction_id" class="form-control @error('transaction_id') is-invalid @enderror" required>
                <option value="" selected disabled>Pilih Transaksi</option>
                @foreach($transactions as $transaction)
                    <option value="{{ $transaction->id }}" {{ old('transaction_id') == $transaction->id ? 'selected' : '' }}>
                        Kode: {{ $transaction->transaction_code }}
                    </option>
                @endforeach
            </select>
            @error('transaction_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Dropdown untuk Produk -->
        <div class="mb-3">
            <label for="product_id" class="form-label">Produk</label>
            <select name="product_id" id="product_id" class="form-control @error('product_id') is-invalid @enderror" required>
                <option value="" selected disabled>Pilih Produk</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                        {{ $product->name }} - Rp{{ number_format($product->price, 2, ',', '.') }}
                    </option>
                @endforeach
            </select>
            @error('product_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Input Jumlah -->
        <div class="mb-3">
            <label for="quantity" class="form-label">Jumlah</label>
            <input type="number" name="quantity" id="quantity" class="form-control @error('quantity') is-invalid @enderror" value="{{ old('quantity') }}" min="1" required>
            @error('quantity')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="subtotal" class="form-label">Subtotal</label>
            <input type="number" name="subtotal" id="subtotal" class="form-control @error('subtotal') is-invalid @enderror" value="{{ old('subtotal') }}" readonly>
            @error('subtotal')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Tombol Simpan -->
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
