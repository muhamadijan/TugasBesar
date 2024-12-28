@extends('layouts.akun')

@section('content')
<div class="container">
    <h1>Tambah Akun Baru</h1>
    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Nama</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="password_confirmation">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
        </div>
        <div class="form-group">
            <div class="form-group">
                <label for="role">Role</label>
                <select name="role" id="role" class="form-control" required>
                    <option value="manager">Manager</option>
                    <option value="supervisor">Supervisor</option>
                    <option value="cashier">Cashier</option>
                    <option value="warehouse_staff">Warehouse Staff</option>
                </select>
            </div>

        <div class="form-group">
            <label for="store_id">Store</label>
            <select name="store_id" id="store_id" class="form-control">
                <option value="">Tidak Ada</option>
                @foreach($stores as $store)
                <option value="{{ $store->id }}">{{ $store->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
