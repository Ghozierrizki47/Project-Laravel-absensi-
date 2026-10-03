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
            <a href="{{ route('rekap-bulanan') }}" class="nav-link">
                <i class="bi bi-journal-text"></i>
                <span>Rekap Bulanan</span>
                <div class="nav-indicator"></div>
            </a>
            <a href="{{ route('laporan.index') }}" class="nav-link active">
                <i class="bi bi-file-earmark-text"></i>
                <span>Laporan</span>
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
                    <i class="bi bi-file-earmark-text me-2"></i>Laporan Karyawan
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
            @if (session('success'))
                <div class="alert alert-success alert-modern">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                </div>
            @endif

            <!-- Stats Cards -->
            <div class="row g-4 mb-4">
                <div class="col-xl-3 col-md-6">
                    <div class="stat-card stat-card-1">
                        <div class="stat-icon">
                            <i class="bi bi-file-earmark-text"></i>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-value">{{ $stats['total'] }}</h3>
                            <p class="stat-label">Total Laporan</p>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="stat-card stat-card-2">
                        <div class="stat-icon">
                            <i class="bi bi-clock-history"></i>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-value">{{ $stats['pending'] }}</h3>
                            <p class="stat-label">Pending</p>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="stat-card stat-card-3">
                        <div class="stat-icon">
                            <i class="bi bi-check-circle"></i>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-value">{{ $stats['disetujui'] }}</h3>
                            <p class="stat-label">Disetujui</p>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="stat-card stat-card-4">
                        <div class="stat-icon">
                            <i class="bi bi-x-circle"></i>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-value">{{ $stats['ditolak'] }}</h3>
                            <p class="stat-label">Ditolak</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Laporan Table Card -->
            <div class="rb-card">
                <div class="card-header-rb">
                    <h5 class="mb-0">
                        <i class="bi bi-list-ul me-2"></i>Daftar Laporan
                    </h5>
                    <a href="{{ route('laporan.create') }}" class="btn-rb-sm">
                        <i class="bi bi-plus-circle me-1"></i>Tambah Laporan
                    </a>
                </div>
                <div class="card-body-rb">
                    <div class="table-responsive">
                        <table class="table-rb">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Karyawan</th>
                                    <th>Jenis Laporan</th>
                                    <th>Tanggal</th>
                                    <th>Durasi</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($laporans as $laporan)
                                    <tr>
                                        <td>{{ ($laporans->currentPage() - 1) * $laporans->perPage() + $loop->iteration }}</td>
                                        <td>
                                            <div class="user-cell">
                                                <div class="user-avatar-sm">
                                                    {{ substr($laporan->nama_karyawan, 0, 1) }}
                                                </div>
                                                <strong>{{ $laporan->nama_karyawan }}</strong>
                                            </div>
                                        </td>
                                        <td>
                                            @php
                                                $badges = [
                                                    'sakit' => 'danger',
                                                    'izin' => 'warning',
                                                    'cuti' => 'info',
                                                    'dinas_luar' => 'primary',
                                                    'lainnya' => 'secondary'
                                                ];
                                                $labels = \App\Models\Laporan::getJenisLaporanLabels();
                                            @endphp
                                            <span class="badge bg-{{ $badges[$laporan->jenis_laporan] ?? 'secondary' }}">
                                                {{ $labels[$laporan->jenis_laporan] ?? $laporan->jenis_laporan }}
                                            </span>
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                {{ $laporan->tanggal_mulai->format('d M Y') }} - 
                                                {{ $laporan->tanggal_selesai->format('d M Y') }}
                                            </small>
                                        </td>
                                        <td>{{ $laporan->durasi_hari }} hari</td>
                                        <td>{!! $laporan->status_badge !!}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('laporan.show', $laporan->id) }}" class="btn btn-sm btn-info" title="Detail">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('laporan.edit', $laporan->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route('laporan.destroy', $laporan->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus laporan ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <i class="bi bi-inbox" style="font-size: 3rem; color: #ccc;"></i>
                                            <p class="text-muted mt-2">Belum ada laporan</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($laporans->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $laporans->links() }}
                        </div>
                    @endif
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="row g-4 mt-3">
                <div class="col-md-4">
                    <div class="rb-card">
                        <div class="card-body-rb text-center">
                            <i class="bi bi-heart-pulse" style="font-size: 2.5rem; color: #dc3545;"></i>
                            <h4 class="mt-3">{{ $stats['sakit'] }}</h4>
                            <p class="text-muted">Laporan Sakit</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="rb-card">
                        <div class="card-body-rb text-center">
                            <i class="bi bi-calendar-x" style="font-size: 2.5rem; color: #ffc107;"></i>
                            <h4 class="mt-3">{{ $stats['izin'] }}</h4>
                            <p class="text-muted">Laporan Izin</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="rb-card">
                        <div class="card-body-rb text-center">
                            <i class="bi bi-umbrella-fill" style="font-size: 2.5rem; color: #0dcaf0;"></i>
                            <h4 class="mt-3">{{ $stats['cuti'] }}</h4>
                            <p class="text-muted">Laporan Cuti</p>
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
@endpush
