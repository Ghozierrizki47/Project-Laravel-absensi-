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
            <a href="{{ route('presence.index') }}" class="nav-link active">
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
                    <i class="bi bi-table me-2"></i>Daftar Kegiatan
                </h4>
            </div>
            <div class="top-bar-right">
                <button id="themeToggle" class="theme-toggle-btn" title="Toggle Dark/Light Mode">
                    <i class="bi bi-moon-stars"></i>
                    <i class="bi bi-sun"></i>
                </button>
                <a href="{{ route('presence.create') }}" class="btn-add-new">
                    <i class="bi bi-plus-circle me-2"></i>Tambah Kegiatan
                </a>
            </div>
        </div>

        <!-- Dashboard Content -->
        <div class="dashboard-content">
            <div class="rb-card">
                <div class="card-header-rb">
                    <h5 class="mb-0">
                        <i class="bi bi-list-ul me-2"></i>Data Kegiatan
                    </h5>
                    <div class="header-actions">
                        <span class="badge-rb badge-info">
                            <i class="bi bi-database me-1"></i>DataTable Active
                        </span>
                    </div>
                </div>
                <div class="card-body-rb">
                    {{ $dataTable->table(['class' => 'table-rb-datatable']) }}
                </div>
            </div>

            {{-- Notice fixed bottom center --}}
            <div id="presence-notice">
                <i class="bi bi-info-circle me-2"></i>Klik "Detail" untuk Melihat Absen
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}

    <script>
        // AJAX Setup & Delete Handler
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });

        $(document).on('click', '.btn-delete', function(e) {
            e.preventDefault();
            let url = $(this).attr('href');

            if (confirm('🏎️ Apakah Anda yakin ingin menghapus data kegiatan ini?')) {
                $.ajax({
                    type: 'DELETE',
                    url: url,
                    success: function(data) {
                        window.location.reload();
                    },
                    error: function(xhr, status, error) {
                        alert('❌ Gagal menghapus data: ' + error);
                        console.log(error);
                    }
                });
            }
        });
    </script>
@endpush

@push('styles')
@include('layouts.rb-styles')
<style>
    /* DataTable Styling */
    .table-rb-datatable {
        width: 100% !important;
        color: var(--text-primary) !important;
    }

    .table-rb-datatable thead tr {
        border-bottom: 2px solid rgba(220, 0, 0, 0.3);
    }

    .table-rb-datatable thead th {
        padding: 1rem !important;
        font-weight: 700 !important;
        color: var(--rb-yellow) !important;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 1px;
        background: rgba(220, 0, 0, 0.1) !important;
        border: none !important;
    }

    .table-rb-datatable tbody td {
        padding: 1rem !important;
        border-bottom: 1px solid var(--card-border) !important;
        color: var(--text-primary) !important;
        background: transparent !important;
    }

    .table-rb-datatable tbody tr {
        transition: all 0.3s ease;
    }

    .table-rb-datatable tbody tr:hover {
        background: rgba(220, 0, 0, 0.05) !important;
    }

    /* DataTables wrapper styling */
    .dataTables_wrapper {
        color: var(--text-primary) !important;
    }

    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter,
    .dataTables_wrapper .dataTables_info,
    .dataTables_wrapper .dataTables_paginate {
        color: var(--text-secondary) !important;
    }

    .dataTables_wrapper .dataTables_length select,
    .dataTables_wrapper .dataTables_filter input {
        background: var(--input-bg);
        border: 2px solid var(--input-border);
        color: var(--text-primary);
        border-radius: 8px;
        padding: 0.5rem;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        background: rgba(220, 0, 0, 0.1) !important;
        border: 1px solid rgba(220, 0, 0, 0.3) !important;
        color: var(--text-primary) !important;
        border-radius: 8px;
        margin: 0 2px;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: rgba(220, 0, 0, 0.3) !important;
        border-color: var(--rb-red) !important;
        color: var(--rb-yellow) !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: linear-gradient(135deg, var(--rb-red), var(--rb-navy)) !important;
        border-color: var(--rb-red) !important;
        color: white !important;
    }

    /* Add new button */
    .btn-add-new {
        background: linear-gradient(135deg, var(--rb-red), var(--rb-navy));
        color: white;
        padding: 0.8rem 1.5rem;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        border: 2px solid transparent;
        display: flex;
        align-items: center;
    }

    .btn-add-new:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(220, 0, 0, 0.5);
        border-color: var(--rb-yellow);
        color: var(--rb-yellow);
    }

    /* Button styling in table */
    .btn-secondary {
        background: rgba(108, 117, 125, 0.2) !important;
        border: 1px solid #6c757d !important;
        color: var(--text-primary) !important;
        border-radius: 8px;
        padding: 0.4rem 0.8rem;
        font-weight: 600;
        font-size: 0.85rem;
    }

    .btn-secondary:hover {
        background: #6c757d !important;
        color: white !important;
        transform: translateY(-2px);
    }

    .btn-warning {
        background: rgba(252, 215, 0, 0.2) !important;
        border: 1px solid var(--rb-yellow) !important;
        color: var(--rb-yellow) !important;
        border-radius: 8px;
        padding: 0.4rem 0.8rem;
        font-weight: 600;
        font-size: 0.85rem;
    }

    .btn-warning:hover {
        background: var(--rb-yellow) !important;
        color: var(--rb-dark) !important;
        transform: translateY(-2px);
    }

    .btn-danger, .btn-delete {
        background: rgba(220, 0, 0, 0.2) !important;
        border: 1px solid var(--rb-red) !important;
        color: var(--rb-red) !important;
        border-radius: 8px;
        padding: 0.4rem 0.8rem;
        font-weight: 600;
        font-size: 0.85rem;
    }

    .btn-danger:hover, .btn-delete:hover {
        background: var(--rb-red) !important;
        color: white !important;
        transform: translateY(-2px);
    }

    /* Notice */
    #presence-notice {
        position: fixed;
        left: 50%;
        transform: translateX(-50%);
        bottom: 24px;
        background: linear-gradient(135deg, rgba(220, 0, 0, 0.9), rgba(6, 0, 239, 0.9));
        backdrop-filter: blur(10px);
        color: white;
        padding: 1rem 2rem;
        border-radius: 15px;
        box-shadow: 0 8px 30px rgba(220, 0, 0, 0.4);
        font-weight: 700;
        z-index: 1060;
        border: 2px solid var(--rb-yellow);
        animation: float 3s ease-in-out infinite;
        display: flex;
        align-items: center;
    }

    @keyframes float {
        0%, 100% { transform: translateX(-50%) translateY(0); }
        50% { transform: translateX(-50%) translateY(-10px); }
    }

    /* Light mode DataTable adjustments */
    body.light-mode .dataTables_wrapper .dataTables_length select,
    body.light-mode .dataTables_wrapper .dataTables_filter input {
        background: var(--input-bg);
        border-color: var(--input-border);
        color: var(--text-primary);
    }

    body.light-mode .table-rb-datatable tbody td {
        color: var(--text-primary) !important;
    }

    /* RESPONSIVE */
    @media (max-width: 768px) {
        .top-bar {
            padding: 1rem;
            flex-direction: column;
            gap: 1rem;
        }

        .page-title {
            font-size: 1.2rem;
        }

        #presence-notice {
            bottom: 70px;
            font-size: 0.85rem;
            padding: 0.8rem 1.5rem;
        }
    }
</style>
@endpush
