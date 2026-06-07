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
    <link rel="stylesheet" href="<?php echo $base_path; ?>style.css">
</head>
<body>

<div class="layout">

    <!-- SIDEBAR -->

    <div class="sidebar">

        <div class="sidebar-header">

            <img
            src="<?php echo $base_path; ?>public/lily.png"
            class="sidebar-logo">

            <h1>
                Girls' Boarding House
            </h1>

        </div>

        <div class="sidebar-menu">
            
            <a href="<?php echo $base_path; ?>pages/dashboard.php" class="menu-item">
                <img
                src="<?php echo $base_path; ?>public/dashboard.png"
                class="sidebar-icon">
                <span>Dashboard</span>
            </a>

            <a href="<?php echo $base_path; ?>pages/tenant/" class="menu-item">
                <img
                src="<?php echo $base_path; ?>public/tenant.png"
                class="sidebar-icon">
                <span>Tenant</span>
            </a>

            <a href="<?php echo $base_path; ?>pages/room/" class="menu-item">
                <img
                src="<?php echo $base_path; ?>public/room.png"
                class="sidebar-icon">
                <span>Room</span>
            </a>
        </div>

    </div>

    <!-- MAIN -->

    <div class="main-content">

        <!-- NAVBAR -->

        <div class="navbar">
            
            <div class="navbar-left">

            </div>

            <div class="navbar-right">

                <img
                src="<?php echo $base_path; ?>public/rosa(owner).png"
                class="profile">

            </div>

        </div>

        <div class="page-content">