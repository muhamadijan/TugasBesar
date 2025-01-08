@extends('layouts.admin')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Daftar Audit Log</h1>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-list"></i> Audit Log</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Pengguna</th>
                                    <th>Aksi</th>
                                    <th>Modul</th>
                                    <th>Deskripsi</th>
                                    <th>Alamat IP</th>
                                    <th>User Agent</th>
                                    <th>Waktu</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($auditLogs as $log)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $log->user->name ?? 'N/A' }}</td>
                                        <td>{{ $log->action }}</td>
                                        <td>{{ $log->module }}</td>
                                        <td>{{ $log->description ?? '-' }}</td>
                                        <td>{{ $log->ip_address ?? '-' }}</td>
                                        <td>{{ $log->user_agent ?? '-' }}</td>
                                        <td>{{ $log->created_at ? $log->created_at->format('d-m-Y H:i:s') : '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">Tidak ada log aktivitas.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center">
                        {{ $auditLogs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
