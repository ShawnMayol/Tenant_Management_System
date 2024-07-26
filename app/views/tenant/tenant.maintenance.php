<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

<?php

include('core/database.php'); 

if (isset($_SESSION['tenant_id'])) {
    $tenant_id = $_SESSION['tenant_id'];

    $tenantQuery = "SELECT lease_ID FROM tenant WHERE tenant_ID = ?";
    $tenantStmt = $conn->prepare($tenantQuery);
    $tenantStmt->bind_param("i", $tenant_id);
    $tenantStmt->execute();
    $tenantResult = $tenantStmt->get_result();

    if ($tenantResult->num_rows === 0) {
        echo "Tenant not found.";
        exit;
    }

    $tenantData = $tenantResult->fetch_assoc();
    $lease_ID = $tenantData['lease_ID'];
    $tenantStmt->close();

    $leaseQuery = "SELECT apartmentNumber FROM lease WHERE lease_ID = ?";
    $leaseStmt = $conn->prepare($leaseQuery);
    $leaseStmt->bind_param("i", $lease_ID);
    $leaseStmt->execute();
    $leaseResult = $leaseStmt->get_result();

    if ($leaseResult->num_rows === 0) {
        echo "Lease not found.";
        exit;
    }

    $leaseData = $leaseResult->fetch_assoc();
    $apartmentNumber = $leaseData['apartmentNumber'];
    $leaseStmt->close();

    $sql = "SELECT request_ID, maintenanceType, description, requestDate, status, completionDate 
            FROM maintenancerequests 
            WHERE tenant_ID = ? AND apartmentNumber = ?
            ORDER BY requestDate DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $tenant_id, $apartmentNumber);
    $stmt->execute();
    $result = $stmt->get_result();

    $maintenanceRequests = [];
    while ($row = $result->fetch_assoc()) {
        $maintenanceRequests[] = $row;
    }

    $stmt->close();
} else {
    echo "Tenant ID not found.";
    exit;
}

$conn->close();
?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4" data-theme="<?php echo $theme; ?>">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <div class="row">
            <div class="col">
                <h1 class="h1 m-0">Maintenance</h1>
            </div>
        </div>
    </div>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title mb-4">Submit a Maintenance Request</h2>
                        
                        <form action="handlers/tenant/maintenanceRequest.php" method="post">
                            <input type="hidden" name="apartmentNumber" value="<?php echo htmlspecialchars($apartmentNumber); ?>">

                            <div class="mb-3">
                                <label for="maintenanceType" class="form-label">Type of Maintenance*</label>
                                <select class="form-select" id="maintenanceType" name="maintenanceType" required>
                                    <option value="" disabled selected>Select maintenance type</option>
                                    <option value="Plumbing">Plumbing</option>
                                    <option value="Electrical">Electrical</option>
                                    <option value="HVAC">HVAC (Heating, Ventilation, Air Conditioning)</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description*</label>
                                <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                                <small class="form-text text-muted">Tell us more about the maintenance request.</small>
                            </div>
                            <button type="submit" class="btn btn-primary mt-4" style="width: 100%;">Submit Request</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
    <div class="card">
        <div class="card-body">
            <h2 class="card-title">Maintenance History</h2>
            <?php if (!empty($maintenanceRequests)): ?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Completion Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($maintenanceRequests as $request): ?>
                            <tr>
                                <td class="py-3"><?php echo htmlspecialchars($request['maintenanceType']); ?></td>
                                <td class="py-3"><?php echo htmlspecialchars($request['status']); ?></td>
                                <td class="py-3"><?php echo htmlspecialchars($request['completionDate'] ? date('F j, Y', strtotime($request['completionDate'])) : 'Not Completed'); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No records found.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

        </div>
    </div>
</main>

<footer class="py-3 my-4">
    <ul class="nav justify-content-center border-bottom pb-3 mb-3">
      <li class="nav-item"><a href="<?= htmlspecialchars($dashboardPage) ?>" class="nav-link px-2 text-body-secondary">Home</a></li>
      <li class="nav-item"><a href="views/common/browse.php" class="nav-link px-2 text-body-secondary">Apartments</a></li>
      <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">Pricing</a></li>
      <li class="nav-item"><a href="?page=../../views/common/faq" class="nav-link px-2 text-body-secondary">FAQs</a></li>
      <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">About</a></li>
    </ul>
    <p class="text-center text-body-secondary">&copy; C-Apartments 2024</p>
</footer>