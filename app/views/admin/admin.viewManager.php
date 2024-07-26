<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

<style>
    .icon-wrapper {
    position: relative;
    display: inline-block;
    width: 1em; /* Ensure the container has a fixed width */
    }
    .icon-default,
    .icon-hover {
        position: absolute;
        top: -13px;
        left: 0;
    }
    .icon-default-2 {
        position: absolute;
        top: -13px;
        left: 0;
    }
    .icon-hover {
        display: none;
    }

    .icon-wrapper:hover .icon-default {
        display: none;
    }

    .icon-wrapper:hover .icon-hover {
        display: inline;
    }
    .custom-icon {
        font-size: 28px; /* Adjust the size as needed */
    }
    .dropdown-toggle:hover {
        cursor: pointer;
    }
    /* Hide the dropdown caret */
    .dropdown-toggle::after {
        display: none;
    }
</style>

<?php
include('core/database.php');

if (isset($_GET['staff_id'])) {
    $staff_id = $_GET['staff_id'];

    // Query manager information
    $managerSql = "SELECT * FROM staff WHERE staff_ID = ?";
    $managerStmt = $conn->prepare($managerSql);
    $managerStmt->bind_param("i", $staff_id);
    $managerStmt->execute();
    $managerResult = $managerStmt->get_result();
    $manager = $managerResult->fetch_assoc();

    // Query user information (assuming there's a user associated with this staff_id)
    $userSql = "SELECT u.*, u.picDirectory, u.userStatus
                FROM user u
                INNER JOIN staff s ON u.staff_ID = s.staff_ID
                WHERE u.staff_ID = ?";
    $userStmt = $conn->prepare($userSql);
    $userStmt->bind_param("i", $staff_id);
    $userStmt->execute();
    $userResult = $userStmt->get_result();
    $user = $userResult->fetch_assoc();

    // Query activity log for the manager
    $activitySql = "SELECT * FROM activity WHERE staff_ID = ? ORDER BY activityTimestamp DESC LIMIT 10";
    $activityStmt = $conn->prepare($activitySql);
    $activityStmt->bind_param("i", $staff_id);
    $activityStmt->execute();
    $activityResult = $activityStmt->get_result();
    $activities = [];
    while ($activity = $activityResult->fetch_assoc()) {
        $activities[] = $activity;
    }
    $status = htmlspecialchars($user['userStatus']);
    // Close connection
    $conn->close();
} else {
    echo "Manager staff ID is not specified.";
    exit; // or handle the error appropriately
}
?>


<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4" data-theme="<?php echo $theme; ?>">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <div class="container">
            <div class="row">
                <div class="col-auto ps-2 pe-3">
                    <a href="?page=admin.staff" class="icon-wrapper" style="text-decoration: none;">
                        <i class="bi bi-arrow-left-circle text-secondary h2 icon-default"></i>
                        <i class="bi bi-arrow-left-circle-fill text-secondary h2 icon-hover"></i>
                    </a>
                </div>
                <div class="col">
                    <h1 class="h1 m-0"><?php echo htmlspecialchars($manager['lastName'] . ', ' . $manager['firstName'] . ' ' . $manager['middleName']); ?></h1>
                </div>
                <div class="col-auto pe-5">
                    <div class="dropdown">
                        <i class="bi bi-three-dots-vertical fs-3 dropdown-toggle" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false"></i>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editStaffInfoModal">Edit Account</a></li>
                            <li>
                                <form method="POST" action="handlers/admin/resetAccount.php" onsubmit="return confirm('Are you sure you want to reset this account?');" style="display:inline;">
                                    <input type="hidden" name="user_ID" value="<?php echo $user['user_ID']; ?>">
                                    <button type="submit" title="Reset Username and Password to default"  class="dropdown-item">Reset Account</button>
                                </form>
                            </li>
                            <li>
                                <form method="POST" action="<?php echo $status === 'Deactivated' ? 'handlers/admin/activateAccount.php' : 'handlers/admin/deactivateAccount.php'; ?>" onsubmit="return confirm('Are you sure you want to <?php echo $status === 'Deactivated' ? 'activate' : 'deactivate'; ?> this account?');" style="display:inline;">
                                    <input type="hidden" name="staff_id" value="<?php echo $staff_id ?>">
                                    <button type="submit" class="dropdown-item text-danger"><?php echo $status === 'Deactivated' ? 'Activate Account' : 'Deactivate Account'; ?></button>
                                </form>
                            </li>
                            <li>
                                <form method="POST" action="handlers/admin/deleteAccount.php" onsubmit="return confirm('Are you sure you want to delete this account? This action is irreversible');" style="display:inline;">
                                    <input type="hidden" name="user_ID" value="<?php echo $user['user_ID']; ?>">
                                    <button type="submit" class="dropdown-item text-danger" hidden>Delete account</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'views/admin/modal.staffEditInfo.php'; ?>

    <div class="container mt-4">
        <div class="row">
                <div class="col-lg-6">
                    <h3>Manager Information</h3>
                    <hr>
                    <div class="row">
                        <div class="col-lg-5 col-md-12">
                            <div class="position-relative">
                                <?php $picDirectory = substr($user['picDirectory'], 6); ?>
                                <img src="<?php echo htmlspecialchars($picDirectory); ?>" style="height: 250px; width: 300px; object-fit: cover;" class="img-fluid shadow" alt="<?php echo htmlspecialchars($manager['lastName'] . ', ' . $manager['firstName'] . ' ' . $manager['middleName']); ?>">

                            </div>
                        </div>
                        <div class="col-lg-7 col-md-12 mt-2">
                            <p><strong>Username: </strong><?php echo htmlspecialchars($user['username']); ?></p>
                            <p><strong>Phone Number: </strong><?php echo htmlspecialchars($manager['phoneNumber']); ?></p>
                            <p><strong>Email Address: </strong><?php echo htmlspecialchars($manager['emailAddress']); ?></p>
                            <p><strong>Date of Birth: </strong><?php echo htmlspecialchars($manager['dateOfBirth']); ?></p>
                            <p><strong>Age: </strong>
                                <?php
                                // Calculate age based on date of birth
                                if ($manager['dateOfBirth']) {
                                    $dob = new DateTime($manager['dateOfBirth']);
                                    $now = new DateTime();
                                    $age = $dob->diff($now)->y;
                                    echo $age;
                                } else {
                                    echo "N/A";
                                }
                                ?>
                            </p>
                            <?php
                            
                            $statusClass = '';

                            switch ($status) {
                                case 'Online':
                                    $statusClass = 'bg-success text-light';
                                    break;
                                case 'Offline':
                                    $statusClass = 'bg-secondary text-dark';
                                    break;
                                case 'Deactivated':
                                    $statusClass = 'bg-danger text-light';
                                    break;
                                default:
                                    $statusClass = 'bg-light text-dark'; // Default or handle other statuses as needed
                            }
                            ?>
                            <p><strong>Status: </strong><span class="h6"><span class="badge <?php echo $statusClass; ?>"><?php echo $status; ?></span></span></p>
                        </div>
                    </div>
                </div>                        

                <div class="col-lg-6">
                    <h3>Activity Log</h3>
                    <hr>

                    <div class="list-group">
                        <?php foreach ($activities as $activity): ?>
                        <div class="list-group-item">
                            <div class="d-flex w-100 justify-content-between">
                                <small class="mb-1"><?php echo htmlspecialchars($activity['activityDescription']); ?></small>
                                <small>
                                    <?php
                                        $datetime = new DateTime($activity['activityTimestamp']);
                                        echo $datetime->format('F j, Y, g:i A'); // Example format: January 1, 2024, 3:45 PM
                                    ?>
                                </small>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

            </div>
        </div>
    </div>



</main>