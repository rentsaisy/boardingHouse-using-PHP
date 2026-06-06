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

$vacant_result = $conn->query("SELECT COUNT(*) as total FROM m_room WHERE status='Vacant'");
$vacant_count = $vacant_result->fetch_assoc()['total'];

// Get recent tenants
$recent_tenants = $conn->query("SELECT * FROM m_tenant LIMIT 5");

// Get recent rooms
$recent_rooms = $conn->query("SELECT * FROM m_room LIMIT 5");
?>

<div class="dashboard">
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon tenants-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
            </div>
            <div class="stat-content">
                <h3>Total Tenants</h3>
                <p class="stat-number"><?php echo $tenants_count; ?></p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon rooms-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                    <path d="M16 7v-2a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"></path>
                </svg>
            </div>
            <div class="stat-content">
                <h3>Total Rooms</h3>
                <p class="stat-number"><?php echo $rooms_count; ?></p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon occupied-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 6 12 12 16 14"></polyline>
                </svg>
            </div>
            <div class="stat-content">
                <h3>Occupied</h3>
                <p class="stat-number"><?php echo $occupied_count; ?></p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon vacant-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"></path>
                    <path d="M21 15v6h-6"></path>
                    <path d="M21 3v6h-6"></path>
                    <path d="M3 21a9 9 0 0 0 9 9 9.75 9.75 0 0 0 6.74-2.74L3 3"></path>
                </svg>
            </div>
            <div class="stat-content">
                <h3>Vacant</h3>
                <p class="stat-number"><?php echo $vacant_count; ?></p>
            </div>
        </div>
    </div>

    <div class="dashboard-grid">
        <div class="card">
            <div class="card-header">
                <h3>Recent Tenants</h3>
                <a href="pages/tenant/" class="link-small">View All</a>
            </div>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Address</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $recent_tenants->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['phone']); ?></td>
                        <td><?php echo htmlspecialchars($row['address']); ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <div class="card">
            <div class="card-header">
                <h3>Recent Rooms</h3>
                <a href="pages/room/" class="link-small">View All</a>
            </div>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Room Number</th>
                        <th>Type</th>
                        <th>Price</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $recent_rooms->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['room_number']); ?></td>
                        <td><?php echo htmlspecialchars($row['type']); ?></td>
                        <td>Rp <?php echo number_format($row['price'], 0, ',', '.'); ?></td>
                        <td>
                            <span class="status-badge <?php echo strtolower($row['status']); ?>">
                                <?php echo $row['status']; ?>
                            </span>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
