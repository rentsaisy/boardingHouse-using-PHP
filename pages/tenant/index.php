<?php
require_once __DIR__ . '/../../config.php';
$page_title = 'Tenants';
$base_path = '../../';
include __DIR__ . '/../../includes/header.php';

// Handle delete
if(isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM m_tenant WHERE tenant_id = $id");
    header('Location: index.php');
    exit;
}

// Get all tenants
$result = $conn->query("SELECT * FROM m_tenant ORDER BY tenant_id DESC");
?>

<div class="page-header">
    <div class="header-content">
        <p class="breadcrumb">Home / <strong>Tenants</strong></p>
    </div>
    <a href="add.php" class="btn btn-primary">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="12" y1="5" x2="12" y2="19"></line>
            <line x1="5" y1="12" x2="19" y2="12"></line>
        </svg>
        Add Tenant
    </a>
</div>

<div class="card">
    <table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Emergency Contact</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['tenant_id']; ?></td>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['phone']); ?></td>
                <td><?php echo htmlspecialchars($row['address']); ?></td>
                <td><?php echo htmlspecialchars($row['emergency_contact']); ?></td>
                <td class="action-cell">
                    <a href="edit.php?id=<?php echo $row['tenant_id']; ?>" class="btn btn-sm btn-edit">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                        </svg>
                        Edit
                    </a>
                    <a href="index.php?delete=<?php echo $row['tenant_id']; ?>" class="btn btn-sm btn-delete" onclick="return confirm('Are you sure?')">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="3 6 5 6 21 6"></polyline>
                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                        </svg>
                        Delete
                    </a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include __DIR__ . '/../../includes/footer.php'; ?>
