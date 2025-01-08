@extends('layouts.admin')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Daftar Stores</h1>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-store"></i> Tabel Stores</h4>
                </div>
                <div class="card-body">
                    @if(auth()->user()->role === 'owner')
                        <a href="{{ route('stores.create') }}" class="btn btn-primary mb-3">
                            <i class="fas fa-plus"></i> Tambah Store
                        </a>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Lokasi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($stores as $store)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $store->name }}</td>
                                    <td>{{ $store->location }}</td>
                                    <td>
                                        <!-- Izin Edit Store -->
                                        @can('edit-store', $store)
                                            <a href="{{ route('stores.edit', $store) }}" class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endcan

                                        <!-- Izin Delete Store -->
                                        @can('delete-store', $store)
                                            <form action="{{ route('stores.destroy', $store) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endcan
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
