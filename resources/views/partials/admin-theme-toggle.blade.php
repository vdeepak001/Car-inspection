<button type="button" class="btn btn-icon admin-theme-toggle" aria-pressed="false" aria-label="Switch to dark theme">
    <i class="ti ti-moon admin-theme-moon" aria-hidden="true"></i>
    <i class="ti ti-sun admin-theme-sun" aria-hidden="true"></i>
</button>
@once
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const syncAdminThemeToggle = () => {
                const isDark = document.documentElement.getAttribute('data-bs-theme') === 'dark';

                document.querySelectorAll('.admin-theme-toggle').forEach((button) => {
                    button.setAttribute('aria-pressed', isDark ? 'true' : 'false');
                    button.setAttribute('aria-label', isDark ? 'Switch to light theme' : 'Switch to dark theme');
                });
            };

            syncAdminThemeToggle();

            document.querySelectorAll('.admin-theme-toggle').forEach((button) => {
                button.addEventListener('click', () => {
                    const nextTheme = document.documentElement.getAttribute('data-bs-theme') === 'dark' ? 'light' : 'dark';

                    document.documentElement.setAttribute('data-bs-theme', nextTheme);
                    localStorage.setItem('lotbook-theme', nextTheme);
                    syncAdminThemeToggle();
                });
            });
        });
    </script>
@endonce
