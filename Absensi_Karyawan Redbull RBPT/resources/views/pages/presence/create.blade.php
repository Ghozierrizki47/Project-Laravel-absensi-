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
            <a href="{{ route('presence.create') }}" class="nav-link active">
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
                    <i class="bi bi-plus-circle-fill me-2"></i>Tambah Kegiatan Baru
                </h4>
            </div>
            <div class="top-bar-right">
                <button id="themeToggle" class="theme-toggle-btn" title="Toggle Dark/Light Mode">
                    <i class="bi bi-moon-stars"></i>
                    <i class="bi bi-sun"></i>
                </button>
                <a href="{{ route('presence.index') }}" class="btn-action btn-back">
                    <i class="bi bi-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>

        <!-- Dashboard Content -->
        <div class="dashboard-content">
            <!-- Form Card -->
            <div class="rb-card">
                <div class="card-header-rb">
                    <h5 class="mb-0">
                        <i class="bi bi-clipboard-data me-2"></i>Form Kegiatan
                    </h5>
                    <div class="header-badge">
                        <i class="bi bi-shield-check me-1"></i>
                        <span>Secure Form</span>
                    </div>
                </div>
                <div class="card-body-rb">
                    <form action="{{ route('presence.store') }}" method="post" id="createForm">
                        @csrf
                        <div class="form-group-rb">
                            <label for="nama_kegiatan" class="form-label-rb">
                                <i class="bi bi-calendar-event me-2"></i>Nama Kegiatan
                                <span class="required">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control-rb @error('nama_kegiatan') is-invalid @enderror" 
                                   name="nama_kegiatan" 
                                   id="nama_kegiatan"
                                   value="{{ old('nama_kegiatan') }}"
                                   placeholder="Masukkan nama kegiatan..."
                                   autocomplete="off">
                            @error('nama_kegiatan')
                                <div class="error-message">
                                    <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-row">
                            <div class="form-group-rb">
                                <label for="tgl_kegiatan" class="form-label-rb">
                                    <i class="bi bi-calendar3 me-2"></i>Tanggal Kegiatan
                                    <span class="required">*</span>
                                </label>
                                <input type="date" 
                                       class="form-control-rb @error('tgl_kegiatan') is-invalid @enderror" 
                                       name="tgl_kegiatan" 
                                       id="tgl_kegiatan"
                                       value="{{ old('tgl_kegiatan') }}">
                                @error('tgl_kegiatan')
                                    <div class="error-message">
                                        <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group-rb">
                                <label for="waktu_mulai" class="form-label-rb">
                                    <i class="bi bi-clock me-2"></i>Waktu Mulai
                                    <span class="required">*</span>
                                </label>
                                <input type="time" 
                                       class="form-control-rb @error('waktu_mulai') is-invalid @enderror" 
                                       name="waktu_mulai" 
                                       id="waktu_mulai"
                                       value="{{ old('waktu_mulai') }}">
                                @error('waktu_mulai')
                                    <div class="error-message">
                                        <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn-submit">
                                <i class="bi bi-check-circle me-2"></i>Simpan Kegiatan
                                <span class="btn-glow"></span>
                            </button>
                            <button type="reset" class="btn-reset">
                                <i class="bi bi-arrow-counterclockwise me-2"></i>Reset Form
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Info Notice -->
            <div class="info-notice">
                <i class="bi bi-info-circle me-2"></i>
                Pastikan semua data telah diisi dengan benar sebelum menyimpan
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
@include('layouts.rb-styles')
<style>
    /* Back button styling */
    .btn-action.btn-back {
        background: linear-gradient(135deg, rgba(6, 0, 239, 0.2), rgba(220, 0, 0, 0.2));
        border: 2px solid var(--rb-red);
        color: var(--text-primary);
        padding: 12px 24px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 14px;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .btn-action.btn-back:hover {
        background: linear-gradient(135deg, var(--rb-red), var(--rb-navy));
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(220, 0, 0, 0.4);
        border-color: var(--rb-yellow);
    }

    .btn-action.btn-back i {
        font-size: 16px;
        transition: transform 0.3s ease;
    }

    .btn-action.btn-back:hover i {
        transform: translateX(-3px);
    }

    /* Form specific styling only */
    .form-group-rb {
        margin-bottom: 25px;
    }

    .form-label-rb {
        color: var(--text-secondary);
        font-weight: 600;
        font-size: 15px;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        letter-spacing: 0.5px;
    }

    .required {
        color: var(--rb-red);
        margin-left: 5px;
        font-size: 18px;
    }

    .form-control-rb {
        width: 100%;
        padding: 14px 18px;
        background: var(--input-bg);
        border: 2px solid var(--input-border);
        border-radius: 12px;
        color: var(--text-primary);
        font-size: 15px;
        font-weight: 500;
        transition: all 0.3s;
        font-family: 'Rajdhani', sans-serif;
    }

    .form-control-rb:focus {
        outline: none;
        border-color: var(--rb-yellow);
        background: var(--input-bg);
        box-shadow: 0 0 15px rgba(252, 215, 0, 0.2);
    }

    .form-control-rb::placeholder {
        color: var(--text-muted);
    }

    .form-control-rb.is-invalid {
        border-color: var(--rb-red);
        box-shadow: 0 0 10px rgba(220, 0, 0, 0.3);
    }

    .error-message {
        color: var(--rb-red);
        font-size: 13px;
        margin-top: 8px;
        display: flex;
        align-items: center;
        font-weight: 600;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .form-actions {
        display: flex;
        gap: 15px;
        margin-top: 35px;
        padding-top: 25px;
        border-top: 2px solid rgba(252, 215, 0, 0.1);
    }

    .btn-submit {
        flex: 1;
        background: linear-gradient(135deg, var(--rb-red), var(--rb-navy));
        color: white;
        padding: 15px 30px;
        border: none;
        border-radius: 12px;
        font-weight: 700;
        font-size: 16px;
        text-transform: uppercase;
        letter-spacing: 1px;
        cursor: pointer;
        transition: all 0.3s;
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 15px rgba(220, 0, 0, 0.3);
    }

    .btn-submit:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(220, 0, 0, 0.5);
    }

    .btn-submit:active {
        transform: translateY(-1px);
    }

    .btn-glow {
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: linear-gradient(45deg, transparent, rgba(252, 215, 0, 0.3), transparent);
        animation: btnGlow 3s linear infinite;
    }

    @keyframes btnGlow {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .btn-reset {
        background: var(--card-bg);
        color: var(--text-secondary);
        padding: 15px 30px;
        border: 2px solid var(--card-border);
        border-radius: 12px;
        font-weight: 600;
        font-size: 16px;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-reset:hover {
        background: var(--bg-tertiary);
        border-color: var(--rb-yellow);
        color: var(--rb-yellow);
        transform: translateY(-2px);
    }

    .info-notice {
        margin-top: 20px;
        background: linear-gradient(135deg, rgba(6, 0, 239, 0.1), rgba(220, 0, 0, 0.1));
        border: 2px solid var(--card-border);
        border-radius: 12px;
        padding: 15px 20px;
        color: var(--text-secondary);
        font-weight: 600;
        display: flex;
        align-items: center;
        animation: float 3s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-5px); }
    }

    @media (max-width: 992px) {
        .form-row {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 576px) {
        .dashboard-content {
            padding: 15px;
        }
        .page-title {
            font-size: 18px;
        }
        .btn-action {
            padding: 8px 14px;
            font-size: 12px;
        }
        .form-actions {
            flex-direction: column;
        }
    }
</style>
@endpush

@push('js')
<script>
    // Form validation animation
    document.getElementById('createForm').addEventListener('submit', function(e) {
        const submitBtn = this.querySelector('.btn-submit');
        submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Menyimpan...';
        submitBtn.style.opacity = '0.7';
        submitBtn.disabled = true;
    });

    // Auto focus first input
    document.addEventListener('DOMContentLoaded', function() {
        const firstInput = document.getElementById('nama_kegiatan');
        if (firstInput) {
            firstInput.focus();
        }
    });
</script>
@endpush
