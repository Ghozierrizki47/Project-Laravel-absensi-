<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ env('APP_NAME') }}</title>

    {{-- CSRF TOKEN --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">

    @stack('styles')
    
    {{-- Load saved theme immediately to prevent flash --}}
    <script>
        (function() {
            const savedTheme = localStorage.getItem('rbpt_theme');
            if (savedTheme === 'light') {
                document.documentElement.classList.add('light-mode-preload');
            }
        })();
    </script>
    <style>
        html.light-mode-preload body { visibility: hidden; }
    </style>
</head>

<body style="margin: 0; padding: 0; overflow-x: hidden;">
    <script>
        // Apply theme immediately on body load
        (function() {
            const savedTheme = localStorage.getItem('rbpt_theme');
            if (savedTheme === 'light') {
                document.body.classList.add('light-mode');
            }
            document.documentElement.classList.remove('light-mode-preload');
        })();
    </script>
    @yield('content')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>

    {{-- Global Theme Toggle Script --}}
    <script>
        // Theme Toggle (Dark/Light Mode) - Global
        (function(){
            const themeToggle = document.getElementById('themeToggle');
            const body = document.body;

            // Toggle theme on button click
            if(themeToggle) {
                themeToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    // Toggle theme
                    body.classList.toggle('light-mode');
                    
                    // Save preference
                    if (body.classList.contains('light-mode')) {
                        localStorage.setItem('rbpt_theme', 'light');
                    } else {
                        localStorage.setItem('rbpt_theme', 'dark');
                    }

                    // Click animation
                    this.style.transform = 'rotate(360deg) scale(0.9)';
                    setTimeout(() => {
                        this.style.transform = '';
                    }, 600);
                });
            }

            // Sidebar toggle + persist state
            const root = document.getElementById('dashboard-app');
            const toggle = document.getElementById('sidebarToggle');

            function setCollapsed(state){
                if(root) {
                    if(state) root.classList.add('sidebar-collapsed');
                    else root.classList.remove('sidebar-collapsed');
                }
                try { localStorage.setItem('rbpt_sidebar_collapsed', state ? '1' : '0'); } catch(e){}
            }

            // init from localStorage
            const saved = localStorage.getItem('rbpt_sidebar_collapsed');
            setCollapsed(saved === '1');

            if(toggle){
                toggle.addEventListener('click', function(e){
                    e.preventDefault();
                    setCollapsed(!root.classList.contains('sidebar-collapsed'));
                });
            }

            // Live clock
            function updateClock(){
                const now = new Date();
                const hh = String(now.getHours()).padStart(2,'0');
                const mm = String(now.getMinutes()).padStart(2,'0');
                const ss = String(now.getSeconds()).padStart(2,'0');
                const days = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
                const months = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
                const dateStr = days[now.getDay()] + ', ' + now.getDate() + ' ' + months[now.getMonth()] + ' ' + now.getFullYear();
                const elClock = document.getElementById('live-clock');
                const elDate = document.getElementById('live-date');
                if(elClock) elClock.textContent = hh + ':' + mm + ':' + ss;
                if(elDate) elDate.textContent = dateStr;
            }
            updateClock();
            setInterval(updateClock, 1000);
        })();
    </script>

    @stack('js')
</body>

</html>
