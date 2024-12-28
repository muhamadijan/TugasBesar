@extends('layouts.akun')

@section('content')
<div class="container">
    <h2>Edit Transaksi</h2>
    <form action="{{ route('transactions.update', $transaction) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="store_id" class="form-label">Store</label>
            <select name="store_id" id="store_id" class="form-control" required>
                <option value="" disabled>Pilih Store</option>
                @foreach ($stores as $store)
                <option value="{{ $store->id }}" {{ $transaction->store_id == $store->id ? 'selected' : '' }}>
                    {{ $store->name }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="user_id" class="form-label">Kasir</label>
            <select name="user_id" id="user_id" class="form-control" required>
                <option value="" disabled>Pilih Kasir</option>
                @foreach ($users as $user)
                <option value="{{ $user->id }}" {{ $transaction->user_id == $user->id ? 'selected' : '' }}>
                    {{ $user->name }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="transaction_code" class="form-label">Kode Transaksi</label>
            <input type="text" name="transaction_code" id="transaction_code" class="form-control"
                   value="{{ $transaction->transaction_code }}" required>
        </div>

        <div class="mb-3">
            <label for="total_amount" class="form-label">Total</label>
            <input type="number" name="total_amount" id="total_amount" class="form-control"
                   value="{{ $transaction->total_amount }}" required>
        </div>

        <div class="mb-3">
            <label for="transaction_date" class="form-label">Tanggal</label>
            <input type="date" name="transaction_date" id="transaction_date" class="form-control"
                   value="{{ $transaction->transaction_date->format('Y-m-d') }}" required>
        </div>

        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('transactions.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
