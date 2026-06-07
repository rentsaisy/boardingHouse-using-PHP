<?php
require_once __DIR__ . '/../../config.php';

$page_title = 'Rooms';
$base_path = '../../';

include __DIR__ . '/../../includes/header.php';

// Handle delete
if(isset($_GET['delete'])) {

    $id = intval($_GET['delete']);

    $conn->query("
        DELETE FROM m_room
        WHERE room_id = $id
    ");

    header('Location: index.php');
    exit;
}

// Handle add
if(
    $_SERVER['REQUEST_METHOD'] == 'POST'
    &&
    !isset($_POST['update_room'])
){

    $room_number =
    $_POST['room_number'];

    $type =
    $_POST['type'];

    $price =
    $_POST['price'];

    $status =
    $_POST['status'];

    $stmt = $conn->prepare("
        INSERT INTO m_room
        (
            room_number,
            type,
            price,
            status
        )
        VALUES (?, ?, ?, ?)
    ");

    $stmt->bind_param(
        "ssis",
        $room_number,
        $type,
        $price,
        $status
    );

    $stmt->execute();

    header("Location: index.php");
    exit;
}

// Handle edit
if(isset($_POST['update_room'])){

    $id =
    $_POST['room_id'];

    $room_number =
    $_POST['room_number'];

    $type =
    $_POST['type'];

    $price =
    $_POST['price'];

    $status =
    $_POST['status'];

    $stmt = $conn->prepare("
        UPDATE m_room
        SET
            room_number=?,
            type=?,
            price=?,
            status=?
        WHERE room_id=?
    ");

    $stmt->bind_param(
        "ssisi",
        $room_number,
        $type,
        $price,
        $status,
        $id
    );

    $stmt->execute();

    header("Location: index.php");
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

    <button
    class="btn btn-primary"
    onclick="openModal()">

        Add Room

    </button>

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

                        <button
                        class="btn btn-sm btn-edit"
                        onclick="openEditModal(
                            '<?php echo $row['room_id']; ?>',
                            '<?php echo htmlspecialchars($row['room_number']); ?>',
                            '<?php echo htmlspecialchars($row['type']); ?>',
                            '<?php echo htmlspecialchars($row['price']); ?>',
                            '<?php echo htmlspecialchars($row['status']); ?>'
                        )">

                            Edit

                        </button>

                        <button
                        class="btn btn-sm btn-delete"
                        onclick="openDeleteModal(
                            '<?php echo $row['room_id']; ?>'
                        )">

                            Delete

                        </button>

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

<!-- ADD ROOM MODAL -->

<div class="modal" id="roomModal">

    <div class="modal-content">

        <div class="modal-header">

            <h2>Add Room</h2>

            <span
            class="close-btn"
            onclick="closeModal()">

                &times;

            </span>

        </div>

        <form method="POST">

            <input
            type="text"
            name="room_number"
            placeholder="Room Number"
            required>

            <select
            name="type"
            required>

                <option value="">
                    Select Room Type
                </option>

                <option value="Single">
                    Single
                </option>

                <option value="Double">
                    Double
                </option>

            </select>

            <input
            type="number"
            name="price"
            placeholder="Price"
            required>

            <select
            name="status"
            required>

                <option value="">
                    Select Status
                </option>

                <option value="Occupied">
                    Occupied
                </option>

                <option value="Available">
                    Available
                </option>

            </select>

            <button
            type="submit"
            class="btn btn-primary">

                Save Room

            </button>

        </form>

    </div>

</div>

<script>

function openModal(){

    document
    .getElementById("roomModal")
    .style.display = "flex";

}

function closeModal(){

    document
    .getElementById("roomModal")
    .style.display = "none";

}

window.onclick = function(event){

    let modal =
    document.getElementById("roomModal");

    if(event.target == modal){

        modal.style.display = "none";

    }

}

</script>

<!-- EDIT ROOM MODAL -->

<div class="modal" id="editModal">

    <div class="modal-content">

        <div class="modal-header">

            <h2>Edit Room</h2>

            <span
            class="close-btn"
            onclick="closeEditModal()">

                &times;

            </span>

        </div>

        <form method="POST">

            <input
            type="hidden"
            name="room_id"
            id="editRoomId">

            <input
            type="text"
            name="room_number"
            id="editRoomNumber"
            placeholder="Room Number">

            <select
            name="type"
            id="editType">

                <option value="">
                    Select Room Type
                </option>

                <option value="Single">
                    Single
                </option>

                <option value="Double">
                    Double
                </option>

            </select>

            <input
            type="number"
            name="price"
            id="editPrice"
            placeholder="Price">

            <select
            name="status"
            id="editStatus">

                <option value="Occupied">
                    Occupied
                </option>

                <option value="Available">
                    Available
                </option>

            </select>

            <button
            type="submit"
            name="update_room"
            class="btn btn-primary">

                Save Changes

            </button>

        </form>

    </div>

</div>

<script>

function openEditModal(
    id,
    room_number,
    type,
    price,
    status
){

    document
    .getElementById("editModal")
    .style.display = "flex";

    document
    .getElementById("editRoomId")
    .value = id;

    document
    .getElementById("editRoomNumber")
    .value = room_number;

    document
    .getElementById("editType")
    .value = type;

    document
    .getElementById("editPrice")
    .value = price;

    document
    .getElementById("editStatus")
    .value = status;

}

function closeEditModal(){

    document
    .getElementById("editModal")
    .style.display = "none";

}

</script>

<!-- DELETE MODAL -->

<div class="modal" id="deleteModal">

    <div class="modal-content delete-modal">

        <h2>Delete Room?</h2>

        <p>
            This action cannot be undone.
        </p>

        <div class="delete-actions">

            <button
            class="btn btn-cancel"
            onclick="closeDeleteModal()">

                Cancel

            </button>

            <a
            href="#"
            id="deleteLink"
            class="btn btn-delete-confirm">

                Delete

            </a>

        </div>

    </div>

</div>

<script>

function openDeleteModal(id){

    document
    .getElementById("deleteModal")
    .style.display = "flex";

    document
    .getElementById("deleteLink")
    .href =
    "index.php?delete=" + id;

}

function closeDeleteModal(){

    document
    .getElementById("deleteModal")
    .style.display = "none";

}

</script>

<!-- SEARCHING -->
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
