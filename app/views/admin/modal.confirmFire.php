<!-- Modal -->
<div class="modal fade" id="confirmFireModal" tabindex="-1" aria-labelledby="confirmFireModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmFireModalLabel">Confirm Action</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Do you really want to fire <?php echo htmlspecialchars($manager['lastName'] . ', ' . $manager['firstName'] . ' ' . $manager['middleName']); ?>?</p>
                <div class="mb-3">
                    <label for="adminPassword" class="form-label">Type admin password:</label>
                    <input type="password" class="form-control" id="adminPassword" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmFireBtn">Confirm</button>
            </div>
        </div>
    </div>
</div>