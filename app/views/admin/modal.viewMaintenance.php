<?php
$apartmentNumber = $_GET['apartment']; // Example apartment number
include('core/database.php');

// Fetch maintenance requests for the apartment
$sql = "SELECT request_ID, maintenanceType, description, requestDate, status, completionDate 
        FROM maintenancerequests 
        WHERE apartmentNumber = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $apartmentNumber);
$stmt->execute();
$result = $stmt->get_result();

$maintenanceRequests = [];
while ($row = $result->fetch_assoc()) {
    $maintenanceRequests[] = $row;
}
$stmt->close();
?>

<!-- Modal -->
<div class="modal fade" id="apartmentMaintenanceModal" tabindex="-1" aria-labelledby="apartmentMaintenanceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="apartmentMaintenanceModalLabel">Maintenance Requests</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-striped text-center">
                    <thead>
                        <tr>
                            <th scope="col">Type</th>
                            <th scope="col">Request Date</th>
                            <th scope="col">Status</th>
                            <th scope="col">Completion Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($maintenanceRequests)): ?>
                            <?php foreach ($maintenanceRequests as $request): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($request['maintenanceType']); ?></td>
                                    <td><?php echo htmlspecialchars(date('F j, Y', strtotime($request['requestDate']))); ?></td>
                                    <td><?php echo htmlspecialchars($request['status']); ?></td>
                                    <td><?php echo $request['completionDate'] ? htmlspecialchars(date('F j, Y', strtotime($request['completionDate']))) : 'N/A'; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6">No maintenance requests found for this apartment.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
