<?php
require_once __DIR__ . '/../../config.php';

if(!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$id = intval($_GET['id']);
$page_title = 'Edit Tenant';
$base_path = '../../';
include __DIR__ . '/../../includes/header.php';

// Get tenant data
$tenant = $conn->query("SELECT * FROM m_tenant WHERE tenant_id = $id")->fetch_assoc();

if(!$tenant) {
    echo "Tenant not found";
    exit;
}

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $address = $_POST['address'] ?? '';
    $emergency_contact = $_POST['emergency_contact'] ?? '';

    $stmt = $conn->prepare("UPDATE m_tenant SET name=?, phone=?, address=?, emergency_contact=? WHERE tenant_id=?");
    $stmt->bind_param("ssssi", $name, $phone, $address, $emergency_contact, $id);
    
    if($stmt->execute()) {
        header('Location: index.php');
        exit;
    }
}
?>

<div class="page-header">
    <p class="breadcrumb">Home / <a href="index.php">Tenants</a> / <strong>Edit</strong></p>
</div>

<div class="card form-card">
    <form method="POST" class="form">
        <div class="form-group">
            <label for="name">Name *</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($tenant['name']); ?>" required>
        </div>

        <div class="form-group">
            <label for="phone">Phone *</label>
            <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($tenant['phone']); ?>" required>
        </div>

        <div class="form-group">
            <label for="address">Address *</label>
            <textarea id="address" name="address" required rows="4"><?php echo htmlspecialchars($tenant['address']); ?></textarea>
        </div>

        <div class="form-group">
            <label for="emergency_contact">Emergency Contact *</label>
            <input type="text" id="emergency_contact" name="emergency_contact" value="<?php echo htmlspecialchars($tenant['emergency_contact']); ?>" required>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Update Tenant</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<?php include __DIR__ . '/../../includes/footer.php'; ?>
