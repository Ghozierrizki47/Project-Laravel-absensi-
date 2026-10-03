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
                    <i class="bi bi-plus-circle me-2"></i>Tambah Laporan
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
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="rb-card">
                        <div class="card-header-rb">
                            <h5 class="mb-0">
                                <i class="bi bi-file-earmark-plus me-2"></i>Form Laporan Baru
                            </h5>
                            <a href="{{ route('laporan.index') }}" class="btn-rb-sm">
                                <i class="bi bi-arrow-left me-1"></i>Kembali
                            </a>
                        </div>
                        <div class="card-body-rb">
                            <form action="{{ route('laporan.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="mb-4">
                                    <label for="nama_karyawan" class="form-label">Nama Karyawan <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('nama_karyawan') is-invalid @enderror" 
                                           id="nama_karyawan" name="nama_karyawan" 
                                           value="{{ old('nama_karyawan', Auth::user()->name) }}" required>
                                    @error('nama_karyawan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="jenis_laporan" class="form-label">Jenis Laporan <span class="text-danger">*</span></label>
                                    <select class="form-select @error('jenis_laporan') is-invalid @enderror" 
                                            id="jenis_laporan" name="jenis_laporan" required>
                                        <option value="">-- Pilih Jenis Laporan --</option>
                                        @foreach(\App\Models\Laporan::getJenisLaporanLabels() as $key => $label)
                                            <option value="{{ $key }}" {{ old('jenis_laporan') == $key ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('jenis_laporan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label for="tanggal_mulai" class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control @error('tanggal_mulai') is-invalid @enderror" 
                                               id="tanggal_mulai" name="tanggal_mulai" 
                                               value="{{ old('tanggal_mulai') }}" required>
                                        @error('tanggal_mulai')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <label for="tanggal_selesai" class="form-label">Tanggal Selesai <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control @error('tanggal_selesai') is-invalid @enderror" 
                                               id="tanggal_selesai" name="tanggal_selesai" 
                                               value="{{ old('tanggal_selesai') }}" required>
                                        @error('tanggal_selesai')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="keterangan" class="form-label">Keterangan</label>
                                    <textarea class="form-control @error('keterangan') is-invalid @enderror" 
                                              id="keterangan" name="keterangan" rows="4" 
                                              placeholder="Jelaskan alasan atau detail laporan...">{{ old('keterangan') }}</textarea>
                                    @error('keterangan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="file_pendukung" class="form-label">File Pendukung</label>
                                    <input type="file" class="form-control @error('file_pendukung') is-invalid @enderror" 
                                           id="file_pendukung" name="file_pendukung" 
                                           accept=".pdf,.jpg,.jpeg,.png">
                                    <small class="text-muted">Format: PDF, JPG, JPEG, PNG. Maksimal 2MB</small>
                                    @error('file_pendukung')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('laporan.index') }}" class="btn btn-secondary">
                                        <i class="bi bi-x-circle me-1"></i>Batal
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-check-circle me-1"></i>Simpan Laporan
                                    </button>
                                </div>
                            </form>
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
