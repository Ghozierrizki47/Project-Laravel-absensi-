<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use App\Models\Presence;
use App\Models\PresenceDetail;
use App\Models\Laporan;
use App\Models\User;

class SystemSettingsController extends Controller
{
    public function index()
    {
        // System Information
        $systemInfo = [
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
            'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown',
            'server_os' => PHP_OS,
            'memory_limit' => ini_get('memory_limit'),
            'max_execution_time' => ini_get('max_execution_time'),
        ];

        // Database Statistics
        $dbStats = [
            'total_users' => User::count(),
            'total_presences' => Presence::count(),
            'total_presence_details' => PresenceDetail::count(),
            'total_laporans' => Laporan::count(),
            'database_size' => $this->getDatabaseSize(),
        ];

        // Storage Usage
        $storageInfo = [
            'uploads_tanda_tangan' => $this->getDirectorySize(public_path('uploads/tanda-tangan')),
            'storage_app' => $this->getDirectorySize(storage_path('app')),
            'storage_logs' => $this->getDirectorySize(storage_path('logs')),
            'total_storage' => 0, // Will be calculated
        ];
        $storageInfo['total_storage'] = array_sum($storageInfo);

        // System Performance
        $performance = [
            'cache_enabled' => config('cache.default') !== 'array',
            'cache_driver' => config('cache.default'),
            'session_driver' => config('session.driver'),
            'queue_driver' => config('queue.default'),
            'debug_mode' => config('app.debug'),
            'environment' => config('app.env'),
            'memory_usage' => round(memory_get_usage(true) / 1024 / 1024, 2),
            'memory_peak' => round(memory_get_peak_usage(true) / 1024 / 1024, 2),
            'cpu_cores' => $this->getCpuCores(),
        ];

        // Recent Activity (Last 7 days)
        $recentActivity = [
            'new_presences' => Presence::where('created_at', '>=', now()->subDays(7))->count(),
            'new_presence_details' => PresenceDetail::where('created_at', '>=', now()->subDays(7))->count(),
            'new_laporans' => Laporan::where('created_at', '>=', now()->subDays(7))->count(),
        ];

        return view('pages.system-settings', compact(
            'systemInfo',
            'dbStats',
            'storageInfo',
            'performance',
            'recentActivity'
        ));
    }

    private function getDatabaseSize()
    {
        try {
            $database = config('database.connections.mysql.database');
            $result = DB::select("SELECT 
                ROUND(SUM(data_length + index_length) / 1024 / 1024, 2) as size_mb
                FROM information_schema.TABLES 
                WHERE table_schema = ?", [$database]);
            
            return $result[0]->size_mb ?? 0;
        } catch (\Exception $e) {
            return 0;
        }
    }

    private function getDirectorySize($path)
    {
        if (!File::exists($path)) {
            return 0;
        }

        $size = 0;
        foreach (File::allFiles($path) as $file) {
            $size += $file->getSize();
        }

        return round($size / 1024 / 1024, 2); // Convert to MB
    }

    private function getCpuCores()
    {
        try {
            if (PHP_OS_FAMILY === 'Windows') {
                $output = shell_exec('wmic cpu get NumberOfCores');
                if ($output) {
                    preg_match_all('/\d+/', $output, $matches);
                    return isset($matches[0][0]) ? (int)$matches[0][0] : 1;
                }
            } else {
                $output = shell_exec('nproc');
                return $output ? (int)trim($output) : 1;
            }
        } catch (\Exception $e) {
            return 1;
        }
        return 1;
    }

    public function clearCache()
    {
        try {
            Cache::flush();
            return redirect()->route('system-settings')->with('success', 'Cache berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('system-settings')->with('error', 'Gagal menghapus cache: ' . $e->getMessage());
        }
    }
}
