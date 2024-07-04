<script src="assets/dist/js/color-modes.js"></script>

<style>
    input[readonly] {
        color: #6c757d; /* Neutral gray for text color */
        cursor: not-allowed; /* Show disabled cursor */
    }
</style>

<?php
include 'core/database.php';

// Retrieve user data from session
$loggedInUserID = $_SESSION['user_id'] ?? null;

// Initialize variables for tenant information
$username = "";
$fullName = "";
$dateOfBirth = "";
$phoneNumber = "";
$emailAddress = "";

// Check if user is logged in
if ($loggedInUserID) {
    // Query to fetch tenant information based on logged-in user ID
    $query = "SELECT u.username, 
                 CONCAT(t.firstName, 
                        IFNULL(CONCAT(' ', t.middleName), ''), 
                        ' ', t.lastName) AS fullName, 
                 t.dateOfBirth, 
                 t.phoneNumber, 
                 t.emailAddress
          FROM user u
          LEFT JOIN tenant t ON u.tenant_ID = t.tenant_ID
          WHERE u.user_ID = $loggedInUserID";

$result = $conn->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $username = $row['username'];
        $fullName = $row['fullName'];
        $dateOfBirth = date('l, F j, Y', strtotime($row['dateOfBirth']));
        $phoneNumber = $row['phoneNumber'];
        $emailAddress = $row['emailAddress'];
    }

    } else {
        echo "No tenant information found.";
    }
} else {
    echo "User not logged in.";
}
?>

<!-- Modal for Account Details -->
<div class="modal fade" id="accountModal" tabindex="-1" aria-labelledby="accountModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form action="handlers/common/updateAccount.php" method="POST"> 
                <div class="modal-header">
                    <h5 class="modal-title" id="accountModalLabel">My Account</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <!-- Placeholder for tenant's picture -->
                            <img src="uploads/admin/profile/placeholder.jpg" class="img-fluid mb-2" alt="Tenant Picture">
                            <div>
                                <button class="btn btn-outline-primary">Change Picture</button>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <!-- Display tenant information fetched from database -->
                            <div class="mb-3">
                                <label for="username" class="form-label">Username:</label>
                                <input type="text" class="form-control" id="username" name="username" value="<?= $username ?>">
                            </div>
                            <div class="mb-3">
                                <label for="fullName" class="form-label">Full Name:</label>
                                <input type="text" class="form-control" id="fullName" value="<?= $fullName ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="dob" class="form-label">Date of Birth:</label>
                                <input type="text" class="form-control" id="dob" value="<?= $dateOfBirth ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="emailAddress" class="form-label">Email Address:</label>
                                <input type="email" class="form-control" id="emailAddress" name="emailAddress" value="<?= $emailAddress ?>">
                            </div>
                            <div class="mb-3">
                                <label for="phoneNumber" class="form-label">Phone Number:</label>
                                <input type="text" class="form-control" id="phoneNumber" name="phoneNumber" value="<?= $phoneNumber ?>">
                            </div>
                            <div>
                                <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#changePasswordModal" data-bs-dismiss="modal" type="button">Change Password</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>


<?php
$conn->close();
?>
