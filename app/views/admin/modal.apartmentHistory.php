<?php
$apartmentNumber = $_GET['apartment']; // Example apartment number
include('core/database.php');

// Fetch lease history for the apartment
$sql = "SELECT * FROM lease WHERE apartmentNumber = ? ORDER BY startDate DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $apartmentNumber);
$stmt->execute();
$result = $stmt->get_result();

$leaseHistory = [];
while ($row = $result->fetch_assoc()) {
    $leaseHistory[] = $row;
}
$stmt->close();
?>

<!-- Modal -->
<div class="modal fade" id="apartmentHistoryModal" tabindex="-1" aria-labelledby="apartmentHistoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="apartmentHistoryModalLabel">Apartment Rental History</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-striped text-center">
                    <thead>
                        <tr>
                            <!-- <th scope="col">Lease ID</th> -->
                            <th scope="col">Start Date</th>
                            <th scope="col">End Date</th>
                            <!-- <th scope="col">Billing Period</th> -->
                            <!-- <th scope="col">Rental Deposit</th>
                            <th scope="col">Security Deposit</th> -->
                            <th scope="col">Lease Status</th>
                            <!-- <th scope="col">Reviewed By</th> -->
                        </tr>
                    </thead>
                    <tbody id="apartmentHistoryTableBody">
    <?php foreach ($leaseHistory as $lease): ?>
        <tr>
            <!-- <td><?php echo htmlspecialchars($lease['lease_ID']); ?></td> -->
            <td><?php echo htmlspecialchars($lease['startDate']); ?></td>
            <td><?php echo htmlspecialchars($lease['endDate']); ?></td>
            <!-- <td><?php echo htmlspecialchars($lease['billingPeriod']); ?></td>
            <td><?php echo htmlspecialchars($lease['rentalDeposit']); ?></td>
            <td><?php echo htmlspecialchars($lease['securityDeposit']); ?></td> -->
            <td><?php echo htmlspecialchars($lease['leaseStatus']); ?></td>
            <!-- <td><?php echo htmlspecialchars($lease['reviewedBy']); ?></td> -->
        </tr>
    <?php endforeach; ?>
</tbody>
                </table>
            </div>
        </div>
    </div>
</div>