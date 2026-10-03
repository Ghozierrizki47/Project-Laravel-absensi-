<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<style>
    @import url('https://fonts.googleapis.com/css2?family=Rajdhani:wght@400;600;700&display=swap');

    :root {
        --rb-navy: #0600EF;
        --rb-red: #DC0000;
        --rb-yellow: #FCD700;
        --rb-dark: #0c0e16;
        --rb-dark-2: #1a1d2e;
        --rb-dark-3: #252838;
        
        /* Theme colors - Dark Mode (default) */
        --bg-primary: #0c0e16;
        --bg-secondary: #1a1d2e;
        --bg-tertiary: #252838;
        --text-primary: #ffffff;
        --text-secondary: rgba(255, 255, 255, 0.8);
        --text-muted: rgba(255, 255, 255, 0.6);
        --card-bg: rgba(255, 255, 255, 0.05);
        --card-border: rgba(220, 0, 0, 0.2);
        --sidebar-bg-start: #0c0e16;
        --sidebar-bg-end: #252838;
        --input-bg: rgba(255, 255, 255, 0.05);
        --input-border: rgba(220, 0, 0, 0.3);
    }

    /* Light Mode */
    body.light-mode {
        --bg-primary: #f5f5f5;
        --bg-secondary: #ffffff;
        --bg-tertiary: #e8e8e8;
        --text-primary: #1a1d2e;
        --text-secondary: #252838;
        --text-muted: #6c757d;
        --card-bg: #ffffff;
        --card-border: rgba(220, 0, 0, 0.2);
        --sidebar-bg-start: #ffffff;
        --sidebar-bg-end: #f8f9fa;
        --input-bg: #ffffff;
        --input-border: #dee2e6;
    }

    body {
        font-family: 'Rajdhani', sans-serif;
        background: linear-gradient(135deg, var(--bg-primary) 0%, var(--bg-secondary) 100%);
        color: var(--text-primary);
        transition: background 0.3s ease, color 0.3s ease;
    }

    #dashboard-app {
        min-height: 100vh;
        background: transparent;
        display: flex;
        position: relative;
    }

    /* SIDEBAR RED BULL */
    .rb-sidebar {
        width: 280px;
        min-width: 280px;
        max-width: 280px;
        background: linear-gradient(180deg, var(--sidebar-bg-start) 0%, var(--sidebar-bg-end) 100%);
        border-right: 3px solid var(--rb-red);
        height: 100vh;
        position: sticky;
        top: 0;
        transition: all 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        overflow-y: auto;
        overflow-x: hidden;
        will-change: transform, opacity, filter;
        box-shadow: 
            4px 0 24px rgba(220, 0, 0, 0.3),
            0 0 60px rgba(6, 0, 239, 0.2) inset;
        position: relative;
        flex-shrink: 0;
    }

    /* Futuristic glow effect on sidebar */
    .rb-sidebar::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, 
            transparent, 
            var(--rb-yellow), 
            var(--rb-red), 
            var(--rb-navy),
            transparent
        );
        animation: scanLine 3s linear infinite;
        z-index: 10;
    }

    @keyframes scanLine {
        0% { transform: translateX(-100%); opacity: 0; }
        50% { opacity: 1; }
        100% { transform: translateX(100%); opacity: 0; }
    }

    /* Glowing border effect */
    .rb-sidebar::after {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 3px;
        height: 100%;
        background: linear-gradient(180deg,
            transparent,
            var(--rb-red),
            var(--rb-yellow),
            var(--rb-navy),
            var(--rb-red),
            transparent
        );
        animation: borderGlow 4s ease-in-out infinite;
        filter: blur(2px);
    }

    @keyframes borderGlow {
        0%, 100% { opacity: 0.5; }
        50% { opacity: 1; }
    }

    /* Custom Scrollbar untuk Sidebar */
    .rb-sidebar::-webkit-scrollbar {
        width: 6px;
    }

    .rb-sidebar::-webkit-scrollbar-track {
        background: rgba(0, 0, 0, 0.2);
    }

    .rb-sidebar::-webkit-scrollbar-thumb {
        background: var(--rb-red);
        border-radius: 3px;
    }

    .rb-sidebar::-webkit-scrollbar-thumb:hover {
        background: var(--rb-yellow);
    }

    .sidebar-brand {
        padding: 2rem 1.5rem;
        border-bottom: 2px solid rgba(220, 0, 0, 0.3);
        display: flex;
        align-items: center;
        gap: 1rem;
        background: rgba(220, 0, 0, 0.05);
    }

    .brand-icon {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, rgba(6, 0, 239, 0.2), rgba(220, 0, 0, 0.2));
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 8px;
        animation: pulse 2s ease-in-out infinite;
        border: 2px solid var(--rb-yellow);
        position: relative;
        overflow: hidden;
    }

    .brand-icon::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: linear-gradient(45deg, transparent, rgba(252, 215, 0, 0.1), transparent);
        animation: shine 3s infinite;
    }

    @keyframes shine {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .rb-logo {
        position: relative;
        z-index: 1;
        filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.3));
        animation: logoFloat 3s ease-in-out infinite;
    }

    @keyframes logoFloat {
        0%, 100% { transform: translateY(0) rotate(0deg); }
        50% { transform: translateY(-3px) rotate(5deg); }
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(252, 215, 0, 0.7); }
        50% { transform: scale(1.05); box-shadow: 0 0 20px 10px rgba(252, 215, 0, 0); }
    }

    .brand-text h5 {
        color: var(--rb-yellow);
        font-weight: 700;
        letter-spacing: 2px;
        margin: 0;
        font-size: 1.2rem;
    }

    .brand-text small {
        color: var(--text-muted);
        font-size: 0.75rem;
        letter-spacing: 1px;
    }

    .sidebar-nav {
        padding: 1.5rem 1rem;
        flex: 1;
    }

    .sidebar-nav .nav-link {
        color: var(--text-secondary);
        padding: 1rem 1.2rem;
        margin: 0.3rem 0;
        border-radius: 12px;
        display: flex;
        align-items: center;
        gap: 1rem;
        font-weight: 600;
        font-size: 1rem;
        position: relative;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        border: 2px solid transparent;
    }

    /* Futuristic scan effect on nav hover */
    .sidebar-nav .nav-link::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg,
            transparent,
            rgba(252, 215, 0, 0.2),
            transparent
        );
        transition: left 0.6s ease;
        z-index: 0;
    }

    .sidebar-nav .nav-link:hover::before {
        left: 100%;
    }

    /* Glowing effect */
    .sidebar-nav .nav-link::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(220, 0, 0, 0.3), transparent);
        transform: translate(-50%, -50%);
        transition: all 0.4s ease;
        z-index: 0;
    }

    .sidebar-nav .nav-link:hover::after {
        width: 200px;
        height: 200px;
    }

    .sidebar-nav .nav-link > * {
        position: relative;
        z-index: 1;
    }

    .sidebar-nav .nav-link i {
        font-size: 1.3rem;
        width: 24px;
    }

    .nav-indicator {
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 4px;
        height: 0;
        background: var(--rb-yellow);
        transition: height 0.3s ease;
        border-radius: 0 4px 4px 0;
    }

    .sidebar-nav .nav-link:hover {
        background: rgba(220, 0, 0, 0.15);
        color: white;
        transform: translateX(8px) scale(1.02);
        border-color: rgba(252, 215, 0, 0.5);
        box-shadow: 
            0 5px 20px rgba(220, 0, 0, 0.4),
            inset 0 0 20px rgba(252, 215, 0, 0.1);
    }

    .sidebar-nav .nav-link:hover .nav-indicator {
        height: 60%;
        box-shadow: 0 0 10px var(--rb-yellow);
    }

    .sidebar-nav .nav-link.active {
        background: linear-gradient(135deg, rgba(220, 0, 0, 0.3), rgba(6, 0, 239, 0.3));
        color: var(--rb-yellow);
        border-color: var(--rb-red);
        box-shadow: 
            0 8px 25px rgba(220, 0, 0, 0.5),
            inset 0 0 30px rgba(252, 215, 0, 0.2);
        animation: activePulse 2s ease-in-out infinite;
    }

    @keyframes activePulse {
        0%, 100% {
            box-shadow: 
                0 8px 25px rgba(220, 0, 0, 0.5),
                inset 0 0 30px rgba(252, 215, 0, 0.2);
        }
        50% {
            box-shadow: 
                0 8px 35px rgba(220, 0, 0, 0.7),
                inset 0 0 40px rgba(252, 215, 0, 0.4);
        }
    }

    .sidebar-nav .nav-link.active .nav-indicator {
        height: 80%;
        box-shadow: 0 0 15px var(--rb-yellow);
    }

    .sidebar-footer {
        padding: 1.5rem;
        border-top: 2px solid rgba(220, 0, 0, 0.3);
        background: rgba(220, 0, 0, 0.05);
    }

    .user-profile {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .user-avatar {
        width: 45px;
        height: 45px;
        background: linear-gradient(135deg, var(--rb-red), var(--rb-navy));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
    }

    .user-info {
        flex: 1;
    }

    .user-info strong {
        color: var(--text-primary);
        display: block;
        font-size: 0.95rem;
    }

    .user-info small {
        color: var(--text-muted);
        font-size: 0.75rem;
    }

    .btn-logout {
        background: rgba(220, 0, 0, 0.2);
        border: 2px solid var(--rb-red);
        color: white;
        padding: 0.7rem;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .btn-logout:hover {
        background: var(--rb-red);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(220, 0, 0, 0.4);
    }

    /* MAIN AREA */
    .main-area {
        flex: 1;
        background: linear-gradient(135deg, var(--bg-primary) 0%, var(--bg-secondary) 100%);
        position: relative;
        overflow-x: hidden;
        min-width: 0;
        width: 100%;
    }

    .racing-stripe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(to right, var(--rb-red), var(--rb-yellow), var(--rb-navy));
        z-index: 100;
    }

    .top-bar {
        background: var(--card-bg);
        backdrop-filter: blur(10px);
        padding: 1.5rem 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid var(--card-border);
        position: sticky;
        top: 0;
        z-index: 50;
    }

    .btn-toggle {
        background: linear-gradient(135deg, var(--rb-red), var(--rb-navy));
        border: 2px solid var(--rb-yellow);
        color: white;
        width: 50px;
        height: 50px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        transition: all 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        font-size: 1.5rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(220, 0, 0, 0.4);
        cursor: pointer;
    }

    /* Rotating glow effect */
    .btn-toggle::before {
        content: '';
        position: absolute;
        width: 150%;
        height: 150%;
        background: conic-gradient(
            from 0deg,
            transparent,
            var(--rb-yellow),
            transparent,
            var(--rb-red),
            transparent
        );
        animation: rotateGlow 3s linear infinite;
    }

    @keyframes rotateGlow {
        0% { transform: rotate(0deg); opacity: 0.5; }
        100% { transform: rotate(360deg); opacity: 0.5; }
    }

    .btn-toggle::after {
        content: '';
        position: absolute;
        inset: 2px;
        background: linear-gradient(135deg, var(--rb-red), var(--rb-navy));
        border-radius: 13px;
        z-index: 1;
    }

    .btn-toggle i {
        position: relative;
        z-index: 2;
        transition: transform 0.5s ease;
    }

    .btn-toggle:hover {
        transform: scale(1.15);
        box-shadow: 
            0 8px 30px rgba(220, 0, 0, 0.6),
            0 0 40px rgba(252, 215, 0, 0.4);
    }

    .btn-toggle:hover i {
        transform: rotate(180deg);
        color: var(--rb-yellow);
    }

    .btn-toggle:active {
        transform: scale(0.95);
    }

    .page-title {
        color: var(--text-primary);
        font-weight: 700;
        letter-spacing: 1px;
    }

    .top-bar-right {
        display: flex;
        align-items: center;
        gap: 2rem;
    }

    .live-time {
        text-align: right;
    }

    .live-time .clock {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--rb-yellow);
        letter-spacing: 2px;
    }

    .live-time .date {
        font-size: 0.85rem;
        color: var(--text-muted);
    }

    .dashboard-content {
        padding: 2rem;
    }

    /* STAT CARDS */
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
        color: rgba(255, 255, 255, 0.1);
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
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
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

    .alert-modern {
        background: rgba(40, 167, 69, 0.2);
        border: 2px solid #28a745;
        color: white;
        border-radius: 15px;
    }

    /* FORM STYLES */
    .form-label {
        color: rgba(255, 255, 255, 0.9);
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .form-control, .form-select {
        background: var(--input-bg);
        border: 2px solid var(--input-border);
        color: var(--text-primary);
        border-radius: 10px;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        background: var(--input-bg);
        border-color: var(--rb-red);
        color: var(--text-primary);
        box-shadow: 0 0 0 0.25rem rgba(220, 0, 0, 0.25);
    }

    .form-control::placeholder {
        color: rgba(255, 255, 255, 0.4);
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--rb-red), var(--rb-navy));
        border: 2px solid transparent;
        color: white;
        font-weight: 600;
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(220, 0, 0, 0.4);
        border-color: var(--rb-yellow);
    }

    .btn-secondary {
        background: rgba(255, 255, 255, 0.1);
        border: 2px solid rgba(255, 255, 255, 0.3);
        color: white;
        font-weight: 600;
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .btn-secondary:hover {
        background: rgba(255, 255, 255, 0.15);
        border-color: rgba(255, 255, 255, 0.5);
        color: white;
    }

    .btn-warning {
        background: linear-gradient(135deg, #ffc107, #ff9800);
        border: none;
        color: white;
        font-weight: 600;
    }

    .btn-warning:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(255, 193, 7, 0.4);
    }

    .btn-danger {
        background: linear-gradient(135deg, #dc3545, #c82333);
        border: none;
        color: white;
        font-weight: 600;
    }

    .btn-danger:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(220, 53, 69, 0.4);
    }

    .btn-info {
        background: linear-gradient(135deg, #17a2b8, #138496);
        border: none;
        color: white;
        font-weight: 600;
    }

    .btn-info:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(23, 162, 184, 0.4);
    }

    .text-muted {
        color: rgba(255, 255, 255, 0.5) !important;
    }

    /* COLLAPSED STATE - FUTURISTIC ANIMATION */
    #dashboard-app.sidebar-collapsed .rb-sidebar {
        transform: translateX(-100%) rotateY(-15deg);
        opacity: 0;
        filter: blur(5px);
        box-shadow: 
            -20px 0 40px rgba(220, 0, 0, 0.5),
            0 0 80px rgba(6, 0, 239, 0.3);
        width: 0;
        min-width: 0;
        padding: 0;
        border: none;
    }

    /* Main area expands when sidebar is collapsed */
    #dashboard-app.sidebar-collapsed .main-area {
        width: 100%;
    }

    /* Add futuristic backdrop when sidebar is opening */
    #dashboard-app:not(.sidebar-collapsed)::before {
        content: '';
        position: fixed;
        top: 0;
        left: 0;
        width: 300px;
        height: 100vh;
        background: linear-gradient(90deg, 
            rgba(6, 0, 239, 0.1), 
            rgba(220, 0, 0, 0.05),
            transparent
        );
        pointer-events: none;
        z-index: 0;
        animation: backdropFade 0.6s ease-out;
    }

    @keyframes backdropFade {
        0% { opacity: 0; transform: translateX(-50px); }
        100% { opacity: 1; transform: translateX(0); }
    }

    /* THEME TOGGLE BUTTON */
    .theme-toggle-btn {
        background: linear-gradient(135deg, rgba(6, 0, 239, 0.15), rgba(220, 0, 0, 0.15));
        border: 2px solid var(--rb-navy);
        color: var(--rb-yellow);
        width: 50px;
        height: 50px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        font-size: 1.4rem;
        cursor: pointer;
        position: relative;
        overflow: hidden;
        z-index: 100;
        margin-right: 1rem;
        box-shadow: 0 4px 15px rgba(6, 0, 239, 0.2);
    }

    .theme-toggle-btn::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: linear-gradient(45deg, transparent, rgba(252, 215, 0, 0.2), transparent);
        transform: rotate(0deg);
        transition: transform 0.6s ease;
    }

    .theme-toggle-btn:hover::before {
        transform: rotate(180deg);
    }

    .theme-toggle-btn:hover {
        border-color: var(--rb-yellow);
        transform: translateY(-3px) scale(1.05);
        box-shadow: 0 8px 25px rgba(252, 215, 0, 0.4);
        background: linear-gradient(135deg, rgba(220, 0, 0, 0.25), rgba(6, 0, 239, 0.25));
    }

    .theme-toggle-btn:active {
        transform: translateY(-1px) scale(0.98);
    }

    .theme-toggle-btn i {
        transition: all 0.4s ease;
        position: relative;
        z-index: 2;
        filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.3));
    }

    /* Icon animations */
    body.light-mode .theme-toggle-btn .bi-moon-stars {
        display: none;
    }

    body:not(.light-mode) .theme-toggle-btn .bi-sun {
        display: none;
    }

    body.light-mode .theme-toggle-btn .bi-sun {
        animation: sunSpin 0.5s ease;
    }

    body:not(.light-mode) .theme-toggle-btn .bi-moon-stars {
        animation: moonFloat 0.5s ease;
    }

    @keyframes sunSpin {
        0% { transform: rotate(0deg) scale(0); opacity: 0; }
        50% { transform: rotate(180deg) scale(1.2); }
        100% { transform: rotate(360deg) scale(1); opacity: 1; }
    }

    @keyframes moonFloat {
        0% { transform: translateY(10px) scale(0); opacity: 0; }
        50% { transform: translateY(-5px) scale(1.1); }
        100% { transform: translateY(0) scale(1); opacity: 1; }
    }

    /* Light mode styling */
    body.light-mode .theme-toggle-btn {
        background: linear-gradient(135deg, #FCD700, #FFD700);
        border-color: #FFC700;
        color: #0c0e16;
        box-shadow: 0 4px 15px rgba(252, 215, 0, 0.4);
    }

    body.light-mode .theme-toggle-btn:hover {
        background: linear-gradient(135deg, #FFD700, #FCD700);
        box-shadow: 0 8px 25px rgba(252, 215, 0, 0.6);
        border-color: #DC0000;
    }

    body.light-mode .sidebar-nav .nav-link:hover {
        color: var(--text-primary);
    }

    body.light-mode .nav-indicator {
        background: var(--rb-red);
    }

    /* Additional Light Mode Styles */
    body.light-mode .rb-sidebar {
        box-shadow: 4px 0 24px rgba(0, 0, 0, 0.1);
    }

    body.light-mode .rb-card {
        background: var(--card-bg);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    }

    body.light-mode .stat-card {
        background: var(--card-bg);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    }

    body.light-mode .stat-label {
        color: var(--text-muted);
    }

    body.light-mode .table-rb {
        background: var(--card-bg);
    }

    body.light-mode .table-rb th {
        background: rgba(220, 0, 0, 0.1);
        color: var(--text-primary);
    }

    body.light-mode .table-rb td {
        color: var(--text-primary);
        border-color: var(--card-border);
    }

    body.light-mode .user-info strong,
    body.light-mode .brand-text h5 {
        color: var(--text-primary);
    }

    body.light-mode .status-info strong,
    body.light-mode .calendar-events h6,
    body.light-mode .today-badge span {
        color: var(--text-primary);
    }

    body.light-mode .status-info small,
    body.light-mode .count-label {
        color: var(--text-muted);
    }

    body.light-mode .quick-action-btn {
        background: rgba(220, 0, 0, 0.05);
        color: var(--text-primary);
    }

    body.light-mode .quick-action-btn:hover {
        background: rgba(220, 0, 0, 0.1);
    }

    body.light-mode .calendar-day {
        color: var(--text-primary);
    }

    body.light-mode .calendar-day.other-month {
        color: var(--text-muted);
    }

    body.light-mode .main-area {
        background: linear-gradient(135deg, var(--bg-primary) 0%, var(--bg-secondary) 100%);
    }

    body.light-mode .top-bar {
        background: var(--card-bg);
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    body.light-mode .page-title {
        color: var(--text-primary);
    }

    /* RESPONSIVE */
    @media (max-width: 768px) {
        .rb-sidebar {
            position: fixed;
            z-index: 1050;
            left: 0;
            top: 0;
            box-shadow: 
                8px 0 40px rgba(220, 0, 0, 0.5),
                0 0 80px rgba(6, 0, 239, 0.3);
        }

        /* Mobile: sidebar hidden by default */
        #dashboard-app.sidebar-collapsed .rb-sidebar {
            transform: translateX(-100%) scale(0.95);
            opacity: 0;
        }

        /* Mobile: Add backdrop when sidebar is open */
        #dashboard-app:not(.sidebar-collapsed)::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(5px);
            z-index: 1040;
            animation: backdropFadeIn 0.3s ease;
        }

        @keyframes backdropFadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
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

        .btn-toggle {
            width: 45px;
            height: 45px;
        }
    }

    /* Add pulse animation to brand icon */
    @keyframes pulse {
        0%, 100% {
            transform: scale(1);
            box-shadow: 0 0 0 0 rgba(252, 215, 0, 0.7);
        }
        50% {
            transform: scale(1.05);
            box-shadow: 0 0 20px 10px rgba(252, 215, 0, 0);
        }
    }

    /* Energy waves effect when sidebar opens */
    @keyframes energyWave {
        0% {
            transform: scale(0.8) translateX(-50px);
            opacity: 0;
        }
        50% {
            opacity: 0.5;
        }
        100% {
            transform: scale(1.2) translateX(0);
            opacity: 0;
        }
    }
</style>
