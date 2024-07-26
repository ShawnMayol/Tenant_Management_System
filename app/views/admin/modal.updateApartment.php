<?php include('handlers/admin/modal.apartment.php'); ?>

<div class="modal fade" id="editApartmentModal" tabindex="-1" aria-labelledby="editApartmentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editApartmentModalLabel">Edit Apartment Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <!-- Apartment Details Form -->
            <form action="handlers/admin/updateApartment.php" method="POST">
                <input type="hidden" name="apartmentNumber" value="<?php echo htmlspecialchars($_GET['apartment']); ?>">
                
                <div class="mb-3">
                    <label for="apartmentType" class="form-label">Apartment Type</label>
                    <input type="text" class="form-control" id="apartmentType" name="apartmentType" value="<?php echo htmlspecialchars($apartmentDetails['apartmentType']); ?>" required>
                </div>
                
                <div class="mb-3">
                    <label for="rentPerMonth" class="form-label">Rent per Month (₱)</label>
                    <input type="text" class="form-control" id="rentPerMonth" name="rentPerMonth" value="<?php echo htmlspecialchars($apartmentDetails['rentPerMonth']); ?>" required>
                </div>
                
                <div class="mb-3">
                    <label for="apartmentDimensions" class="form-label">Apartment Dimensions</label>
                    <input type="text" class="form-control" id="apartmentDimensions" name="apartmentDimensions" value="<?php echo htmlspecialchars($apartmentDetails['apartmentDimensions']); ?>">
                </div>
                
                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <input type="text" class="form-control" id="apartmentAddress" name="apartmentAddress" value="<?php echo htmlspecialchars($apartmentDetails['apartmentAddress']); ?>">
                </div>
                
                <div class="mb-3">
                    <label for="maxOccupants" class="form-label">Max Occupants</label>
                    <input type="number" class="form-control" id="maxOccupants" name="maxOccupants" value="<?php echo htmlspecialchars($apartmentDetails['maxOccupants']); ?>">
                </div>
                
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="apartmentDescription" name="apartmentDescription" rows="3"><?php echo htmlspecialchars($apartmentDetails['apartmentDescription']); ?></textarea>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
        </div>
    </div>
</div>

<script>
// Optional: JavaScript for form submission handling
document.getElementById('editApartmentForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent default form submission
    
    // You can add additional validation here if needed
    
    // Submit the form via AJAX or let it submit naturally to update_apartment.php
    this.submit();
});
</script>