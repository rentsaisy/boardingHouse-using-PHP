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

// Handle Add
if($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['update_tenant'])){

    $name =
    $_POST['name'];

    $phone =
    $_POST['phone'];

    $address =
    $_POST['address'];

    $emergency_contact =
    $_POST['emergency_contact'];

    $stmt = $conn->prepare("
        INSERT INTO m_tenant
        (
            name,
            phone,
            address,
            emergency_contact
        )
        VALUES (?, ?, ?, ?)
    ");

    $stmt->bind_param(
        "ssss",
        $name,
        $phone,
        $address,
        $emergency_contact
    );

    $stmt->execute();

    header("Location: index.php");
    exit;
}

// Handle Edit
if(isset($_POST['update_tenant'])){

    $id = $_POST['tenant_id'];

    $name = $_POST['name'];

    $phone = $_POST['phone'];

    $address = $_POST['address'];

    $emergency = $_POST['emergency_contact'];

    $stmt = $conn->prepare("
        UPDATE m_tenant
        SET
            name=?,
            phone=?,
            address=?,
            emergency_contact=?
        WHERE tenant_id=?
    ");

    $stmt->bind_param(
        "ssssi",
        $name,
        $phone,
        $address,
        $emergency,
        $id
    );

    $stmt->execute();

    header("Location:index.php");
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

    <button
    class="btn btn-primary"
    onclick="openModal()">

        Add Tenant

    </button>

</div>

<div class="search-box">
    <input
    type="text"
    id="searchInput"
    placeholder="Search room...">
</div>

<div class="card">
    <table class="data-table" id="tenantTable">
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
                    <button
                    class="btn btn-sm btn-edit"
                    onclick="openEditModal(
                        '<?php echo $row['tenant_id']; ?>',
                        '<?php echo htmlspecialchars($row['name']); ?>',
                        '<?php echo htmlspecialchars($row['phone']); ?>',
                        '<?php echo htmlspecialchars($row['address']); ?>',
                        '<?php echo htmlspecialchars($row['emergency_contact']); ?>'
                    )">

                        Edit

                    </button>

                    <button
                    class="btn btn-sm btn-delete"
                    onclick="openDeleteModal(
                        '<?php echo $row['tenant_id']; ?>'
                    )">

                        Delete

                    </button>

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
<!-- ADD MODAL -->
<div class="modal" id="tenantModal">

    <div class="modal-content">

        <div class="modal-header">

            <h2>Add Tenant</h2>

            <span
            class="close-btn"
            onclick="closeModal()">

                &times;

            </span>

        </div>

        <form method="POST">

            <input
            type="text"
            name="name"
            placeholder="Name"
            required>

            <input
            type="text"
            name="phone"
            placeholder="Phone"
            required>

            <input
            type="text"
            name="address"
            placeholder="Address"
            required>

            <input
            type="text"
            name="emergency_contact"
            placeholder="Emergency Contact"
            required>

            <button
            type="submit"
            class="btn btn-primary">

                Save Tenant

            </button>

        </form>

    </div>

</div>

<script>

function openModal(){

    document
    .getElementById("tenantModal")
    .style.display = "flex";

}

function closeModal(){

    document
    .getElementById("tenantModal")
    .style.display = "none";

}

/* CLOSE WHEN CLICK OUTSIDE */

window.onclick = function(event){

    let modal =
    document.getElementById("tenantModal");

    if(event.target == modal){

        modal.style.display = "none";

    }

}

</script>

<!-- EDIT MODAL -->
<div class="modal" id="editModal">

    <div class="modal-content">

        <div class="modal-header">

            <h2>Edit Tenant</h2>

            <span
            class="close-btn"
            onclick="closeEditModal()">

                &times;

            </span>

        </div>

        <form method="POST">

            <input
            type="hidden"
            name="tenant_id"
            id="editTenantId">

            <input
            type="text"
            name="name"
            id="editName"
            placeholder="Name">

            <input
            type="text"
            name="phone"
            id="editPhone"
            placeholder="Phone">

            <input
            type="text"
            name="address"
            id="editAddress"
            placeholder="Address">

            <input
            type="text"
            name="emergency_contact"
            id="editEmergency"
            placeholder="Emergency Contact">

            <button
            type="submit"
            name="update_tenant"
            class="btn btn-primary">

                Save Changes

            </button>

        </form>

    </div>

</div>

<script>

function openEditModal(
    id,
    name,
    phone,
    address,
    emergency
){

    document
    .getElementById("editModal")
    .style.display = "flex";

    document
    .getElementById("editTenantId")
    .value = id;

    document
    .getElementById("editName")
    .value = name;

    document
    .getElementById("editPhone")
    .value = phone;

    document
    .getElementById("editAddress")
    .value = address;

    document
    .getElementById("editEmergency")
    .value = emergency;

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

        <h2>Delete Tenant?</h2>

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
        "#tenantTable tbody tr"
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