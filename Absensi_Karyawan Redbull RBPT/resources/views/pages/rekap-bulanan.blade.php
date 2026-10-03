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
            <a href="{{ route('rekap-bulanan') }}" class="nav-link active">
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
                    <i class="bi bi-journal-text me-2"></i>Rekap Bulanan
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
            <!-- Filter Section -->
            <div class="rb-card mb-4">
                <div class="card-header-rb">
                    <h5 class="mb-0">
                        <i class="bi bi-funnel me-2"></i>Filter Periode
                    </h5>
                </div>
                <div class="card-body-rb">
                    <form id="filter-form" class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label-rb">
                                <i class="bi bi-calendar-month me-2"></i>Bulan
                            </label>
                            <select class="form-control-rb" id="bulan" name="bulan">
                                <option value="01" {{ date('m') == '01' ? 'selected' : '' }}>Januari</option>
                                <option value="02" {{ date('m') == '02' ? 'selected' : '' }}>Februari</option>
                                <option value="03" {{ date('m') == '03' ? 'selected' : '' }}>Maret</option>
                                <option value="04" {{ date('m') == '04' ? 'selected' : '' }}>April</option>
                                <option value="05" {{ date('m') == '05' ? 'selected' : '' }}>Mei</option>
                                <option value="06" {{ date('m') == '06' ? 'selected' : '' }}>Juni</option>
                                <option value="07" {{ date('m') == '07' ? 'selected' : '' }}>Juli</option>
                                <option value="08" {{ date('m') == '08' ? 'selected' : '' }}>Agustus</option>
                                <option value="09" {{ date('m') == '09' ? 'selected' : '' }}>September</option>
                                <option value="10" {{ date('m') == '10' ? 'selected' : '' }}>Oktober</option>
                                <option value="11" {{ date('m') == '11' ? 'selected' : '' }}>November</option>
                                <option value="12" {{ date('m') == '12' ? 'selected' : '' }}>Desember</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label-rb">
                                <i class="bi bi-calendar3 me-2"></i>Tahun
                            </label>
                            <select class="form-control-rb" id="tahun" name="tahun">
                                @for($y = date('Y'); $y >= 2020; $y--)
                                    <option value="{{ $y }}" {{ date('Y') == $y ? 'selected' : '' }}>{{ $y }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label-rb">&nbsp;</label>
                            <button type="submit" class="btn-rb w-100">
                                <i class="bi bi-search me-2"></i>Tampilkan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="row g-4 mb-4">
                <div class="col-md-3">
                    <div class="summary-card summary-card-1">
                        <div class="summary-icon">
                            <i class="bi bi-calendar-event"></i>
                        </div>
                        <div class="summary-content">
                            <h3 id="total-kegiatan">{{ $totalKegiatan ?? 0 }}</h3>
                            <p>Total Kegiatan</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="summary-card summary-card-2">
                        <div class="summary-icon">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <div class="summary-content">
                            <h3 id="total-peserta">{{ $totalPeserta ?? 0 }}</h3>
                            <p>Total Peserta</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="summary-card summary-card-3">
                        <div class="summary-icon">
                            <i class="bi bi-graph-up"></i>
                        </div>
                        <div class="summary-content">
                            <h3 id="rata-rata">{{ $rataRata ?? 0 }}</h3>
                            <p>Rata-rata/Kegiatan</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="summary-card summary-card-4">
                        <div class="summary-icon">
                            <i class="bi bi-star-fill"></i>
                        </div>
                        <div class="summary-content">
                            <h3 id="kegiatan-terbanyak">{{ $kegiatanTerbanyak ?? 0 }}</h3>
                            <p>Peserta Terbanyak</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Table -->
            <div class="rb-card">
                <div class="card-header-rb">
                    <h5 class="mb-0">
                        <i class="bi bi-table me-2"></i>Detail Rekap Bulan <span id="bulan-display">{{ \Carbon\Carbon::now()->format('F Y') }}</span>
                    </h5>
                    <button onclick="exportPDF()" class="btn-rb-sm">
                        <i class="bi bi-file-earmark-pdf me-2"></i>Export PDF
                    </button>
                </div>
                <div class="card-body-rb">
                    <div class="table-responsive">
                        <table class="table-rb" id="rekap-table">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="30%">Nama Kegiatan</th>
                                    <th width="15%">Tanggal</th>
                                    <th width="15%">Waktu</th>
                                    <th width="15%">Jumlah Peserta</th>
                                    <th width="20%">Status</th>
                                </tr>
                            </thead>
                            <tbody id="table-body">
                                @if(isset($dataRekap) && count($dataRekap) > 0)
                                    @foreach($dataRekap as $index => $data)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <strong>{{ $data->nama_kegiatan }}</strong>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($data->tgl_kegiatan)->format('d/m/Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($data->waktu_mulai)->format('H:i') }} WIB</td>
                                        <td>
                                            <span class="badge-rb badge-info">
                                                <i class="bi bi-people me-1"></i>{{ $data->jumlah_peserta }} orang
                                            </span>
                                        </td>
                                        <td>
                                            @if(\Carbon\Carbon::parse($data->tgl_kegiatan)->isPast())
                                                <span class="badge-rb badge-success">
                                                    <i class="bi bi-check-circle me-1"></i>Selesai
                                                </span>
                                            @else
                                                <span class="badge-rb badge-warning">
                                                    <i class="bi bi-clock me-1"></i>Akan Datang
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6" class="text-center py-5">
                                            <i class="bi bi-inbox fs-1 text-muted d-block mb-3"></i>
                                            <p class="text-muted">Tidak ada data untuk periode yang dipilih</p>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
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
    /* Rekap Bulanan specific styles */
    
    /* FORM CONTROLS */
    .form-label-rb {
        color: var(--text-primary, #fff);
        font-weight: 600;
        display: flex;
        align-items: center;
        margin-bottom: 0.5rem;
    }

    .form-control-rb {
        background: var(--input-bg, rgba(255, 255, 255, 0.05));
        border: 2px solid var(--input-border, rgba(220, 0, 0, 0.3));
        color: var(--text-primary, #fff);
        border-radius: 10px;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
        width: 100%;
    }

    .form-control-rb:focus {
        outline: none;
        border-color: var(--rb-yellow);
        box-shadow: 0 0 15px rgba(252, 215, 0, 0.3);
        background: var(--input-bg, rgba(255, 255, 255, 0.08));
    }

    .form-control-rb option {
        background: var(--bg-secondary, #1a1d2e);
        color: var(--text-primary, #fff);
    }

    .btn-rb {
        background: linear-gradient(135deg, var(--rb-red), var(--rb-navy));
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        border: none;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
    }

    .btn-rb:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(220, 0, 0, 0.4);
    }

    .btn-rb-outline {
        background: transparent;
        border: 2px solid var(--rb-red);
        color: var(--rb-red);
    }

    .btn-rb-outline:hover {
        background: var(--rb-red);
        color: white;
    }

    /* SUMMARY CARDS */
    .summary-card {
        background: var(--card-bg, rgba(255, 255, 255, 0.05));
        backdrop-filter: blur(10px);
        border: 2px solid var(--card-border, rgba(220, 0, 0, 0.2));
        border-radius: 15px;
        padding: 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        transition: all 0.3s ease;
    }

    .summary-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(220, 0, 0, 0.3);
        border-color: var(--rb-red);
    }

    .summary-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        color: white;
    }

    .summary-card-1 .summary-icon { background: linear-gradient(135deg, #DC0000, #FCD700); }
    .summary-card-2 .summary-icon { background: linear-gradient(135deg, #0600EF, #DC0000); }
    .summary-card-3 .summary-icon { background: linear-gradient(135deg, #FCD700, #0600EF); }
    .summary-card-4 .summary-icon { background: linear-gradient(135deg, #DC0000, #0600EF); }

    .summary-content h3 {
        font-size: 2rem;
        font-weight: 700;
        color: var(--rb-yellow);
        margin: 0;
    }

    .summary-content p {
        color: var(--text-muted, rgba(255, 255, 255, 0.7));
        margin: 0;
        font-size: 0.9rem;
    }

    /* TABLE RB */
    .table-rb {
        width: 100%;
        color: var(--text-primary, #fff);
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
        border-bottom: 1px solid var(--card-border, rgba(220, 0, 0, 0.1));
        color: var(--text-primary, #fff);
    }

    .table-rb tbody tr {
        transition: all 0.3s ease;
    }

    .table-rb tbody tr:hover {
        background: rgba(220, 0, 0, 0.05);
    }

    .badge-warning {
        background: rgba(255, 193, 7, 0.2);
        color: #ffc107;
        border: 1px solid #ffc107;
    }

    .badge-info {
        background: rgba(23, 162, 184, 0.2);
        color: #17a2b8;
        border: 1px solid #17a2b8;
    }

    /* Light Mode */
    body.light-mode .form-control-rb {
        background: var(--input-bg);
        border-color: var(--input-border);
        color: var(--text-primary);
    }

    body.light-mode .form-control-rb option {
        background: var(--bg-secondary);
        color: var(--text-primary);
    }

    body.light-mode .summary-content h3 {
        color: var(--rb-navy);
    }

    body.light-mode .summary-content p {
        color: var(--text-muted);
    }

    body.light-mode .table-rb td {
        color: var(--text-primary);
    }

    /* RESPONSIVE */
    @media (max-width: 768px) {
        .summary-content h3 {
            font-size: 1.5rem;
        }
    }
</style>
@endpush

@push('js')
<script>
    // Filter form
    document.getElementById('filter-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const bulan = document.getElementById('bulan').value;
        const tahun = document.getElementById('tahun').value;
        
        // Redirect dengan query parameter
        window.location.href = `{{ route('rekap-bulanan') }}?bulan=${bulan}&tahun=${tahun}`;
    });

    // Export PDF
    function exportPDF() {
        const bulan = document.getElementById('bulan').value;
        const tahun = document.getElementById('tahun').value;
        window.open(`{{ route('rekap-bulanan') }}/export?bulan=${bulan}&tahun=${tahun}`, '_blank');
    }
</script>
@endpush
