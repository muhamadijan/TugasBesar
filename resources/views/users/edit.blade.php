@extends('layouts.admin')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit Akun</h1>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-user-edit"></i> Form Edit Akun</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('users.update', $user) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ $user->name }}" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control" value="{{ $user->email }}" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password (Kosongkan jika tidak diubah)</label>
                            <input type="password" name="password" id="password" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="role">Role</label>
                            <select name="role" id="role" class="form-control" required>
                                <option value="manager" {{ $user->role == 'manager' ? 'selected' : '' }}>Manager</option>
                                <option value="supervisor" {{ $user->role == 'supervisor' ? 'selected' : '' }}>Supervisor</option>
                                <option value="cashier" {{ $user->role == 'cashier' ? 'selected' : '' }}>Cashier</option>
                                <option value="warehouse_staff" {{ $user->role == 'warehouse_staff' ? 'selected' : '' }}>Warehouse Staff</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="store_id">Store</label>
                            <select name="store_id" id="store_id" class="form-control">
                                <option value="">Tidak Ada</option>
                                @foreach($stores as $store)
                                <option value="{{ $store->id }}" {{ $user->store_id == $store->id ? 'selected' : '' }}>{{ $store->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
