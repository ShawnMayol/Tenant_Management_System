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
    .clickable-row {
        cursor: pointer;
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

                // Query occupants associated with the lease
                $occupantSql = "SELECT * FROM tenant WHERE lease_ID = ? AND tenantType = 'Occupant'";
                $occupantStmt = $conn->prepare($occupantSql);
                $occupantStmt->bind_param("i", $tenant['lease_ID']);
                $occupantStmt->execute();
                $occupantResult = $occupantStmt->get_result();

                $occupants = [];
                while ($row = $occupantResult->fetch_assoc()) {
                    $occupants[] = $row;
                }
            } else {
                $lease = null;
                $occupants = [];
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
    $status = htmlspecialchars($user['userStatus']);
?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var rows = document.querySelectorAll('.clickable-row');
        rows.forEach(function(row) {
            row.addEventListener('click', function() {
                window.location.href = row.dataset.href;
            });
        });
    });
</script>

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
                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editTenantInfoModal">Edit Account</a></li>
                            <li>
                                <form method="POST" action="handlers/admin/resetAccount.php" onsubmit="return confirm('Are you sure you want to reset this account?');" style="display:inline;">
                                    <input type="hidden" name="user_ID" value="<?php echo $user['user_ID']; ?>">
                                    <button type="submit" title="Reset Username and Password to default" class="dropdown-item">Reset Account</button>
                                </form>
                            </li>
                            <li><a class="dropdown-item" href="#">Edit Lease</a></li>
                            <li>
                                <form method="POST" action="<?php echo $status === 'Deactivated' ? 'handlers/admin/tenantActivateAccount.php' : 'handlers/admin/tenantDeactivateAccount.php'; ?>" onsubmit="return confirm('Are you sure you want to <?php echo $status === 'Deactivated' ? 'activate' : 'deactivate'; ?> this account?');" style="display:inline;">
                                    <input type="hidden" name="tenant_id" value="<?php echo $tenant_id ?>">
                                    <button type="submit" class="dropdown-item text-danger"><?php echo $status === 'Deactivated' ? 'Activate Account' : 'Deactivate Account'; ?></button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <?php include 'views/admin/modal.tenantEditInfo.php'; ?>

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
                        <div class="col-lg-7 col-md-12">
                            <h3>Lessee</h3>
                            <hr>
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
                <h3>Lease Term</h3>
                <hr>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <tbody>
                                <?php if ($lease): ?>
                                    <tr class="clickable-row" data-href="?page=admin.viewApartment&apartment=<?php echo htmlspecialchars($lease['apartmentNumber']); ?>">
                                        <th scope="row">Apartment Number</th>
                                        <td class="py-3"><?php echo htmlspecialchars($lease['apartmentNumber']); ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Start Date</th>
                                        <td class="py-3"><?php echo htmlspecialchars(date('F j, Y', strtotime($lease['startDate']))); ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">End Date</th>
                                        <td class="py-3"><?php echo htmlspecialchars(date('F j, Y', strtotime($lease['endDate']))); ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Billing Period</th>
                                        <td class="py-3"><?php echo htmlspecialchars($lease['billingPeriod']); ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Security Deposit</th>
                                        <td class="py-3">₱<?php echo htmlspecialchars($lease['securityDeposit']); ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Lease Status</th>
                                        <td class="py-3">
                                            <?php
                                                $leaseStatus = htmlspecialchars($lease['leaseStatus']);
                                                $leaseStatusClass = '';
                                                switch ($leaseStatus) {
                                                    case 'Active':
                                                        $leaseStatusClass = 'bg-success text-light h6';
                                                        break;
                                                    case 'Expired':
                                                        $leaseStatusClass = 'bg-secondary text-dark h6';
                                                        break;
                                                    case 'Terminated':
                                                        $leaseStatusClass = 'bg-danger text-light h6';
                                                        break;
                                                    default:
                                                        $leaseStatusClass = 'bg-light text-dark h6'; // Default or handle other statuses as needed
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
                    <div class="row mt-3 mb-5">
                        <h3>Registered Occupants</h3>
                        <hr>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <!-- <th>Birthday</th> -->
                                        <th>Gender</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($occupants)): ?>
                                        <?php foreach ($occupants as $occupant): ?>
                                            <tr>
                                                <td class="py-3"><?= htmlspecialchars($occupant['firstName'] . ' ' . $occupant['middleName'] . ' ' . $occupant['lastName']) ?></td>
                                                <td class="py-3"><?= htmlspecialchars($occupant['phoneNumber']) ?></td>
                                                <td class="py-3"><?= htmlspecialchars($occupant['emailAddress']) ?></td>
                                                <!-- <td><?= htmlspecialchars(date("F j, Y", strtotime($occupant['dateOfBirth']))) ?></td> -->
                                                <td class="py-3"><?= htmlspecialchars($occupant['gender']) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5">No occupants found.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>