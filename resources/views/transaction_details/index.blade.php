@extends('layouts.akun')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Detail Transaksi</h1>
        </div>
        <div class="section-body">
            @if(auth()->user()->role === 'cashier')
            <a href="{{ route('transaction_details.create') }}" class="btn btn-primary mb-3">Tambah Detail Transaksi</a>
        @endif
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Transaksi</th>
                            <th>Produk</th>
                            <th>Jumlah</th>
                            <th>Subtotal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactionDetails as $detail)
                        <tr>
                            <td>{{ $detail->id }}</td>
                            <td>{{ $detail->transaction->transaction_code }}</td>
                            <td>{{ $detail->product->name }}</td>
                            <td>{{ $detail->quantity }}</td>
                            <td>{{ number_format($detail->subtotal, 2) }}</td>
                            <td>
                                <a href="{{ route('transaction_details.edit', $detail->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('transaction_details.destroy', $detail->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus detail transaksi ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $transactionDetails->links() }}
        </div>
    </section>
</div>
@endsection
