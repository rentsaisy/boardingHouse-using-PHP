<?php
require_once __DIR__ . '/../config.php';
$page_title = 'Dashboard';
$base_path = '../';
include __DIR__ . '/../includes/header.php';

// Get statistics
$tenants_result = $conn->query("SELECT COUNT(*) as total FROM m_tenant");
$tenants_count = $tenants_result->fetch_assoc()['total'];

$rooms_result = $conn->query("SELECT COUNT(*) as total FROM m_room");
$rooms_count = $rooms_result->fetch_assoc()['total'];

$occupied_result = $conn->query("SELECT COUNT(*) as total FROM m_room WHERE status='Occupied'");
$occupied_count = $occupied_result->fetch_assoc()['total'];

$available_result = $conn->query("SELECT COUNT(*) as total FROM m_room WHERE status='Available'");
$available_count = $available_result->fetch_assoc()['total'];

// Get recent tenants
$recent_tenants = $conn->query("SELECT * FROM m_tenant LIMIT 5");

// Get recent rooms
$recent_rooms = $conn->query("SELECT * FROM m_room LIMIT 5");
?>

<div class="dashboard">
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon tenants-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path d="M17 21v-2a4 4 0 0 0-4-4H7a4 4 0 0 0-4 4v2"/>
                <circle cx="10" cy="7" r="4"/>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
            </svg>
            </div>
            <div class="stat-content">
                <h3>Total Tenants</h3>
                <p class="stat-number"><?php echo $tenants_count; ?></p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon rooms-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path d="M3 10.5L12 3l9 7.5"/>
                <path d="M5 9.5V21h14V9.5"/>
                <path d="M9 21v-6h6v6"/>
            </svg>
            </div>
            <div class="stat-content">
                <h3>Total Rooms</h3>
                <p class="stat-number"><?php echo $rooms_count; ?></p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon occupied-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <circle cx="12" cy="12" r="10"/>
                <path d="M9 12l2 2 4-4"/>
            </svg>
            </div>
            <div class="stat-content">
                <h3>Occupied</h3>
                <p class="stat-number"><?php echo $occupied_count; ?></p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon available-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path d="M12 2v20"/>
                <path d="M2 12h20"/>
                <circle cx="12" cy="12" r="3"/>
            </svg>
            </div>
            <div class="stat-content">
                <h3>Available</h3>
                <p class="stat-number"><?php echo $available_count; ?></p>
            </div>
        </div>
    </div>

    <div class="dashboard-grid">

        <div class="card welcome-card">

            <h1>
                Welcome to Girls' Boarding House Information System
            </h1>

            <img
            src="<?php echo $base_path; ?>public/rosa(owner).gif"
            class="welcome-img">

            <p>
                In here you can help us to manage our boarding house.
                Please check other menu in sidebar
            </p>

        </div>

    </div>

</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
