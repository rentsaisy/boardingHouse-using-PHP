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

// PAGINATION

$limit = 5;

$page = isset($_GET['page'])
    ? (int)$_GET['page']
    : 1;

$start = ($page - 1) * $limit;


// TOTAL DATA

$total_result =
$conn->query("
    SELECT COUNT(*) as total
    FROM m_tenant
");

$total_rows =
$total_result->fetch_assoc()['total'];

$total_pages =
ceil($total_rows / $limit);

// GET ROOM DATA

$result = $conn->query("
    SELECT *
    FROM m_tenant
    ORDER BY tenant_id ASC
    LIMIT $start, $limit
");
?>


<div class="page-header">
    <div class="header-content">
        <h1 class="breadcrumb"><strong>Tenants</strong></h1>
    </div>

    <a href="add.php" class="btn btn-primary">
        Add Tenant
    </a>
</div>

<div class="search-box">
    <input
    type="text"
    id="searchInput"
    placeholder="Search room...">
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

    
    <!-- PAGINATION -->

    <div class="pagination">

        <!-- PREVIOUS -->

        <?php if($page > 1): ?>

            <a
            href="?page=<?php echo $page - 1; ?>"
            class="pagination-btn pagination-prev">

                ← Previous

            </a>

        <?php else: ?>

            <span class="pagination-btn disabled">
                ← Previous
            </span>

        <?php endif; ?>

        <!-- PAGE INFO -->

        <span class="pagination-info">

            Page <?php echo $page; ?>
            of <?php echo $total_pages; ?>

        </span>

        <!-- NEXT -->

        <?php if($page < $total_pages): ?>

            <a
            href="?page=<?php echo $page + 1; ?>"
            class="pagination-btn pagination-next">

                Next →

            </a>

        <?php else: ?>

            <span class="pagination-btn disabled">
                Next →
            </span>

        <?php endif; ?>

    </div>
</div>

<?php include __DIR__ . '/../../includes/footer.php'; ?>