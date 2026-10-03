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
            <a href="{{ route('settings') }}" class="nav-link active">
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
                    <i class="bi bi-question-circle me-2"></i>Bantuan & Panduan
                </h4>
            </div>
            <div class="top-bar-right">
                <button id="themeToggle" class="theme-toggle-btn" title="Toggle Dark/Light Mode">
                    <i class="bi bi-moon-stars"></i>
                    <i class="bi bi-sun"></i>
                </button>
                <a href="{{ route('home') }}" class="btn-back">
                    <i class="bi bi-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>

        <!-- Help Content -->
        <div class="settings-content">
            <div class="container-fluid">
                <div class="row g-4">
                    <!-- Usage Guide Card -->
                    <div class="col-lg-6">
                        <div class="rb-card h-100">
                            <div class="card-header-rb">
                                <h5 class="mb-0">
                                    <i class="bi bi-book me-2"></i>Panduan Penggunaan Sistem
                                </h5>
                            </div>
                            <div class="card-body-rb">
                                <div class="help-section">
                                    <h6><i class="bi bi-1-circle-fill me-2"></i>Dashboard</h6>
                                    <p>Halaman utama yang menampilkan statistik kehadiran, kegiatan terbaru, dan quick actions.</p>
                                    
                                    <h6 class="mt-4"><i class="bi bi-2-circle-fill me-2"></i>Daftar Kegiatan</h6>
                                    <p>Menampilkan semua kegiatan yang telah dibuat. Anda dapat melihat detail peserta, export PDF, edit, atau hapus kegiatan.</p>
                                    
                                    <h6 class="mt-4"><i class="bi bi-3-circle-fill me-2"></i>Tambah Kegiatan</h6>
                                    <p>Form untuk membuat kegiatan baru. Masukkan nama kegiatan dan tanggal, sistem akan generate link absensi otomatis.</p>
                                    
                                    <h6 class="mt-4"><i class="bi bi-4-circle-fill me-2"></i>Rekap Bulanan</h6>
                                    <p>Laporan kehadiran per bulan dengan statistik lengkap. Bisa di-export ke PDF atau Excel.</p>
                                    
                                    <h6 class="mt-4"><i class="bi bi-5-circle-fill me-2"></i>Laporan</h6>
                                    <p>Kelola laporan karyawan (sakit, izin, cuti, dinas luar). Admin dapat approve atau reject laporan.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- FAQ Card -->
                    <div class="col-lg-6">
                        <div class="rb-card h-100">
                            <div class="card-header-rb">
                                <h5 class="mb-0">
                                    <i class="bi bi-patch-question me-2"></i>FAQ (Frequently Asked Questions)
                                </h5>
                            </div>
                            <div class="card-body-rb">
                                <div class="faq-list">
                                    <div class="faq-item">
                                        <strong><i class="bi bi-patch-question me-2"></i>Bagaimana cara membuat kegiatan baru?</strong>
                                        <p>Klik menu "Tambah Kegiatan", isi form dengan nama kegiatan dan tanggal, lalu sistem akan generate link absensi otomatis yang bisa dibagikan via QR Code.</p>
                                    </div>
                                    
                                    <div class="faq-item">
                                        <strong><i class="bi bi-patch-question me-2"></i>Bagaimana peserta melakukan absensi?</strong>
                                        <p>Peserta scan QR Code atau klik link absensi, lalu isi form dengan nama, jabatan, foto wajah, dan tanda tangan digital.</p>
                                    </div>
                                    
                                    <div class="faq-item">
                                        <strong><i class="bi bi-patch-question me-2"></i>Apakah bisa export data kehadiran?</strong>
                                        <p>Ya, setiap detail kegiatan bisa di-export ke PDF. Rekap bulanan juga bisa di-export ke Excel format.</p>
                                    </div>
                                    
                                    <div class="faq-item">
                                        <strong><i class="bi bi-patch-question me-2"></i>Bagaimana cara mengajukan izin/cuti?</strong>
                                        <p>Masuk ke menu "Laporan", klik "Buat Laporan Baru", pilih jenis laporan (sakit/izin/cuti), isi detail, dan upload file pendukung jika ada.</p>
                                    </div>
                                    
                                    <div class="faq-item">
                                        <strong><i class="bi bi-patch-question me-2"></i>Bagaimana cara ganti tema Light/Dark?</strong>
                                        <p>Klik icon bulan/matahari di pojok kanan atas navbar (sebelah jam). Preference Anda akan tersimpan otomatis di browser.</p>
                                    </div>
                                    
                                    <div class="faq-item">
                                        <strong><i class="bi bi-patch-question me-2"></i>Siapa yang bisa approve laporan?</strong>
                                        <p>Admin atau supervisor dengan akses penuh di sistem dapat approve atau reject laporan yang diajukan karyawan.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Support Card -->
                    <div class="col-lg-6">
                        <div class="rb-card h-100">
                            <div class="card-header-rb">
                                <h5 class="mb-0">
                                    <i class="bi bi-headset me-2"></i>Butuh Bantuan Lebih Lanjut?
                                </h5>
                            </div>
                            <div class="card-body-rb">
                                <div class="support-info">
                                    <div class="support-item">
                                        <i class="bi bi-envelope-fill"></i>
                                        <div>
                                            <strong>Email Support</strong>
                                            <p>ghozierrizki47@gmail.com</p>
                                        </div>
                                    </div>
                                    
                                    <div class="support-item">
                                        <i class="bi bi-telephone-fill"></i>
                                        <div>
                                            <strong>Telepon</strong>
                                            <p>+62 (08) 1280644650</p>
                                        </div>
                                    </div>
                                    
                                    <div class="support-item">
                                        <i class="bi bi-clock-fill"></i>
                                        <div>
                                            <strong>Jam Operasional</strong>
                                            <p>Senin - Jumat: 08:00 - 17:00 WIB</p>
                                        </div>
                                    </div>
                                    
                                    <div class="support-item">
                                        <i class="bi bi-chat-dots-fill"></i>
                                        <div>
                                            <strong>Live Chat</strong>
                                            <p>Tersedia di dashboard (coming soon)</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Tips Card -->
                    <div class="col-lg-6">
                        <div class="rb-card h-100">
                            <div class="card-header-rb">
                                <h5 class="mb-0">
                                    <i class="bi bi-lightbulb me-2"></i>Tips & Trik
                                </h5>
                            </div>
                            <div class="card-body-rb">
                                <div class="tips-list">
                                    <div class="tip-item">
                                        <span class="tip-badge">💡</span>
                                        <div>
                                            <strong>Gunakan Filter & Search</strong>
                                            <p>Di halaman Daftar Kegiatan dan Laporan, gunakan fitur search dan filter untuk menemukan data lebih cepat.</p>
                                        </div>
                                    </div>
                                    
                                    <div class="tip-item">
                                        <span class="tip-badge">⚡</span>
                                        <div>
                                            <strong>Bookmark Link Absensi</strong>
                                            <p>Save link absensi kegiatan di browser untuk akses cepat tanpa harus login admin.</p>
                                        </div>
                                    </div>
                                    
                                    <div class="tip-item">
                                        <span class="tip-badge">📊</span>
                                        <div>
                                            <strong>Export Rekap Bulanan</strong>
                                            <p>Manfaatkan fitur export Excel di Rekap Bulanan untuk analisa lebih lanjut di aplikasi spreadsheet.</p>
                                        </div>
                                    </div>
                                    
                                    <div class="tip-item">
                                        <span class="tip-badge">📁</span>
                                        <div>
                                            <strong>Upload Dokumen Pendukung</strong>
                                            <p>Saat mengajukan izin/cuti, lampirkan surat keterangan dokter atau dokumen pendukung lainnya.</p>
                                        </div>
                                    </div>
                                    
                                    <div class="tip-item">
                                        <span class="tip-badge">🎨</span>
                                        <div>
                                            <strong>Sesuaikan Tema</strong>
                                            <p>Pilih dark mode untuk penggunaan malam hari dan light mode untuk siang hari sesuai kenyamanan.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- System Info Card -->
                    <div class="col-12">
                        <div class="rb-card">
                            <div class="card-header-rb">
                                <h5 class="mb-0">
                                    <i class="bi bi-info-circle me-2"></i>Informasi Sistem
                                </h5>
                            </div>
                            <div class="card-body-rb">
                                <div class="system-info">
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <div class="info-box">
                                                <i class="bi bi-code-slash"></i>
                                                <h6>Versi Sistem</h6>
                                                <p>v2.1.0 (Feb 2025)</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="info-box">
                                                <i class="bi bi-shield-check"></i>
                                                <h6>Status</h6>
                                                <p><span class="badge bg-success">Active</span></p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="info-box">
                                                <i class="bi bi-speedometer"></i>
                                                <h6>Framework</h6>
                                                <p>Laravel 11 + PHP 8.2</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <hr class="my-3">
                                    
                                    <div class="tech-info">
                                        <h6 class="mb-3"><i class="bi bi-stack me-2"></i>Technology Stack</h6>
                                        <div class="tech-badges">
                                            <span class="badge bg-secondary">Laravel 11</span>
                                            <span class="badge bg-secondary">PHP 8.2</span>
                                            <span class="badge bg-secondary">MySQL</span>
                                            <span class="badge bg-secondary">Bootstrap 5</span>
                                            <span class="badge bg-secondary">DataTables</span>
                                            <span class="badge bg-secondary">DomPDF</span>
                                            <span class="badge bg-secondary">Signature Pad</span>
                                        </div>
                                    </div>
                                    
                                    <hr class="my-3">
                                    
                                    <p class="text-muted mb-0">
                                        <i class="bi bi-building me-2"></i>
                                        Sistem Absensi Karyawan Red Bull Racing PT <br>
                                        © 2025 Oracle Red Bull Racing. All rights reserved.
                                    </p>
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

    .btn-back {
        background: linear-gradient(135deg, var(--rb-red), var(--rb-navy));
        color: white;
        padding: 0.7rem 1.5rem;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        border: 2px solid transparent;
        display: inline-flex;
        align-items: center;
    }

    .btn-back:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(220, 0, 0, 0.4);
        border-color: var(--rb-yellow);
        color: var(--rb-yellow);
    }

    .settings-content {
        padding: 2rem;
    }

    /* RB CARD */
    .rb-card {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(10px);
        border: 2px solid rgba(220, 0, 0, 0.2);
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
    }

    .card-header-rb h5 {
        color: white;
        font-weight: 700;
        letter-spacing: 1px;
        margin: 0;
    }

    .card-body-rb {
        padding: 2rem;
    }

    /* PROJECT INFO */
    .project-info {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .info-item {
        padding: 1.5rem;
        background: rgba(255, 255, 255, 0.03);
        border-left: 4px solid var(--rb-yellow);
        border-radius: 10px;
    }

    .info-label {
        display: flex;
        align-items: center;
        gap: 0.8rem;
        margin-bottom: 0.8rem;
    }

    .info-label i {
        color: var(--rb-yellow);
        font-size: 1.5rem;
    }

    .info-label strong {
        color: white;
        font-size: 1.1rem;
    }

    /* HELP SECTION */
    .help-section h6 {
        color: var(--rb-yellow);
        font-weight: 700;
        margin-bottom: 0.8rem;
        display: flex;
        align-items: center;
    }

    .help-section h6 i {
        color: var(--rb-red);
        margin-right: 0.5rem;
    }

    .help-section p {
        color: rgba(255, 255, 255, 0.8);
        line-height: 1.6;
        padding-left: 2rem;
        font-size: 0.95rem;
    }

    /* FAQ LIST */
    .faq-list {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .faq-item {
        padding: 1.5rem;
        background: rgba(255, 255, 255, 0.03);
        border-left: 4px solid var(--rb-yellow);
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .faq-item:hover {
        background: rgba(220, 0, 0, 0.05);
        transform: translateX(5px);
    }

    .faq-item strong {
        color: white;
        display: flex;
        align-items: center;
        margin-bottom: 0.8rem;
        font-size: 1.05rem;
    }

    .faq-item strong i {
        color: var(--rb-yellow);
    }

    .faq-item p {
        color: rgba(255, 255, 255, 0.7);
        margin: 0;
        line-height: 1.6;
        font-size: 0.95rem;
    }

    /* SUPPORT INFO */
    .support-info {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .support-item {
        display: flex;
        gap: 1.2rem;
        padding: 1.2rem;
        background: rgba(255, 255, 255, 0.03);
        border-left: 4px solid var(--rb-navy);
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .support-item:hover {
        background: rgba(6, 0, 239, 0.05);
        transform: translateX(5px);
    }

    .support-item i {
        color: var(--rb-yellow);
        font-size: 1.8rem;
        width: 40px;
        flex-shrink: 0;
    }

    .support-item strong {
        color: white;
        display: block;
        margin-bottom: 0.3rem;
        font-size: 1.05rem;
    }

    .support-item p {
        color: rgba(255, 255, 255, 0.7);
        margin: 0;
        font-size: 0.95rem;
    }

    /* TIPS LIST */
    .tips-list {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .tip-item {
        display: flex;
        gap: 1.2rem;
        padding: 1.2rem;
        background: rgba(255, 255, 255, 0.03);
        border-radius: 12px;
        transition: all 0.3s ease;
    }

    .tip-item:hover {
        background: rgba(252, 215, 0, 0.05);
        transform: translateX(5px);
    }

    .tip-badge {
        font-size: 2rem;
        width: 50px;
        flex-shrink: 0;
        text-align: center;
    }

    .tip-item strong {
        color: white;
        display: block;
        margin-bottom: 0.5rem;
        font-size: 1.05rem;
    }

    .tip-item p {
        color: rgba(255, 255, 255, 0.7);
        margin: 0;
        line-height: 1.6;
        font-size: 0.95rem;
    }

    /* SYSTEM INFO */
    .system-info {
        color: rgba(255, 255, 255, 0.8);
    }

    .info-box {
        background: rgba(255, 255, 255, 0.03);
        padding: 1.5rem;
        border-radius: 12px;
        text-align: center;
        border: 2px solid rgba(220, 0, 0, 0.2);
        transition: all 0.3s ease;
    }

    .info-box:hover {
        border-color: var(--rb-red);
        background: rgba(220, 0, 0, 0.05);
    }

    .info-box i {
        color: var(--rb-yellow);
        font-size: 2rem;
        margin-bottom: 0.8rem;
    }

    .info-box h6 {
        color: white;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .info-box p {
        color: rgba(255, 255, 255, 0.7);
        margin: 0;
        font-size: 0.95rem;
    }

    .tech-info h6 {
        color: white;
        font-weight: 700;
    }

    .tech-badges {
        display: flex;
        flex-wrap: wrap;
        gap: 0.8rem;
    }

    .tech-badges .badge {
        padding: 0.6rem 1rem;
        font-size: 0.9rem;
        font-weight: 600;
    }

    .system-info hr {
        border-color: rgba(220, 0, 0, 0.2);
    }

    .system-info .text-muted {
        color: rgba(255, 255, 255, 0.6) !important;
        font-size: 0.95rem;
        line-height: 1.6;
    }

    /* PROJECT INFO - Keep for backward compatibility */
    .project-info {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .info-item {
        padding: 1.5rem;
        background: rgba(255, 255, 255, 0.03);
        border-left: 4px solid var(--rb-yellow);
        border-radius: 10px;
    }

    .info-label {
        display: flex;
        align-items: center;
        gap: 0.8rem;
        margin-bottom: 0.8rem;
    }

    .info-label i {
        color: var(--rb-yellow);
        font-size: 1.5rem;
    }

    .info-label strong {
        color: white;
        font-size: 1.1rem;
    }

    .info-item p {
        color: rgba(255, 255, 255, 0.8);
        margin: 0;
        padding-left: 2.3rem;
        font-size: 1rem;
        line-height: 1.6;
    }

    /* PURPOSE LIST */
    .purpose-list {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .purpose-item {
        display: flex;
        gap: 1rem;
        padding: 1.2rem;
        background: rgba(255, 255, 255, 0.02);
        border-radius: 12px;
        transition: all 0.3s ease;
    }

    .purpose-item:hover {
        background: rgba(220, 0, 0, 0.05);
        transform: translateX(5px);
    }

    .purpose-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, var(--rb-red), var(--rb-yellow));
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .purpose-icon i {
        color: white;
        font-size: 1.3rem;
    }

    .purpose-text h6 {
        color: var(--rb-yellow);
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .purpose-text p {
        color: rgba(255, 255, 255, 0.7);
        margin: 0;
        line-height: 1.5;
        font-size: 0.95rem;
    }

    /* BENEFIT LIST */
    .benefit-list {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .benefit-item {
        display: flex;
        gap: 1.2rem;
        padding: 1.2rem;
        background: rgba(255, 255, 255, 0.02);
        border-radius: 12px;
        transition: all 0.3s ease;
    }

    .benefit-item:hover {
        background: rgba(6, 0, 239, 0.05);
        transform: translateX(5px);
    }

    .benefit-number {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, var(--rb-navy), var(--rb-red));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 1.2rem;
        flex-shrink: 0;
    }

    .benefit-content h6 {
        color: var(--rb-yellow);
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .benefit-content p {
        color: rgba(255, 255, 255, 0.7);
        margin: 0;
        line-height: 1.5;
        font-size: 0.95rem;
    }

    /* FEATURES GRID */
    .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
    }

    .feature-box {
        background: rgba(255, 255, 255, 0.03);
        border: 2px solid rgba(220, 0, 0, 0.2);
        border-radius: 15px;
        padding: 1.8rem;
        text-align: center;
        transition: all 0.3s ease;
    }

    .feature-box:hover {
        background: rgba(220, 0, 0, 0.05);
        border-color: var(--rb-red);
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(220, 0, 0, 0.3);
    }

    .feature-icon {
        width: 70px;
        height: 70px;
        background: linear-gradient(135deg, var(--rb-red), var(--rb-yellow));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
    }

    .feature-icon i {
        color: white;
        font-size: 2rem;
    }

    .feature-box h6 {
        color: var(--rb-yellow);
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .feature-box p {
        color: rgba(255, 255, 255, 0.7);
        margin: 0;
        font-size: 0.9rem;
    }

    /* TECH STACK */
    .tech-stack {
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    .tech-category h6 {
        color: white;
        font-weight: 700;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.8rem;
    }

    .tech-category h6 i {
        color: var(--rb-yellow);
        font-size: 1.3rem;
    }

    .tech-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 0.8rem;
    }

    .tech-tag {
        background: linear-gradient(135deg, rgba(220, 0, 0, 0.2), rgba(6, 0, 239, 0.2));
        border: 2px solid rgba(220, 0, 0, 0.3);
        color: white;
        padding: 0.6rem 1.2rem;
        border-radius: 25px;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }

    .tech-tag:hover {
        background: linear-gradient(135deg, var(--rb-red), var(--rb-navy));
        border-color: var(--rb-yellow);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(220, 0, 0, 0.3);
    }

    /* CONTACT INFO - Kept for backward compatibility but not actively used */
    .contact-info {
        color: rgba(255, 255, 255, 0.8);
        line-height: 1.8;
    }

    .contact-list {
        display: flex;
        flex-direction: column;
        gap: 1.2rem;
        margin-top: 1.5rem;
    }

    .contact-item {
        display: flex;
        gap: 1rem;
        padding: 1.2rem;
        background: rgba(255, 255, 255, 0.03);
        border-left: 3px solid var(--rb-yellow);
        border-radius: 10px;
    }

    .contact-item i {
        color: var(--rb-yellow);
        font-size: 1.8rem;
        flex-shrink: 0;
    }

    .contact-item strong {
        color: white;
        display: block;
        margin-bottom: 0.3rem;
    }

    .contact-item p {
        color: rgba(255, 255, 255, 0.7);
        margin: 0;
        font-size: 0.95rem;
    }

    /* COLLAPSED STATE */
    #dashboard-app.sidebar-collapsed .rb-sidebar {
        transform: translateX(-100%);
    }

    /* RESPONSIVE */
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

        .settings-content {
            padding: 1rem;
        }

        .features-grid {
            grid-template-columns: 1fr;
        }
    }

    /* Light mode adjustments for help content */
    body.light-mode .help-section p,
    body.light-mode .faq-item p,
    body.light-mode .support-item p,
    body.light-mode .tip-item p,
    body.light-mode .purpose-text p,
    body.light-mode .benefit-content p,
    body.light-mode .feature-box p {
        color: var(--text-muted);
    }

    body.light-mode .info-label strong,
    body.light-mode .faq-item strong,
    body.light-mode .support-item strong,
    body.light-mode .tip-item strong,
    body.light-mode .card-header-rb h5,
    body.light-mode .tech-category h6,
    body.light-mode .info-box h6 {
        color: var(--text-primary);
    }

    body.light-mode .info-item,
    body.light-mode .faq-item,
    body.light-mode .support-item,
    body.light-mode .tip-item,
    body.light-mode .purpose-item,
    body.light-mode .benefit-item,
    body.light-mode .feature-box,
    body.light-mode .info-box {
        background: var(--card-bg);
    }
</style>
@endpush
