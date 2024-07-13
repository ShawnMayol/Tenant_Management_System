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

    if (isset($_GET['tenant_id'])) {
        $tenant_id = $_GET['tenant_id'];

        // Query tenant information
        $tenantSql = "SELECT * FROM tenant WHERE tenant_ID = ?";
        $tenantStmt = $conn->prepare($tenantSql);
        $tenantStmt->bind_param("i", $tenant_id);
        $tenantStmt->execute();
        $tenantResult = $tenantStmt->get_result();
        $tenant = $tenantResult->fetch_assoc();

        // Ensure the tenant data was retrieved successfully
        if ($tenant) {
            // Query user information (assuming there's a user associated with this tenant_id)
            $userSql = "SELECT u.*, u.picDirectory 
                        FROM user u
                        INNER JOIN tenant t ON u.tenant_ID = t.tenant_ID
                        WHERE u.tenant_ID = ?";
            $userStmt = $conn->prepare($userSql);
            $userStmt->bind_param("i", $tenant_id);
            $userStmt->execute();
            $userResult = $userStmt->get_result();
            $user = $userResult->fetch_assoc();

            // Ensure there's a lease_ID to query lease information
            if (!empty($tenant['lease_ID'])) {
                // Query lease information for the tenant
                $leaseSql = "SELECT * FROM lease WHERE lease_ID = ?";
                $leaseStmt = $conn->prepare($leaseSql);
                $leaseStmt->bind_param("i", $tenant['lease_ID']);
                $leaseStmt->execute();
                $leaseResult = $leaseStmt->get_result();
                $lease = $leaseResult->fetch_assoc();
            } else {
                $lease = null;
            }
        } else {
            echo "Tenant not found.";
            exit; // or handle the error appropriately
        }

        // Close connection
        $conn->close();
    } else {
        echo "Tenant ID is not specified.";
        exit; // or handle the error appropriately
    }
?>


<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4" data-theme="<?php echo $theme; ?>">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <div class="container">
            <div class="row">
                <div class="col-auto ps-2 pe-3">
                    <a href="?page=admin.tenants" class="icon-wrapper" style="text-decoration: none;">
                        <i class="bi bi-arrow-left-circle text-secondary h2 icon-default"></i>
                        <i class="bi bi-arrow-left-circle-fill text-secondary h2 icon-hover"></i>
                    </a>
                </div>
                <div class="col">
                    <h1 class="h1 m-0"><?php echo htmlspecialchars($tenant['lastName'] . ', ' . $tenant['firstName'] . ' ' . $tenant['middleName']); ?></h1>
                </div>
                <div class="col-auto pe-5">
                    <div class="dropdown">
                        <i class="bi bi-three-dots-vertical fs-3 dropdown-toggle" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false"></i>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <!-- <li><a class="dropdown-item" href="#">Action 1</a></li>
                            <li><a class="dropdown-item" href="#">Action 2</a></li> -->
                            <li><a class="dropdown-item text-danger" href="#">Reset password</a></li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <div class="container mt-4">
        <div class="row">
                            <div class="col-lg-6">
                        <div class="row">
                            <div class="col-lg-5 col-md-12 mt-3">
                                <div class="position-relative">
                                    <?php $picDirectory = substr($user['picDirectory'], 6); ?>
                                    <img src="<?php echo htmlspecialchars($picDirectory); ?>" style="height: 250px; width: 300px; object-fit: cover;" class="img-fluid shadow" alt="<?php echo htmlspecialchars($tenant['lastName'] . ', ' . $tenant['firstName'] . ' ' . $tenant['middleName']); ?>">
                                </div>
                            </div>
                            <div class="col-lg-7 col-md-12 mt-4">
                                <p><strong>Username: </strong><?php echo htmlspecialchars($user['username']); ?></p>
                                <p><strong>Phone Number: </strong><?php echo htmlspecialchars($tenant['phoneNumber']); ?></p>
                                <p><strong>Email Address: </strong><?php echo htmlspecialchars($tenant['emailAddress']); ?></p>
                                <p><strong>Date of Birth: </strong><?php echo htmlspecialchars(date('F j, Y', strtotime($tenant['dateOfBirth']))); ?></p>
                                <p><strong>Age: </strong>
                                    <?php
                                    // Calculate age based on date of birth
                                    if ($tenant['dateOfBirth']) {
                                        $dob = new DateTime($tenant['dateOfBirth']);
                                        $now = new DateTime();
                                        $age = $dob->diff($now)->y;
                                        echo $age;
                                    } else {
                                        echo "N/A";
                                    }
                                    ?>
                                </p>
                            </div>
                        </div>
                    </div>                     

                <div class="col-lg-6">
                <h3>Lease Term</h3>
                <hr>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <tbody>
                                <?php if ($lease): ?>
                                    <tr>
                                        <th scope="row">Apartment Number</th>
                                        <td class="py-4"><?php echo htmlspecialchars($lease['apartmentNumber']); ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Start Date</th>
                                        <td class="py-4"><?php echo htmlspecialchars(date('F j, Y', strtotime($lease['startDate']))); ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">End Date</th>
                                        <td class="py-4"><?php echo htmlspecialchars(date('F j, Y', strtotime($lease['endDate']))); ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Billing Period</th>
                                        <td class="py-4"><?php echo htmlspecialchars($lease['billingPeriod']); ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Security Deposit</th>
                                        <td class="py-4">₱<?php echo htmlspecialchars($lease['securityDeposit']); ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Lease Status</th>
                                        <td class="py-4">
                                            <?php
                                                $leaseStatus = htmlspecialchars($lease['leaseStatus']);
                                                $leaseStatusClass = '';
                                                switch ($leaseStatus) {
                                                    case 'active':
                                                        $leaseStatusClass = 'bg-success text-light';
                                                        break;
                                                    case 'expired':
                                                        $leaseStatusClass = 'bg-secondary text-dark';
                                                        break;
                                                    case 'terminated':
                                                        $leaseStatusClass = 'bg-danger text-light';
                                                        break;
                                                    default:
                                                        $leaseStatusClass = 'bg-light text-dark'; // Default or handle other statuses as needed
                                                }
                                            ?>
                                            <span class="badge <?php echo $leaseStatusClass; ?>"><?php echo ucfirst($leaseStatus); ?></span>
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="2">No lease information found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>



</main>