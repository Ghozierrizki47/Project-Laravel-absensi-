<script>
    // Sidebar toggle + persist state
    (function(){
        const root = document.getElementById('dashboard-app');
        const toggle = document.getElementById('sidebarToggle');

        function setCollapsed(state){
            if(state) root.classList.add('sidebar-collapsed');
            else root.classList.remove('sidebar-collapsed');
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
    })();

    // Live clock
    (function(){
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

    // Theme Toggle (Dark/Light Mode) - Enhanced
    (function(){
        const themeToggle = document.getElementById('themeToggle');
        const body = document.body;

        // Load saved theme from localStorage
        const savedTheme = localStorage.getItem('rbpt_theme');
        if (savedTheme === 'light') {
            body.classList.add('light-mode');
        }

        // Toggle theme on button click with enhanced animation
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

                // Enhanced click animation
                this.style.transform = 'rotate(360deg) scale(0.9)';
                
                // Create ripple effect
                const ripple = document.createElement('span');
                ripple.style.position = 'absolute';
                ripple.style.borderRadius = '50%';
                ripple.style.background = 'rgba(252, 215, 0, 0.6)';
                ripple.style.width = '10px';
                ripple.style.height = '10px';
                ripple.style.left = '50%';
                ripple.style.top = '50%';
                ripple.style.transform = 'translate(-50%, -50%) scale(0)';
                ripple.style.animation = 'ripple 0.6s ease-out';
                ripple.style.pointerEvents = 'none';
                this.appendChild(ripple);
                
                setTimeout(() => {
                    this.style.transform = '';
                    ripple.remove();
                }, 600);
            });

            // Add hover sound effect (optional visual feedback)
            themeToggle.addEventListener('mouseenter', function() {
                this.style.transition = 'all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55)';
            });
        }

        // Add ripple animation CSS
        const style = document.createElement('style');
        style.textContent = `
            @keyframes ripple {
                0% { transform: translate(-50%, -50%) scale(0); opacity: 1; }
                100% { transform: translate(-50%, -50%) scale(4); opacity: 0; }
            }
        `;
        document.head.appendChild(style);
    })();
</script>
