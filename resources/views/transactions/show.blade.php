@extends('layouts.akun')

@section('content')
<div class="container">
    <h2>Detail Transaksi #{{ $transaction->transaction_code }}</h2>

    <div class="mb-3">
        <strong>Toko:</strong> {{ $transaction->store->name }} <br>
        <strong>Kasir:</strong> {{ $transaction->user->name }} <br>
        <strong>Tanggal Transaksi:</strong> {{ \Carbon\Carbon::parse($transaction->transaction_date)->format('d M Y') }} <br>
        <strong>Total Pembayaran:</strong> Rp {{ number_format($totalAmount, 2, ',', '.') }} <br>
    </div>

    <h3>Daftar Produk:</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Produk</th>
                <th>Harga</th>
                <th>Kuantitas</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transaction->products as $product)
            <tr>
                <td>{{ $product->name }}</td>
                <td>Rp {{ number_format($product->price, 2, ',', '.') }}</td>
                <td>{{ $product->pivot->quantity }}</td>
                <td>Rp {{ number_format($product->pivot->quantity * $product->price, 2, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('transactions.index') }}" class="btn btn-primary">Kembali</a>
</div>
@endsection
