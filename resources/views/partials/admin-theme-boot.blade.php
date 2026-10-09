<script>
    (() => {
        const savedTheme = localStorage.getItem('lotbook-theme');
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        const theme = savedTheme ?? (prefersDark ? 'dark' : 'light');

        document.documentElement.setAttribute('data-bs-theme', theme);
    })();
</script>
<style>
    .admin-theme-sun { display: none; }
    [data-bs-theme="dark"] .admin-theme-moon { display: none; }
    [data-bs-theme="dark"] .admin-theme-sun { display: inline-block; }
</style>
