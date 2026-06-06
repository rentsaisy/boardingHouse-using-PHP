<?php
require_once __DIR__ . '/../../config.php';
$page_title = 'Add Tenant';
$base_path = '../../';
include __DIR__ . '/../../includes/header.php';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $address = $_POST['address'] ?? '';
    $emergency_contact = $_POST['emergency_contact'] ?? '';

    $stmt = $conn->prepare("INSERT INTO m_tenant (name, phone, address, emergency_contact) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $phone, $address, $emergency_contact);
    
    if($stmt->execute()) {
        header('Location: index.php');
        exit;
    }
}
?>

<div class="page-header">
    <p class="breadcrumb">Home / <a href="index.php">Tenants</a> / <strong>Add New</strong></p>
</div>

<div class="card form-card">
    <form method="POST" class="form">
        <div class="form-group">
            <label for="name">Name *</label>
            <input type="text" id="name" name="name" required>
        </div>

        <div class="form-group">
            <label for="phone">Phone *</label>
            <input type="text" id="phone" name="phone" required>
        </div>

        <div class="form-group">
            <label for="address">Address *</label>
            <textarea id="address" name="address" required rows="4"></textarea>
        </div>

        <div class="form-group">
            <label for="emergency_contact">Emergency Contact *</label>
            <input type="text" id="emergency_contact" name="emergency_contact" required>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Save Tenant</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<?php include __DIR__ . '/../../includes/footer.php'; ?>
