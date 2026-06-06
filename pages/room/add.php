<?php
require_once __DIR__ . '/../../config.php';
$page_title = 'Add Room';
$base_path = '../../';
include __DIR__ . '/../../includes/header.php';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $room_number = $_POST['room_number'] ?? '';
    $type = $_POST['type'] ?? '';
    $price = $_POST['price'] ?? '';
    $status = $_POST['status'] ?? '';

    $stmt = $conn->prepare("INSERT INTO m_room (room_number, type, price, status) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssds", $room_number, $type, $price, $status);
    
    if($stmt->execute()) {
        header('Location: index.php');
        exit;
    }
}
?>

<div class="page-header">
    <p class="breadcrumb">Home / <a href="index.php">Rooms</a> / <strong>Add New</strong></p>
</div>

<div class="card form-card">
    <form method="POST" class="form">
        <div class="form-group">
            <label for="room_number">Room Number *</label>
            <input type="text" id="room_number" name="room_number" required>
        </div>

        <div class="form-group">
            <label for="type">Type *</label>
            <select id="type" name="type" required>
                <option value="">Select Room Type</option>
                <option value="Single">Single</option>
                <option value="Double">Double</option>
                <option value="Suite">Suite</option>
            </select>
        </div>

        <div class="form-group">
            <label for="price">Price (Rp) *</label>
            <input type="number" id="price" name="price" step="0.01" required>
        </div>

        <div class="form-group">
            <label for="status">Status *</label>
            <select id="status" name="status" required>
                <option value="">Select Status</option>
                <option value="Vacant">Vacant</option>
                <option value="Occupied">Occupied</option>
                <option value="Maintenance">Maintenance</option>
            </select>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Save Room</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<?php include __DIR__ . '/../../includes/footer.php'; ?>
