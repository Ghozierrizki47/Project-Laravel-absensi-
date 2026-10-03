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
                    <i class="bi bi-eye me-2"></i>Detail Laporan
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

            <div class="row">
                <div class="col-lg-8">
                    <div class="rb-card">
                        <div class="card-header-rb">
                            <h5 class="mb-0">
                                <i class="bi bi-info-circle me-2"></i>Informasi Laporan
                            </h5>
                            <a href="{{ route('laporan.index') }}" class="btn-rb-sm">
                                <i class="bi bi-arrow-left me-1"></i>Kembali
                            </a>
                        </div>
                        <div class="card-body-rb">
                            <table class="table table-borderless">
                                <tr>
                                    <th style="width: 200px;">Nama Karyawan</th>
                                    <td>: {{ $laporan->nama_karyawan }}</td>
                                </tr>
                                <tr>
                                    <th>Jenis Laporan</th>
                                    <td>
                                        : @php
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
                                </tr>
                                <tr>
                                    <th>Tanggal Mulai</th>
                                    <td>: {{ $laporan->tanggal_mulai->format('d F Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Selesai</th>
                                    <td>: {{ $laporan->tanggal_selesai->format('d F Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Durasi</th>
                                    <td>: {{ $laporan->durasi_hari }} hari</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>: {!! $laporan->status_badge !!}</td>
                                </tr>
                                <tr>
                                    <th>Keterangan</th>
                                    <td>: {{ $laporan->keterangan ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>File Pendukung</th>
                                    <td>
                                        : @if($laporan->file_pendukung)
                                            <a href="{{ asset('storage/' . $laporan->file_pendukung) }}" target="_blank" class="btn btn-sm btn-primary">
                                                <i class="bi bi-download me-1"></i>Download File
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Dibuat Pada</th>
                                    <td>: {{ $laporan->created_at->format('d F Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <!-- Update Status -->
                    <div class="rb-card mb-4">
                        <div class="card-header-rb">
                            <h5 class="mb-0">
                                <i class="bi bi-gear me-2"></i>Update Status
                            </h5>
                        </div>
                        <div class="card-body-rb">
                            <form action="{{ route('laporan.updateStatus', $laporan->id) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select name="status" id="status" class="form-select" required>
                                        <option value="pending" {{ $laporan->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="disetujui" {{ $laporan->status == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                                        <option value="ditolak" {{ $laporan->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="bi bi-check-circle me-1"></i>Update Status
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="rb-card">
                        <div class="card-header-rb">
                            <h5 class="mb-0">
                                <i class="bi bi-lightning me-2"></i>Aksi
                            </h5>
                        </div>
                        <div class="card-body-rb">
                            <div class="d-grid gap-2">
                                <a href="{{ route('laporan.edit', $laporan->id) }}" class="btn btn-warning">
                                    <i class="bi bi-pencil me-1"></i>Edit Laporan
                                </a>
                                <form action="{{ route('laporan.destroy', $laporan->id) }}" method="POST" 
                                      onsubmit="return confirm('Yakin ingin menghapus laporan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger w-100">
                                        <i class="bi bi-trash me-1"></i>Hapus Laporan
                                    </button>
                                </form>
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
@endpush

@push('js')
@include('layouts.rb-scripts')
@endpush
