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
                    <i class="bi bi-clipboard-check me-2"></i>Detail Absensi
                </h4>
            </div>
            <div class="top-bar-right">
                <!-- Theme Toggle Button -->
                <button type="button" class="theme-toggle-btn" id="themeToggle" title="Toggle Dark/Light Mode">
                    <i class="bi bi-moon-stars"></i>
                    <i class="bi bi-sun"></i>
                </button>
                <button type="button" onclick="goToAbsen()" class="btn-action btn-primary">
                    <i class="bi bi-clipboard-fill me-2"></i>Absen Sekarang
                </button>
                <a href="{{ route('presence-detail.export-pdf', $presence->id) }}" target="_blank" class="btn-action btn-pdf">
                    <i class="bi bi-file-earmark-pdf-fill me-2"></i>Export PDF
                </a>
                <a href="{{ route('presence.index') }}" class="btn-action btn-back">
                    <i class="bi bi-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>

        <!-- Dashboard Content -->
        <div class="dashboard-content">
            <!-- Info Card -->
            <div class="rb-card mb-4">
                <div class="card-header-rb">
                    <h5 class="mb-0">
                        <i class="bi bi-info-circle me-2"></i>Informasi Kegiatan
                    </h5>
                </div>
                <div class="card-body-rb">
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label">
                                <i class="bi bi-calendar-event"></i>
                                Nama Kegiatan
                            </div>
                            <div class="info-value">{{ $presence->nama_kegiatan }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">
                                <i class="bi bi-calendar3"></i>
                                Tanggal Kegiatan
                            </div>
                            <div class="info-value">{{ date('d F Y', strtotime($presence->tgl_kegiatan)) }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">
                                <i class="bi bi-clock"></i>
                                Waktu Mulai
                            </div>
                            <div class="info-value">{{ date('H:i', strtotime($presence->tgl_kegiatan)) }} WIB</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Table -->
            <div class="rb-card">
                <div class="card-header-rb">
                    <h5 class="mb-0">
                        <i class="bi bi-people-fill me-2"></i>Daftar Peserta Absen
                    </h5>
                    <div class="header-actions">
                        <span class="badge-rb badge-success">
                            <i class="bi bi-person-check me-1"></i>{{ $presence->details->count() }} Peserta
                        </span>
                    </div>
                </div>
                <div class="card-body-rb">
                    {{ $dataTable->table(['class' => 'table-rb-datatable']) }}
                </div>
            </div>

            {{-- Notice fixed bottom center --}}
            <div id="presence-notice">
                <i class="bi bi-hand-index me-2"></i>Klik "Absen Sekarang" untuk Memulai Absensi
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
@include('layouts.rb-styles')
<style>
    /* ========== ACTION BUTTONS (Detail Absensi) ========== */
    .btn-action {
        padding: 10px 20px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 14px;
        border: 2px solid transparent;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        text-decoration: none;
        color: white;
        cursor: pointer;
    }

    .btn-action.btn-primary {
        background: linear-gradient(135deg, var(--rb-navy), var(--rb-red));
        box-shadow: 0 4px 12px rgba(6, 0, 239, 0.3);
    }

    .btn-action.btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(6, 0, 239, 0.5);
        border-color: var(--rb-yellow);
    }

    .btn-action.btn-pdf {
        background: linear-gradient(135deg, var(--rb-red), #990000);
        box-shadow: 0 4px 12px rgba(220, 0, 0, 0.3);
    }

    .btn-action.btn-pdf:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(220, 0, 0, 0.5);
        border-color: var(--rb-yellow);
        color: white;
    }

    .btn-action.btn-back {
        background: linear-gradient(135deg, var(--bg-tertiary, #252838), var(--bg-secondary, #1a1d2e));
        border: 2px solid rgba(252, 215, 0, 0.3);
        color: var(--rb-yellow);
    }

    .btn-action.btn-back:hover {
        background: linear-gradient(135deg, var(--bg-secondary, #1a1d2e), var(--bg-tertiary, #252838));
        border-color: var(--rb-yellow);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(252, 215, 0, 0.3);
        color: var(--rb-yellow);
    }

    /* Light mode button adjustments */
    body.light-mode .btn-action.btn-back {
        background: linear-gradient(135deg, #e8eaf0, #f0f2f8);
        border-color: rgba(6, 0, 239, 0.3);
        color: var(--rb-navy);
    }

    body.light-mode .btn-action.btn-back:hover {
        background: linear-gradient(135deg, #dce0e8, #e8eaf0);
        border-color: var(--rb-navy);
        color: var(--rb-navy);
    }

    /* ========== INFO GRID (Detail Absensi) ========== */
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
    }

    .info-item {
        background: var(--item-bg, rgba(255, 255, 255, 0.03));
        padding: 20px;
        border-radius: 12px;
        border: 1px solid var(--border-color, rgba(252, 215, 0, 0.15));
        transition: all 0.3s;
    }

    .info-item:hover {
        background: var(--item-hover-bg, rgba(252, 215, 0, 0.05));
        border-color: var(--rb-yellow);
        transform: translateY(-2px);
    }

    .info-label {
        color: var(--text-muted, rgba(255, 255, 255, 0.6));
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 8px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .info-label i {
        color: var(--rb-yellow);
        font-size: 16px;
    }

    .info-value {
        color: var(--text-primary, #fff);
        font-size: 18px;
        font-weight: 700;
        letter-spacing: 0.5px;
    }

    /* ========== DATATABLE STYLING ========== */
    .table-rb-datatable {
        width: 100% !important;
        color: var(--text-primary, #fff);
        border-collapse: separate;
        border-spacing: 0;
    }

    .table-rb-datatable thead th {
        background: linear-gradient(135deg, var(--rb-red), var(--rb-navy));
        color: var(--rb-yellow);
        font-weight: 700;
        text-transform: uppercase;
        font-size: 13px;
        letter-spacing: 1px;
        padding: 15px 12px;
        border: none;
        white-space: nowrap;
    }

    .table-rb-datatable tbody tr {
        background: var(--table-row-bg, rgba(255, 255, 255, 0.03));
        transition: all 0.3s;
    }

    .table-rb-datatable tbody tr:nth-child(even) {
        background: var(--table-row-alt-bg, rgba(255, 255, 255, 0.05));
    }

    .table-rb-datatable tbody tr:hover {
        background: linear-gradient(90deg, rgba(252, 215, 0, 0.1), transparent);
        transform: scale(1.01);
    }

    .table-rb-datatable tbody td {
        padding: 12px;
        border-bottom: 1px solid var(--border-color, rgba(252, 215, 0, 0.1));
        color: var(--text-primary, rgba(255, 255, 255, 0.9));
        font-size: 14px;
    }

    .table-rb-datatable tbody td .signature-img {
        max-width: 150px;
        height: auto;
        border-radius: 8px;
        border: 2px solid var(--rb-yellow);
        box-shadow: 0 4px 12px rgba(252, 215, 0, 0.2);
        transition: all 0.3s;
    }

    .table-rb-datatable tbody td .signature-img:hover {
        transform: scale(1.5);
        box-shadow: 0 8px 24px rgba(252, 215, 0, 0.4);
        z-index: 100;
        cursor: pointer;
    }

    /* DataTable Controls */
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter {
        color: var(--text-muted, rgba(255, 255, 255, 0.8));
        margin-bottom: 20px;
    }

    .dataTables_wrapper .dataTables_length select,
    .dataTables_wrapper .dataTables_filter input {
        background: var(--input-bg, rgba(255, 255, 255, 0.05));
        border: 1px solid var(--border-color, rgba(252, 215, 0, 0.3));
        color: var(--text-primary, #fff);
        padding: 8px 12px;
        border-radius: 8px;
        margin: 0 8px;
    }

    .dataTables_wrapper .dataTables_filter input:focus {
        outline: none;
        border-color: var(--rb-yellow);
        box-shadow: 0 0 8px rgba(252, 215, 0, 0.3);
    }

    .dataTables_wrapper .dataTables_info {
        color: var(--text-muted, rgba(255, 255, 255, 0.6));
        font-size: 13px;
        margin-top: 15px;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        background: var(--paginate-bg, linear-gradient(135deg, var(--rb-dark-3), var(--rb-dark-2)));
        border: 1px solid var(--border-color, rgba(252, 215, 0, 0.3));
        color: var(--rb-yellow) !important;
        padding: 6px 12px;
        margin: 0 4px;
        border-radius: 6px;
        transition: all 0.3s;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: linear-gradient(135deg, var(--rb-red), var(--rb-navy));
        border-color: var(--rb-yellow);
        transform: translateY(-2px);
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: linear-gradient(135deg, var(--rb-red), var(--rb-navy));
        border-color: var(--rb-yellow);
        color: #fff !important;
    }

    /* Action Buttons */
    .btn-delete {
        background: linear-gradient(135deg, var(--rb-red), #990000);
        border: none;
        color: white !important;
        padding: 6px 16px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 13px;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-block;
        cursor: pointer;
    }

    .btn-delete:hover {
        background: linear-gradient(135deg, #990000, var(--rb-red));
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(220, 0, 0, 0.5);
        color: white !important;
        text-decoration: none;
    }

    .btn-delete:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }

    /* ========== NOTICE ========== */
    #presence-notice {
        position: fixed;
        left: 50%;
        transform: translateX(-50%);
        bottom: 18px;
        background: linear-gradient(135deg, var(--rb-yellow), #f0c000);
        color: var(--rb-dark);
        padding: 12px 24px;
        border-radius: 12px;
        box-shadow: 0 4px 16px rgba(252, 215, 0, 0.4);
        font-weight: 700;
        z-index: 1060;
        animation: float 3s ease-in-out infinite;
        border: 2px solid var(--rb-navy);
    }

    @keyframes float {
        0%, 100% { transform: translateX(-50%) translateY(0); }
        50% { transform: translateX(-50%) translateY(-10px); }
    }

    /* ========== LIGHT MODE ADJUSTMENTS ========== */
    body.light-mode .info-item {
        background: rgba(0, 0, 0, 0.03);
    }

    body.light-mode .info-item:hover {
        background: rgba(252, 215, 0, 0.1);
    }

    body.light-mode .info-label {
        color: #555;
    }

    body.light-mode .info-value {
        color: #1a1d2e;
    }

    body.light-mode .table-rb-datatable tbody tr {
        background: rgba(0, 0, 0, 0.02);
    }

    body.light-mode .table-rb-datatable tbody tr:nth-child(even) {
        background: rgba(0, 0, 0, 0.04);
    }

    body.light-mode .table-rb-datatable tbody tr:hover {
        background: rgba(252, 215, 0, 0.15);
    }

    body.light-mode .table-rb-datatable tbody td {
        color: #1a1d2e;
    }

    body.light-mode .dataTables_wrapper .dataTables_length,
    body.light-mode .dataTables_wrapper .dataTables_filter {
        color: #333;
    }

    body.light-mode .dataTables_wrapper .dataTables_length select,
    body.light-mode .dataTables_wrapper .dataTables_filter input {
        background: rgba(0, 0, 0, 0.05);
        border-color: rgba(0, 0, 0, 0.2);
        color: #333;
    }

    body.light-mode .dataTables_wrapper .dataTables_info {
        color: #555;
    }

    body.light-mode .dataTables_wrapper .dataTables_paginate .paginate_button {
        background: linear-gradient(135deg, #e8eaf0, #f0f2f8);
        border-color: rgba(0, 0, 0, 0.15);
        color: var(--rb-navy) !important;
    }

    body.light-mode .dataTables_wrapper .dataTables_paginate .paginate_button:hover,
    body.light-mode .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: linear-gradient(135deg, var(--rb-red), var(--rb-navy));
        color: #fff !important;
    }

    /* ========== RESPONSIVE ========== */
    @media (max-width: 992px) {
        .info-grid {
            grid-template-columns: 1fr;
        }
        
        .top-bar-right {
            flex-wrap: wrap;
            gap: 0.5rem;
        }
        
        .btn-action {
            padding: 8px 14px;
            font-size: 12px;
        }
    }

    @media (max-width: 576px) {
        #presence-notice {
            font-size: 13px;
            padding: 10px 18px;
        }
        
        .btn-action {
            padding: 6px 10px;
            font-size: 11px;
        }
        
        .btn-action i {
            margin-right: 4px !important;
        }
    }
</style>
@endpush

@push('js')
<script>
    // Absen Function
    function goToAbsen() {
        window.location.href = "{{ route('absen.index', $presence->slug) }}";
    }
</script>

{{ $dataTable->scripts(attributes: ['type' => 'module']) }}

<script>
    $(document).ready(function() {
        // Setup CSRF Token untuk semua AJAX request
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Delete Button Handler - menggunakan event delegation untuk DataTable
        $(document).on('click', '.btn-delete', function(e) {
            e.preventDefault();
            
            const $button = $(this);
            const url = $button.attr('href');
            const id = $button.data('id');
            const nama = $button.data('name') || 'peserta ini';
            
            console.log('=== DELETE DEBUG INFO ===');
            console.log('Button element:', $button[0]);
            console.log('Delete URL:', url);
            console.log('Delete ID:', id, '(type:', typeof id, ')');
            console.log('Peserta Name:', nama);
            console.log('========================');

            if (!id) {
                alert('Error: ID tidak ditemukan!');
                console.error('ID is undefined or null');
                return;
            }

            if (confirm('Apakah Anda yakin ingin menghapus data "' + nama + '"?')) {
                // Tampilkan loading
                $button.html('<i class="bi bi-hourglass-split"></i> Menghapus...');
                $button.prop('disabled', true);

                $.ajax({
                    type: 'DELETE',
                    url: url,
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        _method: 'DELETE',
                        id: id // Kirim ID juga di body
                    },
                    dataType: 'json',
                    success: function(response) {
                        console.log('=== SUCCESS RESPONSE ===');
                        console.log(response);
                        console.log('=======================');
                        
                        // Tampilkan pesan sukses
                        alert(response.message || 'Data berhasil dihapus!');
                        
                        // Reload halaman untuk update data
                        window.location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error('=== ERROR RESPONSE ===');
                        console.error('XHR:', xhr);
                        console.error('Response Text:', xhr.responseText);
                        console.error('Status:', status);
                        console.error('Error:', error);
                        console.error('=====================');
                        
                        let errorMessage = 'Gagal menghapus data. Silakan coba lagi.';
                        
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        } else if (xhr.responseText) {
                            try {
                                const parsed = JSON.parse(xhr.responseText);
                                errorMessage = parsed.message || errorMessage;
                            } catch(e) {
                                errorMessage += '\n\nDetail: ' + xhr.responseText.substring(0, 200);
                            }
                        }
                        
                        alert(errorMessage);
                        
                        // Kembalikan tombol ke kondisi semula
                        $button.html('<i class="bi bi-trash-fill"></i> Hapus');
                        $button.prop('disabled', false);
                    }
                });
            }
        });
    });
</script>
@endpush
