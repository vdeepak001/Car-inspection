<button
    type="button"
    id="theme-toggle"
    class="grid size-10 place-items-center border border-ink/20 transition hover:border-ink dark:border-white/30 dark:hover:border-white"
    aria-pressed="false"
    aria-label="Switch to dark theme"
>
    <svg class="size-5 dark:hidden" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" d="M21 14.5A8.5 8.5 0 1 1 9.5 3a7 7 0 0 0 11.5 11.5Z" />
    </svg>
    <svg class="hidden size-5 dark:block" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
        <circle cx="12" cy="12" r="4" />
        <path stroke-linecap="round" d="M12 2.5v2.2M12 19.3v2.2M4.8 4.8l1.6 1.6M17.6 17.6l1.6 1.6M2.5 12h2.2M19.3 12h2.2M4.8 19.2l1.6-1.6M17.6 6.4l1.6-1.6" />
    </svg>
</button>
@once
    <script>
        const themeToggle = document.querySelector('#theme-toggle');

        const syncThemeToggle = () => {
            const isDark = document.documentElement.classList.contains('dark');

            themeToggle.setAttribute('aria-pressed', isDark ? 'true' : 'false');
            themeToggle.setAttribute('aria-label', isDark ? 'Switch to light theme' : 'Switch to dark theme');
        };

        syncThemeToggle();

        themeToggle.addEventListener('click', () => {
            const isDark = document.documentElement.classList.toggle('dark');

            localStorage.setItem('lotbook-theme', isDark ? 'dark' : 'light');
            syncThemeToggle();
        });
    </script>
@endonce
