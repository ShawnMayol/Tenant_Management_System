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
    .btn-container {
            display: flex;
            justify-content: flex-end;
        }
        .btn-container button {
            margin-left: 10px;
        }
</style>

<?php
include('core/database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_status']) && isset($_POST['request_id'])) {
    $request_id = $_POST['request_id'];
    $new_status = $_POST['new_status'];
    $staff_id = $_SESSION['staff_id'];

    $completionDate = null;


    if ($new_status === 'Resolved') {
        $completionDate = date('Y-m-d');
    }

    $sql = "UPDATE maintenancerequests SET status = ?, handledBy = ?, completionDate = ? WHERE request_ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sisi", $new_status, $staff_id, $completionDate, $request_id);

    if ($stmt->execute()) {
    } else {
        $error_message = 'Failed to update status.';
    }

    $stmt->close();
}

if (isset($_GET['request_id'])) {
    $request_id = $_GET['request_id'];

    // Query maintenance request information
    $requestSql = "
        SELECT mr.*, mr.handledBy , a.apartmentType, s.firstName AS staffFirstName, s.lastName AS staffLastName
        FROM maintenancerequests mr
        LEFT JOIN apartment a ON mr.apartmentNumber = a.apartmentNumber
        LEFT JOIN staff s ON mr.handledBy = s.staff_ID
        WHERE mr.request_ID = ?
    ";

    $requestStmt = $conn->prepare($requestSql);
    $requestStmt->bind_param("i", $request_id);
    $requestStmt->execute();
    $requestResult = $requestStmt->get_result();
    $request = $requestResult->fetch_assoc();

    if (!$request) {
        echo "Request not found.";
        exit;
    }

    // Query tenant information
    $tenant_id = $request['tenant_ID'];
    $tenantSql = "SELECT * FROM tenant WHERE tenant_ID = ?";
    $tenantStmt = $conn->prepare($tenantSql);
    $tenantStmt->bind_param("i", $tenant_id);
    $tenantStmt->execute();
    $tenantResult = $tenantStmt->get_result();
    $tenant = $tenantResult->fetch_assoc();

    // Query user information for the tenant
    $userSql = "SELECT u.*, u.picDirectory 
                FROM user u
                WHERE u.tenant_ID = ?";
    $userStmt = $conn->prepare($userSql);
    $userStmt->bind_param("i", $tenant_id);
    $userStmt->execute();
    $userResult = $userStmt->get_result();
    $user = $userResult->fetch_assoc();

    // Handle connection close
    $conn->close();
} else {
    echo "Request ID is not specified.";
    exit;
}
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
                    <a href="?page=admin.maintenance" class="icon-wrapper" style="text-decoration: none;">
                        <i class="bi bi-arrow-left-circle text-secondary h2 icon-default"></i>
                        <i class="bi bi-arrow-left-circle-fill text-secondary h2 icon-hover"></i>
                    </a>
                </div>
                <div class="col">
                    <h1 class="h1 m-0">Request Information</h1>
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
                    <div class="col-lg-7 col-md-12">
                        <h3>Tenant</h3>
                        <hr>
                        <p><strong>Username: </strong><?php echo htmlspecialchars($user['username']); ?></p>
                        <p><strong>Phone Number: </strong><?php echo htmlspecialchars($tenant['phoneNumber']); ?></p>
                        <p><strong>Email Address: </strong><?php echo htmlspecialchars($tenant['emailAddress']); ?></p>
                        <p><strong>Date of Birth: </strong><?php echo htmlspecialchars(date('F j, Y', strtotime($tenant['dateOfBirth']))); ?></p>
                        <p><strong>Age: </strong>
                            <?php
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

                        switch ($user['userStatus']) {
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
                        <p><strong>Status: </strong><span class="h6"><span class="badge <?php echo $statusClass; ?>"><?php echo htmlspecialchars($user['userStatus']); ?></span></span></p>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <h3>Request Information</h3>
                <hr>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <tbody>
                            <tr class="clickable-row" data-href="?page=admin.viewApartment&apartment=<?php echo htmlspecialchars($request['apartmentNumber']); ?>">
                                <th scope="row">Apartment</th>
                                <td class="py-3"><?php echo htmlspecialchars($request['apartmentType']); ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Request Date</th>
                                <td class="py-3"><?php echo htmlspecialchars(date('F j, Y', strtotime($request['requestDate']))); ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Maintenance Type</th>
                                <td class="py-3"><?php echo htmlspecialchars($request['maintenanceType']); ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Status</th>
                                <td class="py-3">
                                    <?php
                                    $status = htmlspecialchars($request['status']);
                                    $statusClass = '';
                                    switch ($status) {
                                        case 'Pending':
                                            $statusClass = 'bg-warning text-dark';
                                            break;
                                        case 'In Progress':
                                            $statusClass = 'bg-primary text-light';
                                            break;
                                        case 'Resolved':
                                            $statusClass = 'bg-success text-light';
                                            break;
                                        default:
                                            $statusClass = 'bg-light text-dark'; // Default or handle other statuses as needed
                                    }
                                    ?>
                                    <span class="badge <?php echo $statusClass; ?>"><?php echo ucfirst($status); ?></span>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Description</th>
                                <td class="py-3"><?php echo nl2br(htmlspecialchars($request['description'])); ?></td>
                            </tr>
                            <?php if ($request['status'] == 'Resolved'): ?>
                                <tr>
                                    <th scope="row">Completion Date</th>
                                    <td class="py-3">
                                        <?php
                                        if ($request['completionDate']) {
                                            echo htmlspecialchars(date('F j, Y', strtotime($request['completionDate'])));
                                        } else {
                                            echo "Not yet completed";
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <?php if ($request['handledBy'] != 1): ?>
                                    <tr class="clickable-row" data-href="?page=admin.viewManager&staff_id=<?php echo htmlspecialchars($request['handledBy']); ?>">
                                        <th scope="row">Handled By</th>
                                        <td class="py-3">
                                            <?php
                                            if ($request['handledBy']) {
                                                echo htmlspecialchars($request['staffFirstName'] . ' ' . $request['staffLastName']);
                                            } else {
                                                echo "Not assigned";
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <div class="container">
    <div class="row">
        <div class="col-md-12 btn-container">
            <?php if ($request['status'] === 'Pending'): ?>
                <button id="inProgressButton" class="btn btn-primary" onclick="confirmUpdateStatus('In Progress')">
                    <i class="bi bi-hourglass-split h5 me-2"></i> Mark as In Progress
                </button>
                <button id="resolvedButton" class="btn btn-success" style="display: none;" onclick="confirmUpdateStatus('Resolved')">
                    <i class="bi bi-check-circle h5 me-2"></i> Mark as Resolved
                </button>
            <?php elseif ($request['status'] === 'In Progress'): ?>
                <button id="inProgressButton" class="btn btn-primary" style="display: none;" onclick="confirmUpdateStatus('In Progress')">
                    <i class="bi bi-hourglass-split h5 me-2"></i> Mark as In Progress
                </button>
                <button id="resolvedButton" class="btn btn-success" onclick="confirmUpdateStatus('Resolved')">
                    <i class="bi bi-check-circle h5 me-2"></i> Mark as Resolved
                </button>
            <?php else: ?>
                <button id="inProgressButton" class="btn btn-primary" style="display: none;" onclick="confirmUpdateStatus('In Progress')">
                    <i class="bi bi-hourglass-split h5 me-2"></i> Mark as In Progress
                </button>
                <button id="resolvedButton" class="btn btn-success" style="display: none;" onclick="confirmUpdateStatus('Resolved')">
                    <i class="bi bi-check-circle h5 me-2"></i> Mark as Resolved
                </button>
            <?php endif; ?>
        </div>
    </div>
</div>

        </div>
    </div>
</main>

<script>
    function confirmUpdateStatus(status) {
        var message = (status === 'In Progress') 
            ? 'Are you sure you want to mark this request as In Progress?' 
            : 'Are you sure you want to mark this request as Resolved?';

        if (confirm(message)) {
            updateStatus(status);
        }
    }

    function updateStatus(status) {
        var requestId = <?php echo json_encode($request_id); ?>;
        var formData = new FormData();
        formData.append('new_status', status);
        formData.append('request_id', requestId);

        fetch(window.location.href, {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            if (status === 'In Progress') {
                document.getElementById('inProgressButton').style.display = 'none';
                document.getElementById('resolvedButton').style.display = 'inline-block';
            } else if (status === 'Resolved') {
                document.getElementById('resolvedButton').style.display = 'none';
            }

            window.location.reload();
        })
        .catch(error => console.error('Error:', error));
    }
</script>