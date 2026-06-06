<?php
require_once __DIR__ . '/../../config.php';

if(!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$id = intval($_GET['id']);
$page_title = 'Edit Room';
$base_path = '../../';
include __DIR__ . '/../../includes/header.php';

// Get room data
$room = $conn->query("SELECT * FROM m_room WHERE room_id = $id")->fetch_assoc();

if(!$room) {
    echo "Room not found";
    exit;
}

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $room_number = $_POST['room_number'] ?? '';
    $type = $_POST['type'] ?? '';
    $price = $_POST['price'] ?? '';
    $status = $_POST['status'] ?? '';

    $stmt = $conn->prepare("UPDATE m_room SET room_number=?, type=?, price=?, status=? WHERE room_id=?");
    $stmt->bind_param("ssdsi", $room_number, $type, $price, $status, $id);
    
    if($stmt->execute()) {
        header('Location: index.php');
        exit;
    }
}
?>

<div class="page-header">
    <p class="breadcrumb">Home / <a href="index.php">Rooms</a> / <strong>Edit</strong></p>
</div>

<div class="card form-card">
    <form method="POST" class="form">
        <div class="form-group">
            <label for="room_number">Room Number *</label>
            <input type="text" id="room_number" name="room_number" value="<?php echo htmlspecialchars($room['room_number']); ?>" required>
        </div>

        <div class="form-group">
            <label for="type">Type *</label>
            <select id="type" name="type" required>
                <option value="">Select Room Type</option>
                <option value="Single" <?php echo $room['type'] === 'Single' ? 'selected' : ''; ?>>Single</option>
                <option value="Double" <?php echo $room['type'] === 'Double' ? 'selected' : ''; ?>>Double</option>
                <option value="Suite" <?php echo $room['type'] === 'Suite' ? 'selected' : ''; ?>>Suite</option>
            </select>
        </div>

        <div class="form-group">
            <label for="price">Price (Rp) *</label>
            <input type="number" id="price" name="price" value="<?php echo $room['price']; ?>" step="0.01" required>
        </div>

        <div class="form-group">
            <label for="status">Status *</label>
            <select id="status" name="status" required>
                <option value="">Select Status</option>
                <option value="Vacant" <?php echo $room['status'] === 'Vacant' ? 'selected' : ''; ?>>Vacant</option>
                <option value="Occupied" <?php echo $room['status'] === 'Occupied' ? 'selected' : ''; ?>>Occupied</option>
                <option value="Maintenance" <?php echo $room['status'] === 'Maintenance' ? 'selected' : ''; ?>>Maintenance</option>
            </select>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Update Room</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<?php include __DIR__ . '/../../includes/footer.php'; ?>
