@extends('layouts.akun')

@section('content')
<div class="container">
    <h2>Tambah Transaksi</h2>
    <form action="{{ route('transactions.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="store_id" class="form-label">Toko</label>
            <select name="store_id" id="store_id" class="form-control" required>
                <option value="" disabled selected>Pilih Toko</option>
                @foreach ($stores as $store)
                    <option value="{{ $store->id }}">{{ $store->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="user_id" class="form-label">Kasir</label>
            <select name="user_id" id="user_id" class="form-control" required>
                <option value="" disabled selected>Pilih Kasir</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="transaction_code" class="form-label">Kode Transaksi (Opsional)</label>
            <input type="text" name="transaction_code" id="transaction_code" class="form-control">
        </div>

        <div class="mb-3">
            <label for="total_amount" class="form-label">Total</label>
            <input type="number" name="total_amount" id="total_amount" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="transaction_date" class="form-label">Tanggal</label>
            <input type="date" name="transaction_date" id="transaction_date" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
    </form>
</div>
@endsection
