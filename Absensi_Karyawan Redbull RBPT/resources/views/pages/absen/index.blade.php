<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ env('APP_NAME') }} - Absensi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@400;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --rb-navy: #0600EF;
            --rb-red: #DC0000;
            --rb-yellow: #FCD700;
            --rb-dark: #0c0e16;
            --rb-dark-2: #1a1d2e;
            --rb-dark-3: #252838;
            --text-primary: #ffffff;
            --text-secondary: rgba(255, 255, 255, 0.7);
            --text-muted: rgba(255, 255, 255, 0.5);
            --bg-primary: linear-gradient(135deg, var(--rb-dark) 0%, var(--rb-dark-2) 100%);
            --bg-card: linear-gradient(135deg, rgba(26, 29, 46, 0.95), rgba(37, 40, 56, 0.95));
            --bg-header: linear-gradient(135deg, var(--rb-dark-2), var(--rb-dark-3));
            --border-color: rgba(252, 215, 0, 0.2);
            --input-bg: rgba(255, 255, 255, 0.05);
        }

        /* Light Mode */
        body.light-mode {
            --rb-dark: #f5f5f5;
            --rb-dark-2: #ffffff;
            --rb-dark-3: #e8e8e8;
            --text-primary: #1a1d2e;
            --text-secondary: rgba(26, 29, 46, 0.7);
            --text-muted: rgba(26, 29, 46, 0.5);
            --bg-primary: linear-gradient(135deg, #f5f5f5 0%, #ffffff 100%);
            --bg-card: linear-gradient(135deg, rgba(255, 255, 255, 0.95), rgba(248, 248, 248, 0.95));
            --bg-header: linear-gradient(135deg, #ffffff, #f0f0f0);
            --border-color: rgba(220, 0, 0, 0.2);
            --input-bg: rgba(0, 0, 0, 0.05);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Rajdhani', sans-serif;
            background: var(--bg-primary);
            color: var(--text-primary);
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }

        /* Racing Stripe */
        .racing-stripe {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, 
                var(--rb-red) 0%, 
                var(--rb-red) 33%, 
                var(--rb-yellow) 33%, 
                var(--rb-yellow) 66%, 
                var(--rb-navy) 66%, 
                var(--rb-navy) 100%
            );
            z-index: 1050;
            animation: raceStripe 3s linear infinite;
        }

        @keyframes raceStripe {
            0% { background-position: 0 0; }
            100% { background-position: 100px 0; }
        }

        /* Header */
        .rb-header {
            background: var(--bg-header);
            padding: 30px 0;
            text-align: center;
            border-bottom: 3px solid var(--rb-yellow);
            margin-bottom: 30px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            position: relative;
        }

        body.light-mode .rb-header {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .header-navigation {
            position: absolute;
            top: 20px;
            left: 20px;
            display: flex;
            gap: 10px;
            z-index: 10;
        }

        .header-actions {
            position: absolute;
            top: 20px;
            right: 20px;
            display: flex;
            gap: 10px;
            z-index: 10;
        }

        .btn-nav {
            width: 45px;
            height: 45px;
            border-radius: 10px;
            background: linear-gradient(135deg, rgba(252,215,0,0.2) 0%, rgba(220,0,0,0.2) 100%);
            border: 2px solid rgba(252,215,0,0.5);
            color: #FCD700;
            font-size: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        body.light-mode .btn-nav {
            background: linear-gradient(135deg, rgba(220,0,0,0.1) 0%, rgba(6,0,239,0.1) 100%);
            border: 2px solid var(--rb-red);
            color: var(--rb-red);
        }

        .btn-nav:hover {
            background: linear-gradient(135deg, rgba(252,215,0,0.4) 0%, rgba(220,0,0,0.4) 100%);
            border-color: #FCD700;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(252,215,0,0.3);
            color: #FCD700;
        }

        body.light-mode .btn-nav:hover {
            background: linear-gradient(135deg, var(--rb-red), var(--rb-navy));
            border-color: var(--rb-red);
            color: #fff;
            box-shadow: 0 5px 15px rgba(220,0,0,0.3);
        }

        .btn-nav:active {
            transform: translateY(0);
        }

        .theme-toggle-btn {
            width: 45px;
            height: 45px;
            border-radius: 10px;
            background: linear-gradient(135deg, rgba(252,215,0,0.2) 0%, rgba(220,0,0,0.2) 100%);
            border: 2px solid rgba(252,215,0,0.5);
            color: #FCD700;
            font-size: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        body.light-mode .theme-toggle-btn {
            background: linear-gradient(135deg, rgba(220,0,0,0.1) 0%, rgba(6,0,239,0.1) 100%);
            border: 2px solid var(--rb-red);
            color: var(--rb-red);
        }

        .theme-toggle-btn:hover {
            background: linear-gradient(135deg, rgba(252,215,0,0.4) 0%, rgba(220,0,0,0.4) 100%);
            border-color: #FCD700;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(252,215,0,0.3);
        }

        body.light-mode .theme-toggle-btn:hover {
            background: linear-gradient(135deg, var(--rb-red), var(--rb-navy));
            border-color: var(--rb-red);
            color: #fff;
            box-shadow: 0 5px 15px rgba(220,0,0,0.3);
        }

        .rb-logo-container {
            display: inline-flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 15px;
        }

        .rb-logo {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, rgba(6, 0, 239, 0.2), rgba(220, 0, 0, 0.2));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 3px solid var(--rb-yellow);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(252, 215, 0, 0.7); }
            50% { transform: scale(1.05); box-shadow: 0 0 20px 10px rgba(252, 215, 0, 0); }
        }

        .rb-logo svg {
            width: 60px;
            height: 60px;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.3));
        }

        .rb-header h1 {
            color: var(--rb-yellow);
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin: 0;
            font-size: 2.5rem;
        }

        .rb-header .subtitle {
            color: rgba(255, 255, 255, 0.7);
            font-size: 1.1rem;
            font-weight: 600;
        }

        /* Cards */
        .rb-card {
            background: var(--bg-card);
            border-radius: 16px;
            border: 2px solid var(--border-color);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
            overflow: hidden;
            transition: all 0.3s;
            margin-bottom: 25px;
        }

        body.light-mode .rb-card {
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .rb-card:hover {
            border-color: var(--rb-yellow);
            box-shadow: 0 12px 40px rgba(252, 215, 0, 0.2);
            transform: translateY(-4px);
        }

        body.light-mode .rb-card:hover {
            border-color: var(--rb-red);
            box-shadow: 0 12px 40px rgba(220, 0, 0, 0.15);
        }

        .card-header-rb {
            background: linear-gradient(135deg, rgba(6, 0, 239, 0.15), rgba(220, 0, 0, 0.15));
            border-bottom: 2px solid rgba(252, 215, 0, 0.3);
            padding: 20px 25px;
        }

        body.light-mode .card-header-rb {
            background: linear-gradient(135deg, rgba(220, 0, 0, 0.05), rgba(6, 0, 239, 0.05));
            border-bottom: 2px solid rgba(220, 0, 0, 0.2);
        }

        .card-header-rb h5 {
            color: var(--rb-yellow);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        body.light-mode .card-header-rb h5 {
            color: var(--rb-red);
        }

        .card-body-rb {
            padding: 25px;
        }

        /* Info Table */
        .info-table {
            width: 100%;
            color: var(--text-primary);
        }

        .info-table td {
            padding: 10px 0;
            border-bottom: 1px solid var(--border-color);
        }

        .info-table td:first-child {
            color: var(--text-secondary);
            font-weight: 600;
        }

        .info-table td:last-child {
            color: var(--text-primary);
            font-weight: 700;
        }

        /* Form */
        .form-label-rb {
            color: var(--text-primary);
            font-weight: 600;
            font-size: 15px;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-control-rb {
            background: var(--input-bg);
            border: 2px solid var(--border-color);
            border-radius: 10px;
            color: var(--text-primary);
            padding: 12px 15px;
            transition: all 0.3s;
            font-family: 'Rajdhani', sans-serif;
            font-weight: 500;
        }

        .form-control-rb:focus {
            background: var(--input-bg);
            border-color: var(--rb-yellow);
            box-shadow: 0 0 15px rgba(252, 215, 0, 0.2);
            color: var(--text-primary);
        }

        body.light-mode .form-control-rb:focus {
            border-color: var(--rb-red);
            box-shadow: 0 0 15px rgba(220, 0, 0, 0.15);
        }

        .form-control-rb::placeholder {
            color: var(--text-muted);
        }

        /* Signature Pad */
        .signature-container {
            background: var(--input-bg);
            border: 2px solid var(--border-color);
            border-radius: 12px;
            padding: 10px;
            margin-bottom: 10px;
        }

        body.light-mode .signature-container {
            border-color: rgba(220, 0, 0, 0.3);
        }

        #signature-pad {
            border-radius: 8px;
            background: white;
            cursor: crosshair;
        }

        /* Buttons */
        .btn-rb {
            background: linear-gradient(135deg, var(--rb-red), var(--rb-navy));
            border: none;
            color: white;
            padding: 12px 25px;
            border-radius: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s;
            cursor: pointer;
        }

        .btn-rb:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(220, 0, 0, 0.4);
            color: white;
        }

        .btn-rb-clear {
            background: var(--input-bg);
            border: 2px solid var(--border-color);
            color: var(--text-secondary);
            padding: 8px 15px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-rb-clear:hover {
            background: rgba(220, 0, 0, 0.1);
            border-color: var(--rb-red);
            color: var(--rb-red);
        }

        body.light-mode .btn-rb-clear:hover {
            background: rgba(220, 0, 0, 0.1);
            border-color: var(--rb-red);
            color: var(--rb-red);
        }

        /* DataTable */
        .table-rb {
            color: var(--text-primary) !important;
        }

        .table-rb thead th {
            background: linear-gradient(135deg, var(--rb-red), var(--rb-navy));
            color: var(--rb-yellow) !important;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 13px;
            letter-spacing: 1px;
            padding: 15px 12px;
            border: none;
        }

        .table-rb tbody tr {
            background: rgba(26, 29, 46, 0.6);
            transition: all 0.3s;
        }

        body.light-mode .table-rb tbody tr {
            background: rgba(255, 255, 255, 0.8);
        }

        .table-rb tbody tr:nth-child(even) {
            background: rgba(37, 40, 56, 0.6);
        }

        body.light-mode .table-rb tbody tr:nth-child(even) {
            background: rgba(248, 248, 248, 0.9);
        }

        .table-rb tbody tr:hover {
            background: linear-gradient(90deg, rgba(252, 215, 0, 0.2), rgba(37, 40, 56, 0.8));
        }

        body.light-mode .table-rb tbody tr:hover {
            background: linear-gradient(90deg, rgba(220, 0, 0, 0.1), rgba(255, 255, 255, 0.95));
        }

        .table-rb tbody td {
            padding: 14px 12px;
            border-bottom: 1px solid var(--border-color);
            color: var(--text-primary);
            font-weight: 600;
            font-size: 15px;
        }

        .table-rb img {
            border-radius: 8px;
            border: 2px solid var(--rb-yellow);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
        }

        body.light-mode .table-rb img {
            border-color: var(--rb-red);
        }

        /* DataTable Controls */
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            color: var(--text-primary) !important;
        }

        .dataTables_wrapper .dataTables_length label,
        .dataTables_wrapper .dataTables_filter label {
            color: var(--text-primary) !important;
            font-weight: 700;
            font-size: 15px;
        }

        .dataTables_wrapper .dataTables_info {
            color: var(--rb-yellow) !important;
            font-weight: 700;
            font-size: 15px;
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.5);
        }

        body.light-mode .dataTables_wrapper .dataTables_info {
            color: var(--rb-red) !important;
            text-shadow: none;
        }

        .dataTables_wrapper .dataTables_length select,
        .dataTables_wrapper .dataTables_filter input {
            background: var(--input-bg);
            border: 2px solid var(--rb-yellow);
            color: var(--text-primary);
            padding: 8px 12px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
        }

        body.light-mode .dataTables_wrapper .dataTables_length select,
        body.light-mode .dataTables_wrapper .dataTables_filter input {
            border-color: var(--rb-red);
            background: rgba(255, 255, 255, 0.9);
        }

        .dataTables_wrapper .dataTables_length select:focus,
        .dataTables_wrapper .dataTables_filter input:focus {
            background: rgba(255, 255, 255, 0.25);
            border-color: var(--rb-yellow);
            outline: none;
            box-shadow: 0 0 15px rgba(252, 215, 0, 0.5);
        }

        body.light-mode .dataTables_wrapper .dataTables_length select:focus,
        body.light-mode .dataTables_wrapper .dataTables_filter input:focus {
            border-color: var(--rb-red);
            box-shadow: 0 0 15px rgba(220, 0, 0, 0.2);
        }

        .dataTables_wrapper .dataTables_length select option {
            background: var(--rb-dark-2);
            color: var(--text-primary);
            font-weight: 600;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            background: var(--input-bg) !important;
            border: 2px solid rgba(252, 215, 0, 0.4) !important;
            color: var(--rb-yellow) !important;
            border-radius: 8px;
            margin: 0 4px;
            padding: 6px 12px !important;
            font-weight: 600;
        }

        body.light-mode .dataTables_wrapper .dataTables_paginate .paginate_button {
            border-color: rgba(220, 0, 0, 0.4) !important;
            color: var(--rb-red) !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: linear-gradient(135deg, var(--rb-red), var(--rb-navy)) !important;
            border-color: var(--rb-yellow) !important;
            color: #fff !important;
        }

        body.light-mode .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            border-color: var(--rb-red) !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: linear-gradient(135deg, var(--rb-red), var(--rb-navy)) !important;
            border-color: var(--rb-yellow) !important;
            color: #fff !important;
            box-shadow: 0 4px 12px rgba(252, 215, 0, 0.3);
        }

        body.light-mode .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            border-color: var(--rb-red) !important;
            box-shadow: 0 4px 12px rgba(220, 0, 0, 0.3);
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
            opacity: 0.4;
            cursor: not-allowed;
        }

        /* Alert */
        .alert-rb {
            background: linear-gradient(135deg, rgba(34, 197, 94, 0.2), rgba(34, 197, 94, 0.1));
            border: 2px solid rgba(34, 197, 94, 0.5);
            color: #4ade80;
            border-radius: 12px;
            padding: 15px 20px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: slideIn 0.5s ease;
        }

        @keyframes slideIn {
            from { transform: translateY(-20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .error-message {
            color: var(--rb-red);
            font-size: 13px;
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .rb-header h1 {
                font-size: 1.8rem;
            }
            .card-body-rb {
                padding: 15px;
            }
        }
    </style>
</head>

<body>
    <div class="racing-stripe"></div>

    <!-- Header -->
    <div class="rb-header">
        <div class="header-navigation">
            <button onclick="history.back()" class="btn-nav" title="Kembali">
                <i class="bi bi-arrow-left"></i>
            </button>
            <a href="{{ route('home') }}" class="btn-nav" title="Dashboard">
                <i class="bi bi-house-fill"></i>
            </a>
        </div>
        <div class="header-actions">
            <button id="theme-toggle" class="theme-toggle-btn" title="Toggle Theme">
                <i class="bi bi-sun-fill"></i>
            </button>
        </div>
        <div class="rb-logo-container">
            <div class="rb-logo">
                <img src="https://upload.wikimedia.org/wikipedia/id/thumb/3/39/Red_Bull_GmbH_logo.svg/1200px-Red_Bull_GmbH_logo.svg.png" alt="Red Bull" style="width: 100%; height: 100%; object-fit: contain;">
            </div>
        </div>
        <h1>{{ env('APP_NAME') }}</h1>
        <div class="subtitle">Red Bull Racing - Attendance System</div>
    </div>

    <div class="container my-5">
        <!-- Info Card -->
        <div class="rb-card mb-4">
            <div class="card-header-rb">
                <h5><i class="bi bi-info-circle"></i> Informasi Kegiatan</h5>
            </div>
            <div class="card-body-rb">
                <table class="info-table">
                    <tr>
                        <td width="180"><i class="bi bi-calendar-event"></i> Nama Kegiatan</td>
                        <td width="20">:</td>
                        <td><strong>{{ $presence->nama_kegiatan }}</strong></td>
                    </tr>
                    <tr>
                        <td><i class="bi bi-calendar3"></i> Tanggal Kegiatan</td>
                        <td>:</td>
                        <td>{{ date('d F Y', strtotime($presence->tgl_kegiatan)) }}</td>
                    </tr>
                    <tr>
                        <td><i class="bi bi-clock"></i> Waktu Mulai</td>
                        <td>:</td>
                        <td>{{ date('H:i', strtotime($presence->waktu_mulai)) }} WIB</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-5 col-md-6">
                <!-- Form Card -->
                <div class="rb-card">
                    <div class="card-header-rb">
                        <h5><i class="bi bi-pencil-square"></i> Form Absensi</h5>
                    </div>
                    <div class="card-body-rb">
                        <form id="form-absen" action="{{ route('absen.save', $presence->slug) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            
                            <!-- Nama -->
                            <div class="mb-3">
                                <label for="nama" class="form-label-rb">
                                    <i class="bi bi-person"></i> Nama Lengkap
                                </label>
                                <input type="text" class="form-control form-control-rb" id="nama" name="nama" placeholder="Masukkan nama lengkap" required>
                                @error('nama')
                                    <div class="error-message"><i class="bi bi-exclamation-circle"></i>{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Jabatan -->
                            <div class="mb-3">
                                <label for="jabatan" class="form-label-rb">
                                    <i class="bi bi-briefcase"></i> Jabatan
                                </label>
                                <input type="text" class="form-control form-control-rb" id="jabatan" name="jabatan" placeholder="Masukkan jabatan" required>
                                @error('jabatan')
                                    <div class="error-message"><i class="bi bi-exclamation-circle"></i>{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Asal Instansi -->
                            <div class="mb-3">
                                <label for="asal_instansi" class="form-label-rb">
                                    <i class="bi bi-building"></i> Asal Instansi
                                </label>
                                <input type="text" class="form-control form-control-rb" id="asal_instansi" name="asal_instansi" placeholder="Masukkan asal instansi" required>
                                @error('asal_instansi')
                                    <div class="error-message"><i class="bi bi-exclamation-circle"></i>{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Signature Pad -->
                            <div class="mb-3">
                                <label class="form-label-rb">
                                    <i class="bi bi-pen"></i> Tanda Tangan
                                </label>
                                <div class="signature-container">
                                    <canvas id="signature-pad" class="signature-pad"></canvas>
                                </div>
                                <textarea name="signature" id="signature64" class="d-none"></textarea>
                                @error('signature')
                                    <div class="error-message"><i class="bi bi-exclamation-circle"></i>{{ $message }}</div>
                                @enderror
                                <button type="button" id="clear" class="btn btn-rb-clear">
                                    <i class="bi bi-eraser"></i> Hapus Tanda Tangan
                                </button>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-rb w-100">
                                <i class="bi bi-check-circle"></i> Submit Absensi
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-7 col-md-6">
                <!-- Daftar Kehadiran Card -->
                <div class="rb-card">
                    <div class="card-header-rb">
                        <h5><i class="bi bi-people-fill"></i> Daftar Kehadiran</h5>
                    </div>
                    <div class="card-body-rb">
                        {{ $dataTable->table(['class' => 'table table-rb table-striped']) }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="{{ asset('js/signature.min.js') }}"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>

    <script>
        $(function() {
            // SIGNATURE PAD
            let sig = $('.signature-container').width() - 20;
            $('#signature-pad').attr('width', sig);
            $('#signature-pad').attr('height', 150);

            let signaturePad = new SignaturePad(document.getElementById('signature-pad'), {
                backgroundColor: 'rgb(255, 255, 255)',
                penColor: 'rgb(0, 0, 0)',
                minWidth: 1,
                maxWidth: 3
            });

            $('canvas#signature-pad').on('mouseup touchend', function() {
                $('#signature64').val(signaturePad.toDataURL());
            });

            $('#clear').on('click', function(e) {
                e.preventDefault();
                signaturePad.clear();
                $('#signature64').val('');
            });

            // AJAX Form Submit
            $('#form-absen').on('submit', function(e) {
                e.preventDefault();

                // Validation
                if (signaturePad.isEmpty()) {
                    alert('⚠️ Mohon isi tanda tangan!');
                    return;
                }

                let formData  = new FormData(this);
                let url       = $(this).attr('action');
                let submitBtn = $(this).find('button[type="submit"]');
                let originalText = submitBtn.html();

                submitBtn.prop('disabled', true).html('<i class="bi bi-hourglass-split"></i> Menyimpan...');

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        console.log('✅ Absensi berhasil disimpan:', response);
                        
                        // Reset form
                        $('#form-absen')[0].reset();
                        signaturePad.clear();
                        $('#signature64').val('');
                        
                        submitBtn.prop('disabled', false).html(originalText);

                        // Success alert
                        let successMsg = '<div class="alert-rb mb-3" id="success-alert">' +
                            '<i class="bi bi-check-circle-fill"></i>' +
                            '<span>Absensi berhasil disimpan!</span>' +
                            '</div>';
                        $('.rb-card:first .card-body-rb').prepend(successMsg);
                        
                        // Reload DataTable - gunakan ID spesifik dan callback
                        setTimeout(function() {
                            let table = $('#absen-table').DataTable();
                            if (table) {
                                console.log('🔄 Reloading DataTable...');
                                table.ajax.reload(function() {
                                    console.log('✅ DataTable berhasil di-reload');
                                }, false); // false = tetap di halaman saat ini
                            } else {
                                console.warn('⚠️ DataTable tidak ditemukan');
                            }
                        }, 500); // Delay 500ms untuk memastikan data sudah tersimpan di database
                        
                        setTimeout(function() {
                            $('#success-alert').fadeOut(function() {
                                $(this).remove();
                            });
                        }, 3000);
                    },
                    error: function(xhr) {
                        submitBtn.prop('disabled', false).html(originalText);
                        let msg = 'Gagal menyimpan data';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            msg = xhr.responseJSON.message;
                        }
                        alert('❌ Error: ' + msg);
                        console.error('Error details:', xhr);
                    }
                });
            });
        });
    </script>

    <script>
        // Theme Toggle
        (function() {
            const themeToggle = document.getElementById('theme-toggle');
            const body = document.body;
            const icon = themeToggle.querySelector('i');
            
            // Load saved theme
            const savedTheme = localStorage.getItem('rbpt_theme');
            if (savedTheme === 'light') {
                body.classList.add('light-mode');
                icon.classList.remove('bi-sun-fill');
                icon.classList.add('bi-moon-fill');
            }
            
            themeToggle.addEventListener('click', function() {
                body.classList.toggle('light-mode');
                const isLight = body.classList.contains('light-mode');
                
                if (isLight) {
                    icon.classList.remove('bi-sun-fill');
                    icon.classList.add('bi-moon-fill');
                    localStorage.setItem('rbpt_theme', 'light');
                } else {
                    icon.classList.remove('bi-moon-fill');
                    icon.classList.add('bi-sun-fill');
                    localStorage.setItem('rbpt_theme', 'dark');
                }
            });
        })();
    </script>

    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
</body>

</html>
