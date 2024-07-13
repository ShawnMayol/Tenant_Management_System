<!-- Modal -->
<div class="modal fade" id="addManagerModal" tabindex="-1" aria-labelledby="addManagerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addManagerModalLabel">Add Manager</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addManagerForm" method="post" action="handlers/admin/addManager.php">
                <div class="modal-body">
                    <div class="d-flex">
                        <div class="form-floating me-1 flex-fill">
                            <input type="text" class="form-control" id="firstName" name="firstName" placeholder="First Name" required>
                            <label for="firstName">First Name*</label>
                        </div>
                        <div class="form-floating mx-1 flex-fill">
                            <input type="text" class="form-control" id="middleName" name="middleName" placeholder="Middle Name">
                            <label for="middleName">Middle Name</label>
                        </div>
                        <div class="form-floating ms-1 flex-fill">
                            <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Last Name" required>
                            <label for="lastName">Last Name*</label>
                        </div>
                    </div>
                    <div class="form-floating my-2">
                        <input type="date" class="form-control" id="dateOfBirth" name="dateOfBirth" placeholder="Birth Date" required>
                        <label for="dateOfBirth">Birth Date*</label>
                    </div>
                    <div class="form-floating my-2">
                        <input type="tel" class="form-control" id="phoneNumber" name="phoneNumber" placeholder="Phone Number" required>
                        <label for="phoneNumber">Phone Number*</label>
                    </div>
                    <div class="form-floating my-2">
                        <input type="email" class="form-control" id="emailAddress" name="emailAddress" placeholder="name@example.com" required>
                        <label for="emailAddress">Email Address*</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Manager</button>
                </div>
            </form>
        </div>
    </div>
</div>