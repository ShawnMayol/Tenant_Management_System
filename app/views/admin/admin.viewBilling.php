<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

<style>
    .icon-wrapper {
        position: relative;
        display: inline-block;
        width: 1em;
        /* Ensure the container has a fixed width */
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
        font-size: 28px;
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

    .card.bg-danger:hover {
        background-color: #dc3545;
        filter: brightness(108%);
    }

    .card.bg-success:hover {
        background-color: #198754;
        filter: brightness(108%);
    }

    .card.bg-primary:hover {
        background-color: #0d6efd;
        filter: brightness(108%);
    }

    .card.bg-warning:hover {
        background-color: #ffc107;
        filter: brightness(108%);
    }
</style>

<?php
include ('core/database.php');

if (isset($_GET['tenant_id'])) {
    $tenant_id = $_GET['tenant_id'];

    // Query tenant information
    $tenantSql = "SELECT * FROM tenant WHERE tenant_ID = ?";
    $tenantStmt = $conn->prepare($tenantSql);
    $tenantStmt->bind_param("i", $tenant_id);
    $tenantStmt->execute();
    $tenantResult = $tenantStmt->get_result();
    $tenant = $tenantResult->fetch_assoc();

    if ($tenant) {
        // Query user information
        $userSql = "SELECT u.*, u.picDirectory 
                    FROM user u
                    INNER JOIN tenant t ON u.tenant_ID = t.tenant_ID
                    WHERE u.tenant_ID = ?";
        $userStmt = $conn->prepare($userSql);
        $userStmt->bind_param("i", $tenant_id);
        $userStmt->execute();
        $userResult = $userStmt->get_result();
        $user = $userResult->fetch_assoc();

        if (!empty($tenant['lease_ID'])) {
            // Query lease information including staff name
            $leaseSql = "SELECT l.*, CONCAT(s.firstName, ' ', s.middleName, ' ', s.lastName) AS reviewedByName
                         FROM lease l
                         LEFT JOIN staff s ON l.reviewedBy = s.staff_ID
                         WHERE l.lease_ID = ?";
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

            // Query bills associated with the lease
            $billSql = "SELECT * FROM bill WHERE lease_ID = ?";
            $billStmt = $conn->prepare($billSql);
            $billStmt->bind_param("i", $tenant['lease_ID']);
            $billStmt->execute();
            $billResult = $billStmt->get_result();

            $bills = [];
            while ($row = $billResult->fetch_assoc()) {
                $bills[] = $row;
            }

            $daysAfterDue = 3;  // Number of days after the due date to add late fees

            // Check each bill for overdue status and update if necessary
            foreach ($bills as $bill) {
                // $currentDate = date('Y-m-d');        // Actual date
                $currentDate = date('Y-m-d', strtotime('+1 day'));     // To testing purposes
                $dueDate = $bill['dueDate'];
                $billStatus = $bill['billStatus'];

                // Calculate the date 3 days after the due date
                $graceDays = date('Y-m-d', strtotime($dueDate . ' + ' . $daysAfterDue . ' days'));

                // Compare dates to check if overdue and bill status is not 'Paid' or 'Paid by Deposit'
                if (($billStatus != 'Paid' && $billStatus != 'Paid by Deposit') && $currentDate > $dueDate) {
                    $rentAmount = $bill['amountDue'];
                    $lateFee = $rentAmount * 0.10; // 10% late fee

                    // Calculate the number of overdue days, including grace period
                    $dueDateTime = new DateTime($dueDate);
                    $currentDateTime = new DateTime($currentDate);

                    // Calculate the number of days past the due date
                    $daysOverdue = $dueDateTime->diff($currentDateTime)->days;

                    // Apply late fees for each overdue day within the grace period
                    if ($daysOverdue <= $daysAfterDue) {
                        $totalLateFee = $daysOverdue * $lateFee;

                        // Update bill status to 'Overdue' and add late fees to the existing lateFees column
                        $updateSql = "UPDATE bill SET billStatus = 'Overdue', lateFees = ? WHERE bill_ID = ?";
                        $updateStmt = $conn->prepare($updateSql);
                        $updateStmt->bind_param("di", $totalLateFee, $bill['bill_ID']);
                        $updateStmt->execute();
                        $updateStmt->close();

                        // Update the bill array with the new status and late fees
                        $bill['billStatus'] = 'Overdue';
                        $bill['lateFees'] = $totalLateFee;
                    }
                }

                // Fetch updated data for the current bill
                $fetchSql = "SELECT *
                  FROM bill b
                  JOIN lease l ON b.lease_id = l.lease_ID
                  JOIN apartment a ON l.apartmentNumber = a.apartmentNumber
                  WHERE b.bill_ID = ?";
                $fetchStmt = $conn->prepare($fetchSql);
                $fetchStmt->bind_param("i", $bill['bill_ID']);
                $fetchStmt->execute();
                $fetchResult = $fetchStmt->get_result();
                $updatedBill = $fetchResult->fetch_assoc();
                $fetchStmt->close();

                // Update the bills array with the fetched updated data
                foreach ($bills as &$b) {
                    if ($b['bill_ID'] == $updatedBill['bill_ID']) {
                        $b = $updatedBill;
                        break;
                    }
                }
            }
        } else {
            $lease = null;
            $occupants = [];
            $bills = [];
        }
        $conn->close();
    } else {
        echo "Tenant not found.";
        exit;
    }
} else {
    echo "Tenant ID is not specified.";
    exit;
}
$status = htmlspecialchars($user['userStatus']);
?>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        var rows = document.querySelectorAll('.clickable-row');
        rows.forEach(function (row) {
            row.addEventListener('click', function () {
                window.location.href = row.dataset.href;
            });
        });
    });
</script>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4" data-theme="<?php echo $theme; ?>">
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <div class="container">
            <div class="row">
                <div class="col-auto ps-2 pe-3">
                    <a href="?page=admin.payments" class="icon-wrapper" style="text-decoration: none;">
                        <i class="bi bi-arrow-left-circle text-secondary h2 icon-default"></i>
                        <i class="bi bi-arrow-left-circle-fill text-secondary h2 icon-hover"></i>
                    </a>
                </div>
                <div class="col">
                    <h1 class="h1 m-0">
                        <?php echo htmlspecialchars($tenant['lastName'] . ', ' . $tenant['firstName'] . ' ' . $tenant['middleName']); ?>
                    </h1>
                </div>
                <div class="col-auto pe-5">
                    <div class="dropdown">
                        <i class="bi bi-three-dots-vertical fs-3 dropdown-toggle" id="dropdownMenuButton"
                            data-bs-toggle="dropdown" aria-expanded="false"></i>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal"
                                    data-bs-target="#editTenantInfoModal">Edit Account</a></li>
                            <li>
                                <form method="POST" action="handlers/admin/resetAccount.php"
                                    onsubmit="return confirm('Are you sure you want to reset this account?');"
                                    style="display:inline;">
                                    <input type="hidden" name="user_ID" value="<?php echo $user['user_ID']; ?>">
                                    <button type="submit" title="Reset Username and Password to default"
                                        class="dropdown-item">Reset Account</button>
                                </form>
                            </li>
                            <!-- <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editLeaseModal">Edit Lease</a></li> -->
                            <li>
                                <form method="POST"
                                    action="<?php echo $status === 'Deactivated' ? 'handlers/admin/tenantActivateAccount.php' : 'handlers/admin/tenantDeactivateAccount.php'; ?>"
                                    onsubmit="return confirm('Are you sure you want to <?php echo $status === 'Deactivated' ? 'activate' : 'deactivate'; ?> this account?');"
                                    style="display:inline;">
                                    <input type="hidden" name="tenant_id" value="<?php echo $tenant_id ?>">
                                    <button type="submit"
                                        class="dropdown-item text-danger"><?php echo $status === 'Deactivated' ? 'Activate Account' : 'Deactivate Account'; ?></button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <?php include 'views/admin/modal.tenantEditInfo.php'; ?>
    <?php include 'views/admin/modal.editLease.php'; ?>

    <div class="container mt-4">
        <div class="row">
            <div class="col-lg-6">
                <div class="row">
                    <div class="col-lg-5 col-md-12 mt-3">
                        <div class="position-relative">
                            <?php $picDirectory = substr($user['picDirectory'], 6); ?>
                            <img src="<?php echo htmlspecialchars($picDirectory); ?>"
                                style="height: 250px; width: 300px; object-fit: cover;" class="img-fluid shadow"
                                alt="<?php echo htmlspecialchars($tenant['lastName'] . ', ' . $tenant['firstName'] . ' ' . $tenant['middleName']); ?>">
                            <p class="text-center mt-3"><a
                                    href="?page=admin.viewUser&tenant_id=<?php echo $tenant_id; ?>"
                                    class="text-decoration-none">Show Occupants</a></p>
                        </div>
                    </div>
                    <div class="col-lg-7 col-md-12">
                        <h3>Lessee</h3>
                        <hr>
                        <p><strong>Username: </strong><?php echo htmlspecialchars($user['username']); ?></p>
                        <p><strong>Phone Number: </strong><?php echo htmlspecialchars($tenant['phoneNumber']); ?></p>
                        <p><strong>Email Address: </strong><?php echo htmlspecialchars($tenant['emailAddress']); ?></p>
                        <p><strong>Date of Birth:
                            </strong><?php echo htmlspecialchars(date('F j, Y', strtotime($tenant['dateOfBirth']))); ?>
                        </p>
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
                        <p><strong>Status: </strong><span class="h6"><span
                                    class="badge <?php echo $statusClass; ?>"><?php echo $status; ?></span></span></p>
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
                                <tr class="clickable-row"
                                    data-href="?page=admin.viewApartment&apartment=<?php echo htmlspecialchars($lease['apartmentNumber']); ?>">
                                    <th scope="row">Apartment Number</th>
                                    <td class="py-3"><?php echo htmlspecialchars($lease['apartmentNumber']); ?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Start Date</th>
                                    <td class="py-3">
                                        <?php echo htmlspecialchars(date('F j, Y', strtotime($lease['startDate']))); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">End Date</th>
                                    <td class="py-3">
                                        <?php echo htmlspecialchars(date('F j, Y', strtotime($lease['endDate']))); ?>
                                    </td>
                                </tr>
                                <!-- <tr>
                                        <th scope="row">Billing Period</th>
                                        <td class="py-3"><?php echo htmlspecialchars($lease['billingPeriod']); ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Security Deposit</th>
                                        <td class="py-3">₱<?php echo htmlspecialchars($lease['securityDeposit']); ?></td>
                                    </tr> -->
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
                                        <span
                                            class="badge <?php echo $leaseStatusClass; ?>"><?php echo ucfirst($leaseStatus); ?></span>
                                    </td>
                                    <?php if ($lease['reviewedBy'] != 1): ?>
                                    <tr class="clickable-row"
                                        data-href="?page=admin.viewManager&staff_id=<?php echo htmlspecialchars($lease['reviewedBy']); ?>">
                                        <th scope="row">Reviewed by Staff</th>
                                        <td class="py-3"><?php echo htmlspecialchars($lease['reviewedByName']); ?></td>
                                    </tr>
                                <?php endif; ?>
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
        <?php
        // Initialize total
        $totalRent = 0.00;
        $totalLateFees = 0.00;
        $totalPaid = 0.00;
        $totalBalance = 0.00;
        $totalPayments = 0.00;
        $statusColor = '';

        // Iterate through bills to calculate totals
        foreach ($bills as $bill) {
            $totalRent += $bill['amountDue'];
            $totalLateFees += $bill['lateFees'];
            $totalPaid += $bill['amountPaid'];
            $totalBalance += ($bill['amountDue'] + $bill['lateFees']) - $bill['amountPaid'];
            $totalPayments += $bill['amountPaid'] + $bill['lateFees'];
        }

        ?>
        <div class="row mt-4">
            <!-- <h1 class="h3">Assessment</h1>
                <hr> -->
            <div class="col-9">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th style="width: 25%;">Bill Date/Due Date</th>
                                <th class="text-center" style="width: 20%;">Rent</th>
                                <th class="text-center" style="width: 20%;">Overdue Fee</th>
                                <th class="text-center" style="width: 20%;">Paid</th>
                                <th class="text-center" style="width: 20%;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($bills as $bill):
                                switch ($bill['billStatus']) {
                                    case 'Pending':
                                        $statusColor = '#FAB972';
                                        break;
                                    case 'Paid':
                                    case 'Paid by Deposit':
                                        $statusColor = '#84eab3';

                                        break;
                                    case 'Overdue':
                                        $statusColor = '#f69697';
                                        break;
                                    default:
                                        $statusColor = 'white'; // Default color if status is unknown
                                        break;

                                }
                                ?>
                                <tr>
                                    <td class="py-3">
                                        <strong>
                                            <?php
                                            echo date('F j, Y', strtotime($bill['billDate'])) . ' <br> ' . date('F j, Y', strtotime($bill['dueDate']));
                                            ?>
                                        </strong>
                                    </td>
                                    <td class="py-3 text-center"><?php echo number_format($bill['amountDue'], 2); ?></td>
                                    <td class="py-3 text-center"><?php echo number_format($bill['lateFees'], 2); ?></td>
                                    <td class="py-3 text-center"><?php echo number_format($bill['amountPaid'], 2); ?></td>
                                    <td class="py-3 text-center">
                                        <span
                                            style="color: <?php echo $statusColor; ?>;"><?php echo htmlspecialchars($bill['billStatus']); ?></span>
                                    </td>

                                </tr>
                            <?php endforeach; ?>

                            <tr>
                                <td class="fw-bold py-3 text-center">Total</td>
                                <td class="fw-bold py-3 text-center"><?php echo number_format($totalRent, 2); ?></td>
                                <td class="fw-bold py-3 text-center"><?php echo number_format($totalLateFees, 2); ?>
                                </td>
                                <td class="fw-bold py-3 text-center"><?php echo number_format($totalPaid, 2); ?></td>
                                <td class="fw-bold py-3 text-center"></td>
                            </tr>

                            <tr>
                                <td colspan="5" class="text-center text-muted py-1"><strong><small>Rent is calculated on
                                            a monthly basis.</small></strong></td>
                            </tr>
                            <tr>
                                <td colspan="5" class="text-center text-muted py-1"><strong><small>Late fees are added
                                            after a 3-day grace period.</small></strong></td>
                            </tr>
                            <tr>
                                <td colspan="5" class="text-center text-danger py-1"><strong><small>Displayed fees are
                                            subject to change.</small></strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-3">
                <a href="?page=tenant.payment&payment=paymentOptions" class="text-decoration-none">
                    <div class="card text-white bg-success my-3">
                        <div class="card-body">
                            <h5 class="card-title"><i class="bi bi-cash h3" style="margin-right: 15px;"></i> Make
                                Payment</h5>
                        </div>
                    </div>
                </a>
                <div class="card text-white bg-danger my-3">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-cash-stack h3" style="margin-right: 15px;"></i> Overdue
                            Fees</h5>
                        <p class="card-text display-6">₱<?php echo number_format($totalLateFees, 2); ?></p>
                    </div>
                </div>
                <div class="card text-white bg-primary my-3">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-cash-coin h3" style="margin-right: 15px;"></i> Total
                            Payments</h5>
                        <p class="card-text display-6">₱<?php echo number_format($totalPayments, 2); ?></p>
                    </div>
                </div>
                <!-- <div class="card text-white bg-primary my-3">
                        <div class="card-body">
                            <h5 class="card-title"><i class="bi bi-bank h3" style="margin-right: 15px;"></i> Rental Deposit</h5>
                            <p class="card-text display-6">0</p>
                        </div>
                    </div> -->
                <div class="card text-white bg-warning my-3">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-piggy-bank h3" style="margin-right: 15px;"></i> Security
                            Deposit</h5>
                        <p class="card-text display-6">₱<?php echo htmlspecialchars($lease['securityDeposit']); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</main>