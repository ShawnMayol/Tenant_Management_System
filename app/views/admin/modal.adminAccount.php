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

// Initialize variables for staff information
$username = "";
$fullName = "";
$emailAddress = "";
$phoneNumber = "";
$dateOfBirth = "";
$picDirectory = "uploads/staff/placeholder.jpg"; // Default picture
$userRole = "";

// Check if user is logged in
if ($loggedInUserID) {
    // Query to fetch staff information based on logged-in user ID
    $query = "SELECT u.username, 
                     s.firstName,
                     s.middleName,
                     s.lastName,
                     s.phoneNumber, 
                     s.emailAddress, 
                     s.dateOfBirth,
                     u.picDirectory,
                     u.userRole
              FROM user u
              LEFT JOIN staff s ON u.staff_ID = s.staff_ID
              WHERE u.user_ID = $loggedInUserID";

    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $username = $row['username'];
            $firstName = $row['firstName'];
            $middleName = $row['middleName'];
            $lastName = $row['lastName'];
            $phoneNumber = $row['phoneNumber'];
            $emailAddress = $row['emailAddress'];
            $dateOfBirth = $row['dateOfBirth'];
            $picDirectory = $row['picDirectory'] ?? "uploads/staff/placeholder.jpg";
            $userRole = $row['userRole'];
        }
    } else {
        echo "No staff information found.";
    }
} else {
    echo "User not logged in.";
}
?>

<!-- Modal for ADMIN account Details -->
<div class="modal fade" id="adminAccountModal" tabindex="-1" aria-labelledby="accountModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form action="handlers/admin/staffUpdateAccount.php" method="POST" enctype="multipart/form-data">
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
                            <div class="mt-2">
                                <strong>Role:</strong> <?php echo $userRole; ?>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <!-- Display staff information fetched from database -->
                            <div class="mb-3">
                                <label for="username" class="form-label">Username:</label>
                                <input type="text" class="form-control py-2" id="username" name="username" value="<?= $username ?>">
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="firstName" class="form-label">First Name:</label>
                                    <input type="text" class="form-control py-2" id="firstName" value="<?= $firstName ?>">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="middleName" class="form-label">Middle Name:</label>
                                    <input type="text" class="form-control py-2" id="middleName" value="<?= $middleName ?>">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="lastName" class="form-label">Last Name:</label>
                                    <input type="text" class="form-control py-2" id="lastName" value="<?= $lastName ?>">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="dateOfBirth" class="form-label">Date of Birth:</label>
                                <input type="date" class="form-control py-2" id="dateOfBirth" value="<?= $dateOfBirth ?>" >
                            </div>
                            <div class="mb-3">
                                <label for="emailAddress" class="form-label">Email Address:</label>
                                <input type="email" class="form-control py-2" id="emailAddress" name="emailAddress" value="<?= $emailAddress ?>">
                            </div>
                            <div class="mb-3">
                                <label for="phoneNumber" class="form-label">Phone Number:</label>
                                <input type="text" class="form-control py-2" id="phoneNumber" name="phoneNumber" value="<?= $phoneNumber ?>">
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
