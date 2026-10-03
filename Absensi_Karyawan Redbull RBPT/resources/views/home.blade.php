@extends('layouts.main')

@section('content')
<div class="d-flex" id="dashboard-app">
    <!-- SIDEBAR RED BULL RACING -->
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
            <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
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
            <a href="{{ route('system-settings') }}" class="nav-link">
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
                    <strong>{{ Auth::user()->name ?? 'User' }}</strong>
                    <small>Administrator</small>
                </div>
            </div>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="mt-3">
                @csrf
                <button type="submit" class="btn-logout w-100">
                    <i class="bi bi-box-arrow-right me-2"></i>Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <div class="flex-fill main-area">
        <!-- Racing Stripe -->
        <div class="racing-stripe"></div>
        
        <!-- Top Bar -->
        <div class="top-bar">
            <div class="d-flex align-items-center">
                <button id="sidebarToggle" class="btn-toggle">
                    <i class="bi bi-list"></i>
                </button>
                <h4 class="page-title mb-0">
                    <i class="bi bi-speedometer2 me-2"></i>Dashboard Control
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

        <!-- Dashboard Content -->
        <div class="dashboard-content">
            @if (session('status'))
                <div class="alert alert-success alert-modern">
                    <i class="bi bi-check-circle me-2"></i>{{ session('status') }}
                </div>
            @endif

            <!-- Stats Cards -->
            <div class="row g-4 mb-4">
                <div class="col-xl-3 col-md-6">
                    <div class="stat-card stat-card-1">
                        <div class="stat-icon">
                            <i class="bi bi-calendar-event"></i>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-value" data-target="{{ $totalKegiatan ?? 0 }}">0</h3>
                            <p class="stat-label">Total Kegiatan</p>
                        </div>
                        <div class="stat-chart">
                            <i class="bi bi-graph-up-arrow"></i>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="stat-card stat-card-2">
                        <div class="stat-icon">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-value" data-target="{{ $totalPeserta ?? 0 }}">0</h3>
                            <p class="stat-label">Total Peserta</p>
                        </div>
                        <div class="stat-chart">
                            <i class="bi bi-graph-up-arrow"></i>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="stat-card stat-card-3">
                        <div class="stat-icon">
                            <i class="bi bi-calendar-check"></i>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-value" data-target="{{ $kegiatanHariIni ?? 0 }}">0</h3>
                            <p class="stat-label">Kegiatan Hari Ini</p>
                        </div>
                        <div class="stat-chart">
                            <i class="bi bi-graph-up-arrow"></i>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="stat-card stat-card-4">
                        <div class="stat-icon">
                            <i class="bi bi-person-check-fill"></i>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-value" data-target="{{ $pesertaHariIni ?? 0 }}">0</h3>
                            <p class="stat-label">Absen Hari Ini</p>
                        </div>
                        <div class="stat-chart">
                            <i class="bi bi-graph-up-arrow"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Row -->
            <div class="row g-4">
                <!-- Quick Actions & Calendar -->
                <div class="col-xl-4">
                    <!-- Quick Actions -->
                    <div class="rb-card mb-4">
                        <div class="card-header-rb">
                            <h5 class="mb-0">
                                <i class="bi bi-lightning-charge-fill me-2"></i>Quick Actions
                            </h5>
                        </div>
                        <div class="card-body-rb">
                            <div class="quick-actions">
                                <a href="{{ route('presence.create') }}" class="quick-action-btn">
                                    <i class="bi bi-plus-circle-fill"></i>
                                    <span>Buat Kegiatan</span>
                                </a>
                                @if($latestPresence)
                                <a href="{{ route('presence.show', $latestPresence->id) }}" class="quick-action-btn">
                                    <i class="bi bi-list-check"></i>
                                    <span>Lihat Absensi</span>
                                </a>
                                @else
                                <a href="{{ route('presence.index') }}" class="quick-action-btn">
                                    <i class="bi bi-list-check"></i>
                                    <span>Lihat Absensi</span>
                                </a>
                                @endif
                                @if($latestPresence)
                                <a href="{{ route('absen.index', ['slug' => $latestPresence->slug]) }}" class="quick-action-btn">
                                    <i class="bi bi-person-check-fill"></i>
                                    <span>Absensi Sekarang</span>
                                </a>
                                @else
                                <a href="{{ route('presence.create') }}" class="quick-action-btn">
                                    <i class="bi bi-person-check-fill"></i>
                                    <span>Absensi Sekarang</span>
                                </a>
                                @endif
                                <a href="{{ route('laporan.index') }}" class="quick-action-btn">
                                    <i class="bi bi-bar-chart-fill"></i>
                                    <span>Laporan</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Digital Calendar - Mini Version -->
                    <div class="rb-card calendar-card">
                        <div class="card-header-rb">
                            <h5 class="mb-0">
                                <i class="bi bi-calendar3 me-2"></i>Kalender
                            </h5>
                        </div>
                        <div class="card-body-rb p-3">
                            <div class="digital-calendar-mini">
                                <div class="calendar-header-mini">
                                    <button class="calendar-nav-mini" id="prevMonth">
                                        <i class="bi bi-chevron-left"></i>
                                    </button>
                                    <div class="calendar-current-mini">
                                        <span id="currentMonth"></span>
                                        <span id="currentYear"></span>
                                    </div>
                                    <button class="calendar-nav-mini" id="nextMonth">
                                        <i class="bi bi-chevron-right"></i>
                                    </button>
                                </div>

                                <div class="calendar-weekdays-mini">
                                    <div>M</div>
                                    <div>S</div>
                                    <div>S</div>
                                    <div>R</div>
                                    <div>K</div>
                                    <div>J</div>
                                    <div>S</div>
                                </div>

                                <div class="calendar-days-mini" id="calendarDays">
                                </div>

                                <div class="calendar-today-mini">
                                    <i class="bi bi-calendar-check"></i>
                                    <span id="todayInfo"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity & System Status -->
                <div class="col-xl-8">
                    <div class="rb-card mb-4">
                        <div class="card-header-rb">
                            <h5 class="mb-0">
                                <i class="bi bi-activity me-2"></i>Aktivitas Terbaru
                            </h5>
                            @if($latestPresence)
                            <a href="{{ route('presence.show', $latestPresence->id) }}" class="btn-rb-sm">
                                Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                            @else
                            <a href="{{ route('presence.index') }}" class="btn-rb-sm">
                                Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                            @endif
                        </div>
                        <div class="card-body-rb">
                            <div class="table-responsive">
                                <table class="table-rb">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nama Peserta</th>
                                            <th>Jabatan</th>
                                            <th>Kegiatan</th>
                                            <th>Waktu</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(isset($recentActivities) && $recentActivities->count())
                                            @foreach($recentActivities as $activity)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>
                                                        <div class="user-cell">
                                                            <div class="user-avatar-sm">
                                                                {{ substr($activity['nama'] ?? 'U', 0, 1) }}
                                                            </div>
                                                            <strong>{{ $activity['nama'] ?? '-' }}</strong>
                                                        </div>
                                                    </td>
                                                    <td>{{ $activity['jabatan'] ?? '-' }}</td>
                                                    <td>
                                                        <small class="text-muted">{{ Str::limit($activity['nama_kegiatan'] ?? '-', 25) }}</small>
                                                    </td>
                                                    <td>
                                                        <span class="badge-rb badge-success">
                                                            <i class="bi bi-clock me-1"></i>{{ $activity['waktu_masuk'] ?? '-' }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="5" class="text-center py-4">
                                                    <i class="bi bi-inbox fs-1 text-muted d-block mb-2"></i>
                                                    <p class="text-muted">Tidak ada aktivitas terbaru</p>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- System Status -->
                    <div class="rb-card">
                        <div class="card-header-rb">
                            <h5 class="mb-0">
                                <i class="bi bi-hdd-network-fill me-2"></i>Status Sistem
                            </h5>
                        </div>
                        <div class="card-body-rb">
                            <div class="status-items-horizontal">
                                <div class="status-item">
                                    <div class="status-indicator status-online"></div>
                                    <div class="status-info">
                                        <strong>Server</strong>
                                        <small>Online & Running</small>
                                    </div>
                                    <div class="status-badge">
                                        <i class="bi bi-check-circle-fill text-success"></i>
                                    </div>
                                </div>
                                <div class="status-item">
                                    <div class="status-indicator status-online"></div>
                                    <div class="status-info">
                                        <strong>Database</strong>
                                        <small>Connected</small>
                                    </div>
                                    <div class="status-badge">
                                        <i class="bi bi-check-circle-fill text-success"></i>
                                    </div>
                                </div>
                                <div class="status-item">
                                    <div class="status-indicator status-online"></div>
                                    <div class="status-info">
                                        <strong>API Service</strong>
                                        <small>Active</small>
                                    </div>
                                    <div class="status-badge">
                                        <i class="bi bi-check-circle-fill text-success"></i>
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

@push('styles')
@include('layouts.rb-styles')
<style>
    /* Home page specific styles only */
    .stat-card {
        background: var(--card-bg);
        backdrop-filter: blur(10px);
        border: 2px solid var(--card-border);
        border-radius: 20px;
        padding: 1.5rem;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(220, 0, 0, 0.1) 0%, transparent 70%);
        animation: rotate 20s linear infinite;
    }

    @keyframes rotate {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(220, 0, 0, 0.3);
        border-color: var(--rb-red);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        color: white;
        margin-bottom: 1rem;
        position: relative;
        z-index: 1;
    }

    .stat-card-1 .stat-icon { background: linear-gradient(135deg, #DC0000, #FCD700); }
    .stat-card-2 .stat-icon { background: linear-gradient(135deg, #0600EF, #DC0000); }
    .stat-card-3 .stat-icon { background: linear-gradient(135deg, #FCD700, #0600EF); }
    .stat-card-4 .stat-icon { background: linear-gradient(135deg, #DC0000, #0600EF); }

    .stat-content {
        position: relative;
        z-index: 1;
    }

    .stat-value {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--rb-yellow);
        margin: 0;
    }

    .stat-label {
        color: var(--text-muted);
        font-size: 1rem;
        margin: 0;
        font-weight: 600;
    }

    .stat-chart {
        position: absolute;
        right: 1.5rem;
        top: 50%;
        transform: translateY(-50%);
        font-size: 3rem;
        color: var(--text-muted);
    }

    /* RB CARD */
    .rb-card {
        background: var(--card-bg);
        backdrop-filter: blur(10px);
        border: 2px solid var(--card-border);
        border-radius: 20px;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .rb-card:hover {
        border-color: var(--rb-red);
        box-shadow: 0 10px 30px rgba(220, 0, 0, 0.2);
    }

    .card-header-rb {
        background: rgba(220, 0, 0, 0.1);
        padding: 1.5rem;
        border-bottom: 2px solid rgba(220, 0, 0, 0.2);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .card-header-rb h5 {
        color: var(--text-primary);
        font-weight: 700;
        letter-spacing: 1px;
    }

    .btn-rb-sm {
        background: linear-gradient(135deg, var(--rb-red), var(--rb-navy));
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }

    .btn-rb-sm:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(220, 0, 0, 0.4);
        border-color: var(--rb-yellow);
        color: var(--rb-yellow);
    }

    .card-body-rb {
        padding: 1.5rem;
    }

    /* TABLE */
    .table-rb {
        width: 100%;
        color: var(--text-primary);
    }

    .table-rb thead tr {
        border-bottom: 2px solid rgba(220, 0, 0, 0.3);
    }

    .table-rb th {
        padding: 1rem;
        font-weight: 700;
        color: var(--rb-yellow);
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 1px;
    }

    .table-rb td {
        padding: 1rem;
        border-bottom: 1px solid var(--card-border);
    }

    .table-rb tbody tr {
        transition: all 0.3s ease;
    }

    .table-rb tbody tr:hover {
        background: rgba(220, 0, 0, 0.05);
    }

    .user-cell {
        display: flex;
        align-items: center;
        gap: 0.8rem;
    }

    .user-avatar-sm {
        width: 35px;
        height: 35px;
        background: linear-gradient(135deg, var(--rb-red), var(--rb-navy));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
    }

    .badge-rb {
        padding: 0.4rem 0.8rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
    }

    .badge-success {
        background: rgba(40, 167, 69, 0.2);
        color: #28a745;
        border: 1px solid #28a745;
    }

    /* QUICK ACTIONS */
    .quick-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }

    .quick-action-btn {
        background: rgba(220, 0, 0, 0.1);
        border: 2px solid rgba(220, 0, 0, 0.3);
        border-radius: 15px;
        padding: 1.2rem;
        text-align: center;
        text-decoration: none;
        color: var(--text-primary);
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
    }

    .quick-action-btn i {
        font-size: 2rem;
        color: var(--rb-yellow);
    }

    .quick-action-btn span {
        font-weight: 600;
        font-size: 0.9rem;
    }

    .quick-action-btn:hover {
        background: linear-gradient(135deg, rgba(220, 0, 0, 0.2), rgba(6, 0, 239, 0.2));
        border-color: var(--rb-red);
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(220, 0, 0, 0.3);
        color: var(--rb-yellow);
    }

    /* STATUS ITEMS */
    .status-items {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .status-items-horizontal {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1rem;
    }

    @media (max-width: 992px) {
        .status-items-horizontal {
            grid-template-columns: 1fr;
        }
    }

    .status-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        background: var(--card-bg);
        border-radius: 12px;
        border: 1px solid var(--card-border);
    }

    .status-indicator {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        position: relative;
    }

    .status-online {
        background: #28a745;
        box-shadow: 0 0 10px #28a745;
        animation: blink 2s ease-in-out infinite;
    }

    @keyframes blink {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }

    .status-info {
        flex: 1;
    }

    .status-info strong {
        color: var(--text-primary);
        display: block;
        font-size: 0.95rem;
    }

    .status-info small {
        color: var(--text-muted);
        font-size: 0.8rem;
    }

    .status-badge i {
        font-size: 1.2rem;
    }

    /* MINI CALENDAR */
    .digital-calendar-mini {
        background: linear-gradient(135deg, rgba(6, 0, 239, 0.05), rgba(220, 0, 0, 0.05));
        border-radius: 12px;
        padding: 1rem;
    }

    .calendar-header-mini {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        padding-bottom: 0.8rem;
        border-bottom: 2px solid rgba(252, 215, 0, 0.2);
    }

    .calendar-nav-mini {
        background: linear-gradient(135deg, var(--rb-red), var(--rb-navy));
        border: none;
        color: white;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 0.9rem;
    }

    .calendar-nav-mini:hover {
        transform: scale(1.1);
        box-shadow: 0 3px 10px rgba(252, 215, 0, 0.4);
    }

    .calendar-current-mini {
        text-align: center;
        color: var(--rb-yellow);
        font-weight: 700;
        font-size: 0.95rem;
        display: flex;
        gap: 0.5rem;
    }

    .calendar-weekdays-mini {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 2px;
        margin-bottom: 0.5rem;
    }

    .calendar-weekdays-mini div {
        text-align: center;
        color: var(--rb-yellow);
        font-weight: 700;
        font-size: 0.7rem;
        padding: 0.3rem;
    }

    .calendar-days-mini {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 2px;
        margin-bottom: 1rem;
    }

    .calendar-day-mini {
        aspect-ratio: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--card-bg);
        border: 1px solid var(--card-border);
        border-radius: 6px;
        color: var(--text-secondary);
        font-weight: 600;
        font-size: 0.75rem;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .calendar-day-mini:hover {
        border-color: var(--rb-yellow);
        color: white;
        transform: scale(1.05);
    }

    .calendar-day-mini.other-month {
        opacity: 0.3;
    }

    .calendar-day-mini.today {
        background: linear-gradient(135deg, var(--rb-red), var(--rb-navy));
        border-color: var(--rb-yellow);
        color: white;
        font-weight: 700;
        box-shadow: 0 0 10px rgba(252, 215, 0, 0.4);
    }

    .calendar-today-mini {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        background: rgba(220, 0, 0, 0.1);
        border: 1px solid var(--rb-yellow);
        border-radius: 8px;
        padding: 0.6rem;
        font-size: 0.8rem;
        color: var(--text-primary);
    }

    .calendar-today-mini i {
        color: var(--rb-yellow);
    }

    /* COLLAPSED STATE */
    #dashboard-app.sidebar-collapsed .rb-sidebar {
        transform: translateX(-100%);
    }

    /* RESPONSIVE */
    @media (max-width: 1200px) {
        .quick-actions {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .rb-sidebar {
            position: fixed;
            z-index: 1050;
            left: 0;
            top: 0;
        }

        #dashboard-app.sidebar-collapsed .rb-sidebar {
            transform: translateX(-100%);
        }

        .top-bar {
            padding: 1rem;
        }

        .page-title {
            font-size: 1.2rem;
        }

        .live-time .clock {
            font-size: 1.3rem;
        }

        .dashboard-content {
            padding: 1rem;
        }

        .stat-value {
            font-size: 2rem;
        }
    }

    .alert-modern {
        background: rgba(40, 167, 69, 0.2);
        border: 2px solid #28a745;
        color: white;
        border-radius: 15px;
    }

    /* CALENDAR CARD */
    .calendar-card {
        position: relative;
        overflow: visible;
    }

    .calendar-card::before {
        content: '';
        position: absolute;
        top: -2px;
        left: -2px;
        right: -2px;
        bottom: -2px;
        background: linear-gradient(45deg, var(--rb-red), var(--rb-yellow), var(--rb-navy), var(--rb-red));
        background-size: 300% 300%;
        border-radius: 22px;
        z-index: -1;
        opacity: 0;
        transition: opacity 0.3s ease;
        animation: gradientShift 4s ease infinite;
    }

    .calendar-card:hover::before {
        opacity: 1;
    }

    @keyframes gradientShift {
        0%, 100% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
    }
</style>
@endpush

@push('js')
<script>
    // Mini Digital Calendar
    (function() {
        const monthNames = [
            'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun',
            'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'
        ];
        const dayNames = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

        let currentDate = new Date();
        let currentMonth = currentDate.getMonth();
        let currentYear = currentDate.getFullYear();

        function renderCalendar() {
            const firstDay = new Date(currentYear, currentMonth, 1).getDay();
            const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();
            const daysInPrevMonth = new Date(currentYear, currentMonth, 0).getDate();

            document.getElementById('currentMonth').textContent = monthNames[currentMonth];
            document.getElementById('currentYear').textContent = currentYear;

            const calendarDays = document.getElementById('calendarDays');
            calendarDays.innerHTML = '';

            // Previous month days
            for (let i = firstDay - 1; i >= 0; i--) {
                const day = document.createElement('div');
                day.className = 'calendar-day-mini other-month';
                day.textContent = daysInPrevMonth - i;
                calendarDays.appendChild(day);
            }

            // Current month days
            const today = new Date();
            for (let i = 1; i <= daysInMonth; i++) {
                const day = document.createElement('div');
                day.className = 'calendar-day-mini';
                day.textContent = i;

                if (i === today.getDate() && currentMonth === today.getMonth() && currentYear === today.getFullYear()) {
                    day.classList.add('today');
                }

                calendarDays.appendChild(day);
            }

            // Next month days
            const totalCells = calendarDays.children.length;
            const remainingCells = 35 - totalCells;
            for (let i = 1; i <= remainingCells && i <= 7; i++) {
                const day = document.createElement('div');
                day.className = 'calendar-day-mini other-month';
                day.textContent = i;
                calendarDays.appendChild(day);
            }

            // Update today info
            const todayDate = new Date();
            const todayStr = `${dayNames[todayDate.getDay()]}, ${todayDate.getDate()} ${monthNames[todayDate.getMonth()]} ${todayDate.getFullYear()}`;
            document.getElementById('todayInfo').textContent = todayStr;
        }

        document.getElementById('prevMonth').addEventListener('click', function() {
            currentMonth--;
            if (currentMonth < 0) {
                currentMonth = 11;
                currentYear--;
            }
            renderCalendar();
        });

        document.getElementById('nextMonth').addEventListener('click', function() {
            currentMonth++;
            if (currentMonth > 11) {
                currentMonth = 0;
                currentYear++;
            }
            renderCalendar();
        });

        renderCalendar();
    })();

    // Animated counter for stats
    (function(){
        const animateValue = (element, start, end, duration) => {
            let startTimestamp = null;
            const step = (timestamp) => {
                if (!startTimestamp) startTimestamp = timestamp;
                const progress = Math.min((timestamp - startTimestamp) / duration, 1);
                element.textContent = Math.floor(progress * (end - start) + start);
                if (progress < 1) {
                    window.requestAnimationFrame(step);
                }
            };
            window.requestAnimationFrame(step);
        };

        const statValues = document.querySelectorAll('.stat-value');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const target = parseInt(entry.target.getAttribute('data-target'));
                    animateValue(entry.target, 0, target, 2000);
                    observer.unobserve(entry.target);
                }
            });
        });

        statValues.forEach(stat => observer.observe(stat));
    })();
</script>
@endpush
