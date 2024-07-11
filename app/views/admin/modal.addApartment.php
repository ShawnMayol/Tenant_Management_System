<!-- Modal -->

<div class="modal fade" id="addApartmentModal" tabindex="-1" aria-labelledby="addApartmentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addApartmentModalLabel">Add Apartment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addApartmentForm" action="handlers/admin/addApartment.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="apartmentType" class="form-label">Apartment Type</label>
                        <input type="text" class="form-control py-2" id="apartmentType" name="apartmentType" required>
                    </div>
                    <div class="mb-3">
                        <label for="rentPerMonth" class="form-label">Rent Per Month (₱)</label>
                        <input type="number" step="0.01" min="0" class="form-control py-2" id="rentPerMonth" name="rentPerMonth" required>
                    </div>
                    <div class="mb-3">
                        <label for="apartmentDimensions" class="form-label">Apartment Dimensions</label>
                        <input type="text" class="form-control py-2" id="apartmentDimensions" name="apartmentDimensions">
                    </div>
                    <div class="mb-3">
                        <label for="apartmentAddress" class="form-label">Apartment Address</label>
                        <input type="text" class="form-control py-2" id="apartmentAddress" name="apartmentAddress">
                    </div>
                    <div class="mb-3">
                        <label for="maxOccupants" class="form-label">Max Occupants</label>
                        <input type="number" class="form-control py-2" id="maxOccupants" name="maxOccupants" min="1" required>
                    </div>
                    <div class="mb-3">
                        <label for="apartmentStatus" class="form-label">Apartment Status</label>
                        <select class="form-select py-2" id="apartmentStatus" name="apartmentStatus" required>
                            <option value="Available">Available</option>
                            <option value="Occupied">Occupied</option>
                            <option value="Maintenance">Maintenance</option>
                            <option value="Hidden">Hidden</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="apartmentImage" class="form-label">Apartment Image</label>
                        <input type="file" class="form-control py-2" id="apartmentImage" name="apartmentImage" accept="image/*">
                    </div>
                    <div class="mb-3">
                        <label for="apartmentDescription" class="form-label">Apartment Description</label>
                        <textarea class="form-control py-2" id="apartmentDescription" name="apartmentDescription" rows="3"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Apartment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include 'handlers/admin/addApartment.php'; ?>