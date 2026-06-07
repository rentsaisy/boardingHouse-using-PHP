<?php
require_once __DIR__ . '/../../config.php';

$page_title = 'Rooms';
$base_path = '../../';

include __DIR__ . '/../../includes/header.php';

// HANDLE DELETE

if(isset($_GET['delete'])) {

    $id = intval($_GET['delete']);

    $conn->query("
        DELETE FROM m_room
        WHERE room_id = $id
    ");

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
    FROM m_room
");

$total_rows =
$total_result->fetch_assoc()['total'];

$total_pages =
ceil($total_rows / $limit);

// GET ROOM DATA

$result = $conn->query("
    SELECT *
    FROM m_room
    ORDER BY room_id ASC
    LIMIT $start, $limit
");
?>

<div class="page-header">
    <div class="header-content">
        <h1 class="breadcrumb"><strong>Rooms</strong></h1>
    </div>

    <a href="add.php" class="btn btn-primary">
        Add Room
    </a>
</div>

<div class="search-box">
    <input
    type="text"
    id="searchInput"
    placeholder="Search room...">
</div>

<div class="card">

    <div class="table-wrapper">

        <table class="data-table" id="roomTable">

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Room Number</th>
                    <th>Type</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>

                <?php while($row = $result->fetch_assoc()): ?>

                <tr>
                    <td><?php echo $row['room_id']; ?></td>

                    <td>
                        <?php echo htmlspecialchars($row['room_number']); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($row['type']); ?>
                    </td>

                    <td>
                        Rp <?php echo number_format($row['price'], 0, ',', '.'); ?>
                    </td>

                    <td>
                        <span class="status-badge <?php echo strtolower($row['status']); ?>">
                            <?php echo $row['status']; ?>
                        </span>
                    </td>

                    <td class="action-cell">

                        <a
                        href="edit.php?id=<?php echo $row['room_id']; ?>"
                        class="btn btn-sm btn-edit">
                            Edit
                        </a>

                        <a
                        href="index.php?delete=<?php echo $row['room_id']; ?>"
                        class="btn btn-sm btn-delete"
                        onclick="return confirm('Are you sure?')">
                            Delete
                        </a>

                    </td>

                </tr>

                <?php endwhile; ?>

            </tbody>

        </table>

    </div>

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

<script>

const searchInput =
document.getElementById("searchInput");

searchInput.addEventListener("keyup", function() {

    let filter =
    this.value.toLowerCase();

    let rows =
    document.querySelectorAll(
        "#roomTable tbody tr"
    );

    rows.forEach(row => {

        let text =
        row.innerText.toLowerCase();

        if(text.includes(filter)){
            row.style.display = "";
        }
        else{
            row.style.display = "none";
        }

    });

});

</script>

<?php include __DIR__ . '/../../includes/footer.php'; ?>
