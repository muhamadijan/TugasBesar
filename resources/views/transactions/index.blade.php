@extends('layouts.admin')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Daftar Transaksi</h1>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-exchange-alt"></i> Data Transaksi</h4>
                    @if(auth()->user()->role === 'cashier')
                        <a href="{{ route('transactions.create') }}" class="btn btn-primary">Tambah Transaksi</a>
                    @endif
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="thead-dark">
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
                                        @if(auth()->user()->role === 'cashier')
                                            <a href="{{ route('transactions.show', $transaction->id) }}" class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        @elseif(auth()->user()->role === 'owner')
                                            <a href="{{ route('transactions.edit', $transaction) }}" class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('transactions.destroy', $transaction) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">
                                                    <i class="fas fa-trash-alt"></i> 
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada transaksi.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center">
                        {{ $transactions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
