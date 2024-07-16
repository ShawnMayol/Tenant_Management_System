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
                 t.emailAddress,
                 u.picDirectory
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
        $picDirectory = $row['picDirectory'] ?? "uploads/tenant/placeholder.jpg";
    }

    } else {
        echo "No tenant information found.";
    }
} else {
    echo "User not logged in.";
}
?>

<!-- Modal for Account Details -->
<div class="modal fade" id="tenantAccountModal" tabindex="-1" aria-labelledby="accountModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form action="handlers/common/updateAccount.php" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="accountModalLabel">My Account</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <?php $picDirectory = substr($picDirectory, 6); ?>
                            <img src="<?php echo $picDirectory; ?>" class="img-fluid mb-2" alt="Staff Picture">
                            <div>
                                <label for="uploadProfilePic" class="form-label">Change Picture:</label>
                                <input class="form-control py-1" type="file" id="uploadProfilePic" name="profilePic" accept="image/*" aria-describedby="fileHelp">
                            </div>
                            <!-- <div class="mt-2">
                                <strong>Role:</strong> <?php echo $userRole; ?>
                            </div> -->
                        </div>
                        <div class="col-md-8">
                            <!-- Display staff information fetched from database -->
                            <div class="mb-3">
                                <label for="username" class="form-label">Username:</label>
                                <input type="text" class="form-control py-2" id="username" name="username" value="<?= $username ?>" required>
                            </div>
                            <!-- <div class="mb-3">
                                <label for="fullName" class="form-label">Full Name:</label>
                                <input type="text" class="form-control py-2" id="fullName" value="<?= $fullName ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="dateOfBirth" class="form-label">Date of Birth:</label>
                                <input type="text" class="form-control py-2" id="dateOfBirth" value="<?= $dateOfBirth ?>" readonly>
                            </div> -->
                            <div class="mb-3">
                                <label for="emailAddress" class="form-label">Email Address:</label>
                                <input type="email" class="form-control py-2" id="emailAddress" name="emailAddress" value="<?= $emailAddress ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="phoneNumber" class="form-label">Phone Number:</label>
                                <input type="text" class="form-control py-2" id="phoneNumber" name="phoneNumber" value="<?= $phoneNumber ?>" required maxlength="11" pattern="09\d{9}">
                                <small id="phoneNumberHelp" class="form-text text-muted">Phone number must start with 09 and have 11 digits in total.</small>
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

<script>
    document.addEventListener("DOMContentLoaded", function() {
    var phoneNumberInput = document.getElementById("phoneNumber");

    phoneNumberInput.addEventListener("input", function() {
        // Remove any non-numeric characters
        this.value = this.value.replace(/\D/g, '');

        // Limit length to 11 characters
        if (this.value.length > 11) {
            this.value = this.value.slice(0, 11);
        }
    });
});
</script>

<?php
$conn->close();
?>
