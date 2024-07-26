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
        $userSql = "SELECT u.*, u.picDirectory 
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
                <!-- <div class="col-auto ps-2 pe-3">
                    <a href="?page=admin.staff" class="icon-wrapper" style="text-decoration: none;">
                        <i class="bi bi-arrow-left-circle text-secondary h2 icon-default"></i>
                        <i class="bi bi-arrow-left-circle-fill text-secondary h2 icon-hover"></i>
                    </a>
                </div> -->
                <div class="col">
                    <h1 class="h1 m-0"><?php echo htmlspecialchars($manager['firstName'] . '\'s Activity Log '); ?></h1>
                </div>
                <!-- <div class="col-auto pe-5">
                    <a href="#" title="Fire this manager" class="icon-wrapper" style="text-decoration: none;">
                        <div class="link">
                            <i class="bi bi-person-x text-danger h2 icon-default-2"></i>
                        </div>
                    </a>
                </div> -->
            </div>
        </div>
    </div>


    <div class="container mt-4">
        <div class="row">
                                      

                <div class="col-lg-12">
                    <!-- <h3>Activity Log</h3>
                    <hr> -->

                    <div class="list-group">
                        <?php foreach ($activities as $activity): ?>
                        <div class="list-group-item">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1"><?php echo htmlspecialchars($activity['activityDescription']); ?></h5>
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