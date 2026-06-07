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
                        Edit
                    </a>
                    <a href="index.php?delete=<?php echo $row['tenant_id']; ?>" class="btn btn-sm btn-delete" onclick="return confirm('Are you sure?')">
                        Delete
                    </a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include __DIR__ . '/../../includes/footer.php'; ?>
