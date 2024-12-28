@extends('layouts.akun')

@section('content')
<div class="container">
    <h2>Daftar Transaksi</h2>
    <a href="{{ route('transactions.create') }}" class="btn btn-primary mb-3">Tambah Transaksi</a>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Store</th>
                <th>Kasir</th>
                <th>Kode Transaksi</th>
                <th>Total</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $transaction)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $transaction->store->name }}</td>
                <td>{{ $transaction->user->name }}</td>
                <td>{{ $transaction->transaction_code }}</td>
                <td>{{ number_format($transaction->total_amount, 2) }}</td>
                <td>{{ $transaction->transaction_date }}</td>
                <td>
                    <a href="{{ route('transactions.edit', $transaction) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('transactions.destroy', $transaction) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7">Tidak ada transaksi.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    {{ $transactions->links() }}
</div>
@endsection
