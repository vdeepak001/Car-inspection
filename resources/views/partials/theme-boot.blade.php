<script>
    (() => {
        const savedTheme = localStorage.getItem('lotbook-theme');
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

        if ((savedTheme ?? (prefersDark ? 'dark' : 'light')) === 'dark') {
            document.documentElement.classList.add('dark');
        }
    })();
</script>
