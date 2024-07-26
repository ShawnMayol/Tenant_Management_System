<?php
?>
<!-- Modal for Tenant -->
<div class="modal fade" id="editTenantInfoModal" tabindex="-1" aria-labelledby="editTenantInfoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTenantInfoModalLabel">Edit Tenant Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editTenantInfoForm" method="POST" action="handlers/admin/editTenantInformation.php">
                    <input type="hidden" name="tenant_ID" id="tenant_ID" value="<?php echo htmlspecialchars($tenant['tenant_ID']); ?>">
                    <div class="mb-3">
                        <label for="firstName" class="form-label">First Name*</label>
                        <input type="text" class="form-control" id="firstName" name="firstName" value="<?php echo htmlspecialchars($tenant['firstName']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="middleName" class="form-label">Middle Name</label>
                        <input type="text" class="form-control" id="middleName" name="middleName" value="<?php echo htmlspecialchars($tenant['middleName']); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="lastName" class="form-label">Last Name*</label>
                        <input type="text" class="form-control" id="lastName" name="lastName" value="<?php echo htmlspecialchars($tenant['lastName']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="dateOfBirth" class="form-label">Date of Birth*</label>
                        <input type="date" class="form-control" id="dateOfBirth" name="dateOfBirth" value="<?php echo htmlspecialchars($tenant['dateOfBirth']); ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </form>
            </div>
        </div>
    </div>
</div>