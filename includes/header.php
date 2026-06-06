<?php
// Determine current page
$current_page = basename($_SERVER['PHP_SELF'], '.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title . ' | ' : ''; ?>Girls Boarding House</title>
    <link rel="stylesheet" href="<?php echo $base_path ?? ''; ?>static/style.css">
</head>
<body>
    <div class="app-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <div class="sidebar-brand">
                    <svg class="brand-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                    </svg>
                    <h1>GBH</h1>
                </div>
            </div>

            <nav class="sidebar-nav">
                <a href="<?php echo $base_path; ?>index.php" class="nav-item <?php echo ($current_page === 'index') ? 'active' : ''; ?>">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 12a9 9 0 1 0 18 0A9 9 0 0 0 3 12z"></path>
                        <path d="M12 6v6l4 2"></path>
                    </svg>
                    <span>Dashboard</span>
                </a>
                <a href="<?php echo $base_path; ?>pages/tenant/" class="nav-item <?php echo (strpos($current_page, 'tenant') !== false) ? 'active' : ''; ?>">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                    <span>Tenants</span>
                </a>
                <a href="<?php echo $base_path; ?>pages/room/" class="nav-item <?php echo (strpos($current_page, 'room') !== false) ? 'active' : ''; ?>">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2z"></path>
                        <rect x="7" y="7" width="5" height="5"></rect>
                        <rect x="12" y="7" width="5" height="5"></rect>
                        <rect x="7" y="12" width="5" height="5"></rect>
                        <rect x="12" y="12" width="5" height="5"></rect>
                    </svg>
                    <span>Rooms</span>
                </a>
                <a href="<?php echo $base_path; ?>pages/payment/" class="nav-item <?php echo (strpos($current_page, 'payment') !== false) ? 'active' : ''; ?>">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                        <path d="M1 10h22"></path>
                    </svg>
                    <span>Payments</span>
                </a>
                <a href="<?php echo $base_path; ?>pages/report/" class="nav-item <?php echo (strpos($current_page, 'report') !== false) ? 'active' : ''; ?>">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                    </svg>
                    <span>Reports</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <header class="top-bar">
                <div class="top-bar-content">
                    <h2 class="page-title"><?php echo isset($page_title) ? $page_title : 'Dashboard'; ?></h2>
    <div class="user-info">
        <span>👤 Admin</span>
    </div>
                </div>
            </header>

            <div class="content-wrapper">
