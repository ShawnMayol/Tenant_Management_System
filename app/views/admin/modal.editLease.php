<!-- Modal -->
<div class="modal fade" id="editLeaseModal" tabindex="-1" aria-labelledby="editLeaseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editLeaseModalLabel">Edit Lease Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editLeaseForm" method="POST" action="handlers/admin/updateLease.php">
                    <input type="hidden" name="lease_ID" id="lease_ID" value="<?php echo htmlspecialchars($lease['lease_ID']); ?>">
                    
                    <div class="mb-3">
                        <label for="apartmentNumber" class="form-label">Apartment Number</label>
                        <input type="text" class="form-control" id="apartmentNumber" name="apartmentNumber" value="<?php echo htmlspecialchars($lease['apartmentNumber']); ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="leaseStartDate" class="form-label">Lease Start Date</label>
                        <input type="date" class="form-control" id="leaseStartDate" name="leaseStartDate" value="<?php echo htmlspecialchars($lease['leaseStartDate']); ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="leaseEndDate" class="form-label">Lease End Date</label>
                        <input type="date" class="form-control" id="leaseEndDate" name="leaseEndDate" value="<?php echo htmlspecialchars($lease['leaseEndDate']); ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="rentAmount" class="form-label">Rent Amount</label>
                        <input type="number" class="form-control" id="rentAmount" name="rentAmount" value="<?php echo htmlspecialchars($lease['rentAmount']); ?>" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </form>
            </div>
        </div>
    </div>
</div>
