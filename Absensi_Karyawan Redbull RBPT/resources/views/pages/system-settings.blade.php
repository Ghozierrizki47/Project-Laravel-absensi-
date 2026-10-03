@extends('layouts.main')

@section('content')
<div class="d-flex" id="dashboard-app">
    <!-- SIDEBAR -->
    <aside id="app-sidebar" class="rb-sidebar d-flex flex-column">
        <div class="sidebar-brand">
            <div class="brand-icon">
                <img src="https://upload.wikimedia.org/wikipedia/id/thumb/3/39/Red_Bull_GmbH_logo.svg/1200px-Red_Bull_GmbH_logo.svg.png" alt="Red Bull" class="rb-logo" style="width: 100%; height: 100%; object-fit: contain;">
            </div>
            <div class="brand-text">
                <h5 class="mb-0">RED BULL</h5>
                <small>RACING TEAM</small>
            </div>
        </div>

        <nav class="nav flex-column sidebar-nav">
            <a href="{{ route('home') }}" class="nav-link">
                <i class="bi bi-speedometer2"></i>
                <span>Dashboard</span>
                <div class="nav-indicator"></div>
            </a>
            <a href="{{ route('presence.index') }}" class="nav-link">
                <i class="bi bi-table"></i>
                <span>Daftar Kegiatan</span>
                <div class="nav-indicator"></div>
            </a>
            <a href="{{ route('presence.create') }}" class="nav-link">
                <i class="bi bi-plus-circle"></i>
                <span>Tambah Kegiatan</span>
                <div class="nav-indicator"></div>
            </a>
            <a href="{{ route('rekap-bulanan') }}" class="nav-link">
                <i class="bi bi-journal-text"></i>
                <span>Rekap Bulanan</span>
                <div class="nav-indicator"></div>
            </a>
            <a href="{{ route('laporan.index') }}" class="nav-link">
                <i class="bi bi-file-earmark-text"></i>
                <span>Laporan</span>
                <div class="nav-indicator"></div>
            </a>
            <a href="{{ route('system-settings') }}" class="nav-link active">
                <i class="bi bi-gear"></i>
                <span>Pengaturan Sistem</span>
                <div class="nav-indicator"></div>
            </a>
            <a href="{{ route('settings') }}" class="nav-link">
                <i class="bi bi-question-circle"></i>
                <span>Bantuan</span>
                <div class="nav-indicator"></div>
            </a>
        </nav>

        <div class="sidebar-footer">
            <div class="user-profile">
                <div class="user-avatar">
                    <i class="bi bi-person-circle"></i>
                </div>
                <div class="user-info">
                    <strong>{{ Auth::user()->name }}</strong>
                    <small>Admin</small>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="mt-3">
                @csrf
                <button type="submit" class="btn-logout w-100">
                    <i class="bi bi-box-arrow-right me-2"></i>Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <div class="main-area flex-fill">
        <div class="racing-stripe"></div>

        <div class="top-bar">
            <div class="d-flex align-items-center">
                <button id="sidebarToggle" class="btn-toggle">
                    <i class="bi bi-list"></i>
                </button>
                <h4 class="page-title mb-0">
                    <i class="bi bi-gear me-2"></i>Pengaturan Sistem
                </h4>
            </div>
            <div class="top-bar-right">
                <button id="themeToggle" class="theme-toggle-btn" title="Toggle Dark/Light Mode">
                    <i class="bi bi-moon-stars"></i>
                    <i class="bi bi-sun"></i>
                </button>
                <div class="live-time">
                    <div id="live-clock" class="clock">--:--:--</div>
                    <div id="live-date" class="date">--</div>
                </div>
            </div>
        </div>

        <div class="settings-content">
            <div class="container-fluid">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-x-circle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="row g-4">
                    <!-- System Performance Visual -->
                    <div class="col-12">
                        <div class="rb-card">
                            <div class="card-header-rb">
                                <h5 class="mb-0">
                                    <i class="bi bi-graph-up me-2"></i>Kinerja Visual Sistem
                                </h5>
                            </div>
                            <div class="card-body-rb">
                                <div class="row g-4">
                                    <!-- Memory Usage Visual -->
                                    <div class="col-md-6">
                                        <div class="performance-visual">
                                            <div class="perf-header">
                                                <i class="bi bi-memory"></i>
                                                <div>
                                                    <h6>Memory Usage</h6>
                                                    <p>Current: {{ $performance['memory_usage'] }} MB / Peak: {{ $performance['memory_peak'] }} MB</p>
                                                </div>
                                            </div>
                                            <div class="circular-progress" data-progress="{{ min(($performance['memory_usage'] / $performance['memory_peak']) * 100, 100) }}">
                                                <svg width="200" height="200">
                                                    <circle class="bg-circle" cx="100" cy="100" r="80"></circle>
                                                    <circle class="progress-circle" cx="100" cy="100" r="80"></circle>
                                                </svg>
                                                <div class="progress-text">
                                                    <span class="progress-value">{{ round(($performance['memory_usage'] / $performance['memory_peak']) * 100) }}%</span>
                                                    <span class="progress-label">Used</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- CPU Cores -->
                                    <div class="col-md-6">
                                        <div class="performance-visual">
                                            <div class="perf-header">
                                                <i class="bi bi-cpu"></i>
                                                <div>
                                                    <h6>CPU Cores</h6>
                                                    <p>Available Processing Units</p>
                                                </div>
                                            </div>
                                            <div class="cpu-cores">
                                                @for($i = 1; $i <= $performance['cpu_cores']; $i++)
                                                    <div class="core-box">
                                                        <i class="bi bi-cpu-fill"></i>
                                                        <span>Core {{ $i }}</span>
                                                    </div>
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- System Status Bars -->
                                <div class="mt-4">
                                    <div class="status-bars">
                                        <div class="status-bar">
                                            <div class="status-info">
                                                <span><i class="bi bi-database"></i> Database Performance</span>
                                                <span>{{ $dbStats['database_size'] }} MB</span>
                                            </div>
                                            <div class="progress-bar-custom">
                                                <div class="progress-fill bg-gradient-1" style="width: {{ min(($dbStats['database_size'] / 100) * 100, 100) }}%"></div>
                                            </div>
                                        </div>

                                        <div class="status-bar">
                                            <div class="status-info">
                                                <span><i class="bi bi-hdd"></i> Storage Usage</span>
                                                <span>{{ $storageInfo['total_storage'] }} MB</span>
                                            </div>
                                            <div class="progress-bar-custom">
                                                <div class="progress-fill bg-gradient-2" style="width: {{ min(($storageInfo['total_storage'] / 500) * 100, 100) }}%"></div>
                                            </div>
                                        </div>

                                        <div class="status-bar">
                                            <div class="status-info">
                                                <span><i class="bi bi-people"></i> Active Users</span>
                                                <span>{{ $dbStats['total_users'] }}</span>
                                            </div>
                                            <div class="progress-bar-custom">
                                                <div class="progress-fill bg-gradient-3" style="width: {{ min(($dbStats['total_users'] / 100) * 100, 100) }}%"></div>
                                            </div>
                                        </div>

                                        <div class="status-bar">
                                            <div class="status-info">
                                                <span><i class="bi bi-activity"></i> Total Records</span>
                                                <span>{{ number_format($dbStats['total_presence_details'] + $dbStats['total_laporans']) }}</span>
                                            </div>
                                            <div class="progress-bar-custom">
                                                <div class="progress-fill bg-gradient-4" style="width: {{ min((($dbStats['total_presence_details'] + $dbStats['total_laporans']) / 1000) * 100, 100) }}%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- System Performance -->
                    <div class="col-lg-6">
                        <div class="rb-card">
                            <div class="card-header-rb">
                                <h5 class="mb-0">
                                    <i class="bi bi-speedometer2 me-2"></i>Kinerja Sistem
                                </h5>
                            </div>
                            <div class="card-body-rb">
                                <div class="performance-grid">
                                    <div class="perf-item">
                                        <div class="perf-icon bg-success">
                                            <i class="bi bi-hdd"></i>
                                        </div>
                                        <div class="perf-info">
                                            <h6>Cache Driver</h6>
                                            <p>{{ ucfirst($performance['cache_driver']) }}</p>
                                        </div>
                                    </div>

                                    <div class="perf-item">
                                        <div class="perf-icon bg-primary">
                                            <i class="bi bi-clock-history"></i>
                                        </div>
                                        <div class="perf-info">
                                            <h6>Session Driver</h6>
                                            <p>{{ ucfirst($performance['session_driver']) }}</p>
                                        </div>
                                    </div>

                                    <div class="perf-item">
                                        <div class="perf-icon bg-warning">
                                            <i class="bi bi-list-task"></i>
                                        </div>
                                        <div class="perf-info">
                                            <h6>Queue Driver</h6>
                                            <p>{{ ucfirst($performance['queue_driver']) }}</p>
                                        </div>
                                    </div>

                                    <div class="perf-item">
                                        <div class="perf-icon {{ $performance['debug_mode'] ? 'bg-danger' : 'bg-success' }}">
                                            <i class="bi bi-bug"></i>
                                        </div>
                                        <div class="perf-info">
                                            <h6>Debug Mode</h6>
                                            <p>{{ $performance['debug_mode'] ? 'Aktif' : 'Nonaktif' }}</p>
                                        </div>
                                    </div>

                                    <div class="perf-item">
                                        <div class="perf-icon bg-info">
                                            <i class="bi bi-server"></i>
                                        </div>
                                        <div class="perf-info">
                                            <h6>Environment</h6>
                                            <p>{{ ucfirst($performance['environment']) }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <form action="{{ route('system-settings.clear-cache') }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus semua cache?')">
                                        @csrf
                                        <button type="submit" class="btn btn-danger w-100">
                                            <i class="bi bi-trash3 me-2"></i>Clear All Cache
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- System Information -->
                    <div class="col-lg-6">
                        <div class="rb-card">
                            <div class="card-header-rb">
                                <h5 class="mb-0">
                                    <i class="bi bi-info-circle me-2"></i>Informasi Sistem
                                </h5>
                            </div>
                            <div class="card-body-rb">
                                <div class="info-list">
                                    <div class="info-row">
                                        <span class="info-label">
                                            <i class="bi bi-code-slash"></i> Laravel Version
                                        </span>
                                        <span class="info-value">{{ $systemInfo['laravel_version'] }}</span>
                                    </div>

                                    <div class="info-row">
                                        <span class="info-label">
                                            <i class="bi bi-filetype-php"></i> PHP Version
                                        </span>
                                        <span class="info-value">{{ $systemInfo['php_version'] }}</span>
                                    </div>

                                    <div class="info-row">
                                        <span class="info-label">
                                            <i class="bi bi-display"></i> Server Software
                                        </span>
                                        <span class="info-value">{{ $systemInfo['server_software'] }}</span>
                                    </div>

                                    <div class="info-row">
                                        <span class="info-label">
                                            <i class="bi bi-cpu"></i> Server OS
                                        </span>
                                        <span class="info-value">{{ $systemInfo['server_os'] }}</span>
                                    </div>

                                    <div class="info-row">
                                        <span class="info-label">
                                            <i class="bi bi-memory"></i> Memory Limit
                                        </span>
                                        <span class="info-value">{{ $systemInfo['memory_limit'] }}</span>
                                    </div>

                                    <div class="info-row">
                                        <span class="info-label">
                                            <i class="bi bi-stopwatch"></i> Max Execution Time
                                        </span>
                                        <span class="info-value">{{ $systemInfo['max_execution_time'] }}s</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Database Statistics -->
                    <div class="col-lg-6">
                        <div class="rb-card">
                            <div class="card-header-rb">
                                <h5 class="mb-0">
                                    <i class="bi bi-database me-2"></i>Statistik Database
                                </h5>
                            </div>
                            <div class="card-body-rb">
                                <div class="stats-grid">
                                    <div class="stat-box">
                                        <div class="stat-icon-small bg-gradient-1">
                                            <i class="bi bi-people"></i>
                                        </div>
                                        <div class="stat-details">
                                            <h3>{{ number_format($dbStats['total_users']) }}</h3>
                                            <p>Total Users</p>
                                        </div>
                                    </div>

                                    <div class="stat-box">
                                        <div class="stat-icon-small bg-gradient-2">
                                            <i class="bi bi-calendar-event"></i>
                                        </div>
                                        <div class="stat-details">
                                            <h3>{{ number_format($dbStats['total_presences']) }}</h3>
                                            <p>Total Kegiatan</p>
                                        </div>
                                    </div>

                                    <div class="stat-box">
                                        <div class="stat-icon-small bg-gradient-3">
                                            <i class="bi bi-person-check"></i>
                                        </div>
                                        <div class="stat-details">
                                            <h3>{{ number_format($dbStats['total_presence_details']) }}</h3>
                                            <p>Total Absensi</p>
                                        </div>
                                    </div>

                                    <div class="stat-box">
                                        <div class="stat-icon-small bg-gradient-4">
                                            <i class="bi bi-file-text"></i>
                                        </div>
                                        <div class="stat-details">
                                            <h3>{{ number_format($dbStats['total_laporans']) }}</h3>
                                            <p>Total Laporan</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4 text-center">
                                    <div class="db-size-badge">
                                        <i class="bi bi-hdd-stack me-2"></i>
                                        Database Size: <strong>{{ $dbStats['database_size'] }} MB</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Storage Usage -->
                    <div class="col-lg-6">
                        <div class="rb-card">
                            <div class="card-header-rb">
                                <h5 class="mb-0">
                                    <i class="bi bi-hdd me-2"></i>Penggunaan Storage
                                </h5>
                            </div>
                            <div class="card-body-rb">
                                <div class="storage-list">
                                    <div class="storage-item">
                                        <div class="storage-icon">
                                            <i class="bi bi-pen"></i>
                                        </div>
                                        <div class="storage-info">
                                            <h6>Uploads - Tanda Tangan</h6>
                                            <div class="progress">
                                                <div class="progress-bar bg-warning" style="width: {{ min(($storageInfo['uploads_tanda_tangan'] / 100) * 100, 100) }}%"></div>
                                            </div>
                                            <small>{{ $storageInfo['uploads_tanda_tangan'] }} MB</small>
                                        </div>
                                    </div>

                                    <div class="storage-item">
                                        <div class="storage-icon">
                                            <i class="bi bi-folder"></i>
                                        </div>
                                        <div class="storage-info">
                                            <h6>Storage - App</h6>
                                            <div class="progress">
                                                <div class="progress-bar bg-info" style="width: {{ min(($storageInfo['storage_app'] / 100) * 100, 100) }}%"></div>
                                            </div>
                                            <small>{{ $storageInfo['storage_app'] }} MB</small>
                                        </div>
                                    </div>

                                    <div class="storage-item">
                                        <div class="storage-icon">
                                            <i class="bi bi-file-text"></i>
                                        </div>
                                        <div class="storage-info">
                                            <h6>Storage - Logs</h6>
                                            <div class="progress">
                                                <div class="progress-bar bg-success" style="width: {{ min(($storageInfo['storage_logs'] / 100) * 100, 100) }}%"></div>
                                            </div>
                                            <small>{{ $storageInfo['storage_logs'] }} MB</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <div class="total-storage">
                                        <i class="bi bi-hdd-fill me-2"></i>
                                        Total Storage: <strong>{{ number_format($storageInfo['total_storage'], 2) }} MB</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    <div class="col-12">
                        <div class="rb-card">
                            <div class="card-header-rb">
                                <h5 class="mb-0">
                                    <i class="bi bi-activity me-2"></i>Aktivitas 7 Hari Terakhir
                                </h5>
                            </div>
                            <div class="card-body-rb">
                                <div class="row text-center">
                                    <div class="col-md-4">
                                        <div class="activity-card">
                                            <div class="activity-icon bg-gradient-1">
                                                <i class="bi bi-calendar-plus"></i>
                                            </div>
                                            <h3>{{ $recentActivity['new_presences'] }}</h3>
                                            <p>Kegiatan Baru</p>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="activity-card">
                                            <div class="activity-icon bg-gradient-2">
                                                <i class="bi bi-person-check-fill"></i>
                                            </div>
                                            <h3>{{ $recentActivity['new_presence_details'] }}</h3>
                                            <p>Absensi Baru</p>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="activity-card">
                                            <div class="activity-icon bg-gradient-3">
                                                <i class="bi bi-file-earmark-plus"></i>
                                            </div>
                                            <h3>{{ $recentActivity['new_laporans'] }}</h3>
                                            <p>Laporan Baru</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@include('layouts.rb-scripts')

@push('styles')
@include('layouts.rb-styles')
<style>
    /* Performance Visual */
    .performance-visual {
        background: var(--card-bg);
        border: 2px solid var(--card-border);
        border-radius: 20px;
        padding: 2rem;
        text-align: center;
        transition: all 0.3s ease;
    }

    .performance-visual:hover {
        border-color: var(--rb-yellow);
        box-shadow: 0 10px 30px rgba(252, 215, 0, 0.2);
    }

    .perf-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 2rem;
        text-align: left;
    }

    .perf-header i {
        font-size: 2.5rem;
        color: var(--rb-yellow);
    }

    .perf-header h6 {
        color: var(--text-primary);
        margin: 0 0 0.3rem 0;
        font-weight: 700;
        font-size: 1.2rem;
    }

    .perf-header p {
        color: var(--text-muted);
        margin: 0;
        font-size: 0.9rem;
    }

    /* Circular Progress */
    .circular-progress {
        position: relative;
        display: inline-block;
        margin: 1rem 0;
    }

    .circular-progress svg {
        transform: rotate(-90deg);
    }

    .bg-circle {
        fill: none;
        stroke: var(--bg-tertiary);
        stroke-width: 12;
    }

    .progress-circle {
        fill: none;
        stroke: url(#gradient);
        stroke-width: 12;
        stroke-linecap: round;
        stroke-dasharray: 502;
        stroke-dashoffset: 502;
        animation: fillProgress 2s ease forwards;
    }

    @keyframes fillProgress {
        to {
            stroke-dashoffset: calc(502 - (502 * var(--progress) / 100));
        }
    }

    .progress-text {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
    }

    .progress-value {
        display: block;
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--text-primary);
    }

    .progress-label {
        display: block;
        font-size: 0.9rem;
        color: var(--text-muted);
        margin-top: 0.3rem;
    }

    /* CPU Cores */
    .cpu-cores {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
        gap: 1rem;
        margin-top: 1rem;
    }

    .core-box {
        background: linear-gradient(135deg, rgba(220, 0, 0, 0.1), rgba(6, 0, 239, 0.1));
        border: 2px solid var(--rb-navy);
        border-radius: 15px;
        padding: 1.5rem 1rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        animation: coreAnim 2s ease infinite;
    }

    @keyframes coreAnim {
        0%, 100% { transform: scale(1); box-shadow: 0 0 0 rgba(6, 0, 239, 0.5); }
        50% { transform: scale(1.05); box-shadow: 0 0 20px rgba(6, 0, 239, 0.3); }
    }

    .core-box:hover {
        border-color: var(--rb-yellow);
        background: linear-gradient(135deg, rgba(220, 0, 0, 0.2), rgba(6, 0, 239, 0.2));
    }

    .core-box i {
        font-size: 2rem;
        color: var(--rb-red);
    }

    .core-box span {
        color: var(--text-primary);
        font-weight: 600;
        font-size: 0.9rem;
    }

    /* Status Bars */
    .status-bars {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .status-bar {
        background: var(--card-bg);
        border: 2px solid var(--card-border);
        border-radius: 15px;
        padding: 1.5rem;
        transition: all 0.3s ease;
    }

    .status-bar:hover {
        border-color: var(--rb-yellow);
        transform: translateX(5px);
    }

    .status-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }

    .status-info span:first-child {
        color: var(--text-primary);
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .status-info span:last-child {
        color: var(--rb-yellow);
        font-weight: 700;
        font-size: 1.1rem;
    }

    .progress-bar-custom {
        height: 12px;
        background: var(--bg-tertiary);
        border-radius: 10px;
        overflow: hidden;
        position: relative;
    }

    .progress-fill {
        height: 100%;
        border-radius: 10px;
        transition: width 1.5s ease;
        position: relative;
        overflow: hidden;
    }

    .progress-fill::after {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        animation: shimmer 2s infinite;
    }

    @keyframes shimmer {
        100% { left: 100%; }
    }

    /* Performance Grid */
    .performance-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1rem;
    }

    .perf-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        background: var(--card-bg);
        border-left: 4px solid var(--rb-yellow);
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .perf-item:hover {
        transform: translateX(5px);
        background: rgba(252, 215, 0, 0.05);
    }

    .perf-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
    }

    .perf-info h6 {
        color: var(--text-primary);
        margin: 0 0 0.3rem 0;
        font-weight: 700;
    }

    .perf-info p {
        color: var(--text-muted);
        margin: 0;
        font-size: 0.9rem;
    }

    /* Info List */
    .info-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem;
        background: var(--card-bg);
        border-radius: 10px;
        border-left: 3px solid var(--rb-red);
    }

    .info-label {
        color: var(--text-secondary);
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .info-value {
        color: var(--rb-yellow);
        font-weight: 700;
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }

    .stat-box {
        background: var(--card-bg);
        border: 2px solid var(--card-border);
        border-radius: 15px;
        padding: 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        transition: all 0.3s ease;
    }

    .stat-box:hover {
        border-color: var(--rb-yellow);
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(252, 215, 0, 0.2);
    }

    .stat-icon-small {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        color: white;
        flex-shrink: 0;
    }

    .bg-gradient-1 { background: linear-gradient(135deg, #DC0000, #FCD700); }
    .bg-gradient-2 { background: linear-gradient(135deg, #0600EF, #DC0000); }
    .bg-gradient-3 { background: linear-gradient(135deg, #FCD700, #0600EF); }
    .bg-gradient-4 { background: linear-gradient(135deg, #DC0000, #0600EF); }

    .stat-details h3 {
        color: var(--text-primary);
        font-size: 2rem;
        font-weight: 700;
        margin: 0 0 0.3rem 0;
    }

    .stat-details p {
        color: var(--text-muted);
        margin: 0;
        font-size: 0.9rem;
    }

    .db-size-badge {
        background: linear-gradient(135deg, rgba(220, 0, 0, 0.1), rgba(6, 0, 239, 0.1));
        border: 2px solid var(--rb-yellow);
        color: var(--text-primary);
        padding: 1rem 2rem;
        border-radius: 50px;
        display: inline-block;
        font-size: 1.1rem;
    }

    /* Storage List */
    .storage-list {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .storage-item {
        display: flex;
        gap: 1rem;
        align-items: center;
    }

    .storage-icon {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, var(--rb-red), var(--rb-navy));
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
        flex-shrink: 0;
    }

    .storage-info {
        flex: 1;
    }

    .storage-info h6 {
        color: var(--text-primary);
        margin: 0 0 0.5rem 0;
        font-weight: 700;
    }

    .storage-info .progress {
        height: 8px;
        background: var(--bg-tertiary);
        border-radius: 10px;
        margin-bottom: 0.3rem;
    }

    .storage-info small {
        color: var(--text-muted);
        font-weight: 600;
    }

    .total-storage {
        background: linear-gradient(135deg, rgba(252, 215, 0, 0.1), rgba(220, 0, 0, 0.1));
        border: 2px solid var(--rb-yellow);
        color: var(--text-primary);
        padding: 1rem;
        border-radius: 15px;
        text-align: center;
        font-size: 1.1rem;
    }

    /* Activity Card */
    .activity-card {
        padding: 2rem 1rem;
        background: var(--card-bg);
        border: 2px solid var(--card-border);
        border-radius: 20px;
        transition: all 0.3s ease;
    }

    .activity-card:hover {
        border-color: var(--rb-yellow);
        transform: translateY(-10px);
        box-shadow: 0 15px 35px rgba(252, 215, 0, 0.2);
    }

    .activity-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        color: white;
        margin-bottom: 1rem;
    }

    .activity-card h3 {
        color: var(--text-primary);
        font-size: 3rem;
        font-weight: 700;
        margin: 0.5rem 0;
    }

    .activity-card p {
        color: var(--text-muted);
        margin: 0;
        font-size: 1rem;
    }

    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@push('js')
<script>
    // Animate circular progress
    document.addEventListener('DOMContentLoaded', function() {
        const circularProgress = document.querySelector('.circular-progress');
        if (circularProgress) {
            const progress = circularProgress.getAttribute('data-progress');
            const progressCircle = circularProgress.querySelector('.progress-circle');
            const circumference = 2 * Math.PI * 80;
            const offset = circumference - (progress / 100) * circumference;
            
            // Add gradient
            const svg = circularProgress.querySelector('svg');
            const defs = document.createElementNS('http://www.w3.org/2000/svg', 'defs');
            const gradient = document.createElementNS('http://www.w3.org/2000/svg', 'linearGradient');
            gradient.setAttribute('id', 'gradient');
            gradient.setAttribute('x1', '0%');
            gradient.setAttribute('y1', '0%');
            gradient.setAttribute('x2', '100%');
            gradient.setAttribute('y2', '100%');
            
            const stop1 = document.createElementNS('http://www.w3.org/2000/svg', 'stop');
            stop1.setAttribute('offset', '0%');
            stop1.setAttribute('style', 'stop-color:#DC0000;stop-opacity:1');
            
            const stop2 = document.createElementNS('http://www.w3.org/2000/svg', 'stop');
            stop2.setAttribute('offset', '50%');
            stop2.setAttribute('style', 'stop-color:#FCD700;stop-opacity:1');
            
            const stop3 = document.createElementNS('http://www.w3.org/2000/svg', 'stop');
            stop3.setAttribute('offset', '100%');
            stop3.setAttribute('style', 'stop-color:#0600EF;stop-opacity:1');
            
            gradient.appendChild(stop1);
            gradient.appendChild(stop2);
            gradient.appendChild(stop3);
            defs.appendChild(gradient);
            svg.insertBefore(defs, svg.firstChild);
            
            // Animate
            setTimeout(() => {
                progressCircle.style.strokeDashoffset = offset;
            }, 100);
        }

        // Animate progress bars
        const progressFills = document.querySelectorAll('.progress-fill');
        progressFills.forEach((fill, index) => {
            const width = fill.style.width;
            fill.style.width = '0%';
            setTimeout(() => {
                fill.style.width = width;
            }, 100 + (index * 100));
        });

        // Stagger core animations
        const coreBoxes = document.querySelectorAll('.core-box');
        coreBoxes.forEach((core, index) => {
            core.style.animationDelay = `${index * 0.2}s`;
        });
    });
</script>
@endpush
