@extends('layouts.akun')

@section('content')
<div class="container">
    <div class="receipt">
        <div class="receipt-header">
            <h2 class="text-center">Toko {{ $transaction->store->name }}</h2>
            <p class="text-center">Alamat: {{ $transaction->store->location }}</p>
            <hr>
        </div>

        <div class="receipt-details">
            <p><strong>Kasir:</strong> {{ $transaction->user->name }}</p>
            <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($transaction->transaction_date)->format('d M Y, H:i') }}</p>
            <p><strong>Transaksi ID:</strong> #{{ $transaction->transaction_code }}</p>
            <hr>
        </div>

        <div class="receipt-products">
            <table>
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th class="text-center">Qty</th>
                        <th class="text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transaction->products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td class="text-center">{{ $product->pivot->quantity }}</td>
                        <td class="text-right">Rp {{ number_format($product->pivot->quantity * $product->price, 2, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <hr>
        </div>

        <div class="receipt-total">
            <p class="text-right"><strong>Total:</strong> Rp {{ number_format($totalAmount, 2, ',', '.') }}</p>
        </div>

        <div class="receipt-footer">
            <p class="text-center">--- Terima Kasih ---</p>
        </div>
    </div>

    <div class="text-center mt-4">
        <a href="{{ route('transactions.index') }}" class="btn btn-primary">Kembali</a>
    </div>
</div>

@endsection

@section('styles')
<style>
    .receipt {
        width: 58mm; /* Lebar sesuai permintaan */
        max-height: 48mm; /* Tinggi dinamis */
        padding: 5mm;
        margin: 0 auto;
        border: 1px dashed #000; /* Border bergaya struk */
        font-family: 'Courier New', Courier, monospace;
        background-color: #fff;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        overflow: hidden; /* Untuk menjaga batas isi */
    }

    .receipt-header h2 {
        font-size: 14px;
        margin: 0;
    }

    .receipt-header p {
        font-size: 10px;
        margin: 5px 0;
    }

    .receipt-details p {
        font-size: 10px;
        margin: 5px 0;
    }

    .receipt-products table {
        width: 100%;
        margin: 5px 0;
        border-collapse: collapse;
        font-size: 10px;
    }

    .receipt-products th,
    .receipt-products td {
        padding: 2px 0;
    }

    .receipt-products th {
        border-bottom: 1px solid #000;
    }

    .receipt-products td {
        vertical-align: top;
    }

    .text-center {
        text-align: center;
    }

    .text-right {
        text-align: right;
    }

    .receipt-total p {
        font-size: 12px;
        font-weight: bold;
    }

    .receipt-footer p {
        font-size: 10px;
        font-style: italic;
        margin-top: 10px;
    }
</style>
@endsection
