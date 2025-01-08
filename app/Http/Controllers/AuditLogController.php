<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    /**
     * Menampilkan daftar log aktivitas.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Periksa apakah pengguna memiliki peran 'owner' atau 'supervisor'
        if (!in_array(auth()->user()->role, ['owner', 'supervisor'])) {
            abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        $auditLogs = AuditLog::with('user')->latest()->paginate(10);

        return view('audit_logs.index', compact('auditLogs'));
    }


    /**
     * Menyimpan log aktivitas.
     * Biasanya dipanggil otomatis dari proses lain.
     *
     * @param int $userId
     * @param string $action
     * @param string $module
     * @param string|null $description
     * @param string|null $ipAddress
     * @param string|null $userAgent
     * @return void
     */
    public static function store($userId, $action, $module, $description = null)
    {
        AuditLog::create([
            'user_id' => $userId,
            'action' => $action,
            'module' => $module,
            'description' => $description,
            'ip_address' => request()->ip(),
            'user_agent' => request()->header('User-Agent'),
            'activity' => $description ?? 'Tidak ada deskripsi',
            'created_at' => now(),
        ]);
    }

}
