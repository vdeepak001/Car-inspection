<style>
    :root {
        --tblr-font-sans-serif: "Inter", -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        --tblr-primary: #e10600;
        --tblr-primary-rgb: 225, 6, 0;
        --tblr-link-color: #e10600;
        --tblr-link-hover-color: #b00500;
    }

    html:not([data-bs-theme="dark"]) {
        --tblr-body-bg: #f3f4f6;
        --tblr-bg-surface: #ffffff;
        --tblr-card-bg: #ffffff;
        --tblr-border-color: #e5e7eb;
    }

    html[data-bs-theme="dark"] {
        --tblr-body-bg: #121214;
        --tblr-bg-surface: #1c1c21;
        --tblr-bg-surface-secondary: #24242a;
        --tblr-card-bg: #1c1c21;
        --tblr-border-color: rgba(255, 255, 255, 0.08);
        --tblr-body-color: #f4f4f5;
        --tblr-secondary: #a1a1aa;
        --tblr-link-color: #ff5a52;
        --tblr-link-hover-color: #ff8a84;
    }

    .navbar-vertical {
        background-color: #c10500 !important;
        border-inline-end: 0;
        --tblr-bg-surface: #c10500;
        --tblr-body-bg: #c10500;
        --tblr-navbar-bg: #c10500;
    }

    html[data-bs-theme="dark"] .navbar-vertical {
        background-color: #8f1210 !important;
        --tblr-bg-surface: #8f1210;
        --tblr-body-bg: #8f1210;
        --tblr-navbar-bg: #8f1210;
    }

    .navbar-vertical .nav-link {
        color: rgba(255, 255, 255, 0.88);
    }

    .navbar-vertical .nav-link:hover {
        color: #fff;
        background: rgba(255, 255, 255, 0.12);
    }

    .navbar-vertical .nav-link.active,
    .navbar-vertical .nav-link.active:hover {
        background: #fff;
        color: #c10500;
    }

    html:not([data-bs-theme="dark"]) .page > header.navbar {
        background: #fff;
        border-bottom: 1px solid #e5e7eb;
    }

    html[data-bs-theme="dark"] .page > header.navbar {
        background: #18181c;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
    }
</style>
