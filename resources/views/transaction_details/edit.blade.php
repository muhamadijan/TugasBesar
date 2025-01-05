@extends('layouts.akun')

@section('content')
<div class="container">
    <h1>Edit Detail Transaksi</h1>
    <form action="{{ route('transaction_details.update', $transactionDetail->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="transaction_id" class="form-label">Transaksi</label>
            <select name="transaction_id" id="transaction_id" class="form-control" required>
                @foreach($transactions as $transaction)
                <option value="{{ $transaction->id }}" {{ $transactionDetail->transaction_id == $transaction->id ? 'selected' : '' }}>
                    Kode: {{ $transaction->transaction_code }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="product_id" class="form-label">Produk</label>
            <select name="product_id" id="product_id" class="form-control" required>
                @foreach($products as $product)
                <option value="{{ $product->id }}" {{ $transactionDetail->product_id == $product->id ? 'selected' : '' }}>
                    {{ $product->name }} - {{ number_format($product->price, 2) }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="quantity" class="form-label">Jumlah</label>
            <input type="number" name="quantity" id="quantity" class="form-control" value="{{ $transactionDetail->quantity }}" min="1" required>
        </div>
        <button type="submit" class="btn btn-success">Perbarui</button>
    </form>
</div>
@endsection
