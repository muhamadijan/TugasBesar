@extends('layouts.akun')

@section('content')
<div class="container">
    <h1>Daftar Audit Log</h1>

    <table class="table table-bordered">
        <thead>
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

    <div class="d-flex justify-content-center">
        {{ $auditLogs->links() }}
    </div>
</div>
@endsection
