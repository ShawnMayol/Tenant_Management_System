<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

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
include('core/database.php'); // Make sure to include the database connection

// Check if request_id is set in GET parameters
if (isset($_GET['request_id'])) {
    $requestID = $_GET['request_id'];

    // Query to fetch request details along with the availability dates
    $sql = "
        SELECT r.*, 
               a.apartmentType, a.rentPerMonth, a.apartmentAddress, a.apartmentStatus, a.apartmentPictures,
               a.availableBy AS maintenanceAvailableBy, a.apartmentNumber,
               (SELECT l.endDate FROM lease l WHERE l.apartmentNumber = a.apartmentNumber AND l.leaseStatus = 'approved' ORDER BY l.endDate DESC LIMIT 1) AS occupiedAvailableBy
        FROM request r
        LEFT JOIN apartment a ON r.apartmentNumber = a.apartmentNumber
        WHERE r.request_ID = ?
    ";

    // Prepare and execute the statement
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $requestID);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if a request was found
    if ($result->num_rows > 0) {
        // Fetch the request details
        $request = $result->fetch_assoc();
        
        // Store details in variables
        $termsOfStay = $request['termsOfStay'];
        $startDate = $request['startDate'];
        $endDate = $request['endDate'];
        $billingPeriod = $request['billingPeriod'];
        $numOccupants = $request['occupants'];
        $message = $request['message'];
        $apartment = [
            'apartmentType' => $request['apartmentType'],
            'rentPerMonth' => $request['rentPerMonth'],
            'apartmentAddress' => $request['apartmentAddress'],
            'apartmentStatus' => $request['apartmentStatus'],
            'apartmentPictures' => $request['apartmentPictures'],
            'maintenanceAvailableBy' => $request['maintenanceAvailableBy'],
            'apartmentNumber' => $request['apartmentNumber'],
            'occupiedAvailableBy' => $request['occupiedAvailableBy']
        ];
    } else {
        echo 'Request not found.';
        exit;
    }
} else {
    echo 'No request ID provided.';
    exit;
}

// Determine the availability date based on the apartment status
$availableBy = '';
if ($apartment['apartmentStatus'] === 'Maintenance') {
    $availableBy = $apartment['maintenanceAvailableBy'];
} elseif ($apartment['apartmentStatus'] === 'Occupied') {
    $availableBy = $apartment['occupiedAvailableBy'];
}
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4" data-theme="<?php echo $theme; ?>">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <div class="container">
            <div class="row">
                <div class="col-auto ps-2 pe-3">
                    <a href="?page=manager.requests" class="icon-wrapper" style="text-decoration: none;">
                        <i class="bi bi-arrow-left-circle text-secondary h2 icon-default"></i>
                        <i class="bi bi-arrow-left-circle-fill text-secondary h2 icon-hover"></i>
                    </a>
                </div>
                <div class="col">
                    <h1 class="h1 m-0">Request Details</h1>
                </div>
                <div class="col-auto pe-5">
                    <a href="handlers/manager/updateRequestStatus.php?request_id=<?php echo $requestID; ?>&current_status=<?php echo $request['requestStatus']; ?>" title="Pin this request" class="icon-wrapper" style="text-decoration: none;">
                        <div class="link">
                            <i id="pin-icon-<?php echo $requestID; ?>" class="bi <?php echo $request['requestStatus'] == 'Pinned' ? 'bi-pin-angle-fill' : 'bi-pin-angle'; ?> text-secondary h2 icon-default-2"></i>
                        </div>
                    </a>

                </div>
            </div>
        </div>
    </div>
    

    <div class="container mt-4 pt-2">
        <div class="row">
            <!-- Request column -->
            <div class="col-lg-5 mb-4">
                <a href="?page=manager.viewApartment&apartment=<?php echo $apartment['apartmentNumber'];?>">
                    <img src="<?php echo substr($apartment['apartmentPictures'], 6); ?>" style="width: 100%;" class="img-fluid shadow" alt="<?php echo $apartment['apartmentType']; ?>">
                </a>
                <h2 class="pt-4">Apartment Information</h2>
                <hr>
                <div class="row">
                    <div class="col-md-6 mt-2">
                        <h1 class="h3"><?php echo $apartment['apartmentType']; ?></h1>
                        <h5>₱<?php echo number_format($apartment['rentPerMonth'], 2); ?> / month</h5>
                        <p><?php echo $apartment['apartmentAddress']; ?></p>
                    </div>
                    <div class="col-md-6">
                        <?php 
                            switch($apartment['apartmentStatus']) {
                                case 'Available':
                                    echo '<div class="py-4 rounded mt-3 bg-success-subtle text-success-emphasis text-center">Available</div>';
                                    break;
                                case 'Occupied':
                                    echo '<div class="py-4 rounded mt-3 bg-danger-subtle text-danger-emphasis text-center">Occupied<br>
                                    Available by ' . ($availableBy ? date('F j, Y', strtotime($availableBy)) : 'Unknown') . '</div>';
                                    break;
                                case 'Maintenance':
                                    echo '<div class="py-4 rounded mt-3 bg-warning-subtle text-warning-emphasis text-center">Under Maintenance<br>
                                    Available by ' . ($availableBy ? date('F j, Y', strtotime($availableBy)) : 'Unknown') . '</div>';
                                    break;
                                default:
                                    echo 'Unknown status';
                            }
                        ?>
                    </div>
                </div>
                <h2 class="pt-4">Request Information</h2>
                <dl class="row border rounded">
                    <dt class="col-sm-6 py-2">Term of Stay</dt>
                    <dd class="col-sm-6 py-2"><?php echo $termsOfStay == 'short' ? 'Short term (< 6 months)' : 'Long term (>= 6 months)'; ?></dd>
                    <hr>
                    <dt class="col-sm-6 py-1">Start Date</dt>
                    <dd class="col-sm-6 py-1"><?php echo $startDate; ?></dd>
                    <hr>
                    <dt class="col-sm-6 py-1">End Date</dt>
                    <dd class="col-sm-6 py-1"><?php echo $endDate; ?></dd>
                    <hr>
                    <dt class="col-sm-6 py-1">Billing Period</dt>
                    <dd class="col-sm-6 py-1">
                        <?php 
                        if($billingPeriod == 'monthly') {
                            echo 'Monthly';
                        } elseif($billingPeriod == 'weekly') {
                            echo 'Weekly';
                        } elseif($billingPeriod == 'annually') {
                            echo 'Annually';
                        }
                        ?>
                    </dd>
                    <hr>
                    <dt class="col-sm-6 py-1">Number of Occupants</dt>
                    <dd class="col-sm-6 py-1"><?php echo $numOccupants; ?></dd>
                </dl>
                <div class="row">
                    <h4>Message</h4>
                    <div class="col-12 message-section border rounded pt-3">
                        <p><?php echo nl2br(htmlspecialchars($message)); ?></p>
                    </div>
                </div>
                <!-- <div class="mt-4">
                    <a href="../../views/common/apartment.php?apartment=<?php //echo $apartmentNumber; ?>#makeRequest" class="btn btn-secondary shadow">Back</a>
                </div> -->
            </div>

            <!-- Form column -->
            <div class="col-lg-7 ps-4">
                <h2>Personal Information</h2>
                <!-- <p>Personal information of the requestee.</p> -->
                <hr>
                <!-- Tenant details form -->
                <form action="../../handlers/tenant/requestHandler.php" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="firstName" class="form-label">First Name</label>
                            <input type="text" class="form-control py-2" id="firstName" name="firstName" value="<?php echo $request['firstName']; ?>" disabled>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="middleName" class="form-label">Middle Name</label>
                            <input type="text" class="form-control py-2" id="middleName" name="middleName" value="<?php echo $request['middleName']; ?>" disabled>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="lastName" class="form-label">Last Name</label>
                            <input type="text" class="form-control py-2" id="lastName" name="lastName" value="<?php echo $request['lastName']; ?>" disabled>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="dateOfBirth" class="form-label">Date of Birth</label>
                        <input type="date" class="form-control py-2" id="dateOfBirth" name="dateOfBirth" value="<?php echo $request['dateOfBirth']; ?>" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="gender" class="form-label">Gender</label>
                        <select class="form-select py-2" id="gender" name="gender" disabled>
                            <option value="">Select gender</option>
                            <option value="Male" <?php if($request['gender'] == 'Male') echo 'selected'; ?>>Male</option>
                            <option value="Female" <?php if($request['gender'] == 'Female') echo 'selected'; ?>>Female</option>
                            <option value="Prefer not to say" <?php if($request['gender'] == 'Prefer not to say') echo 'selected'; ?>>Prefer not to say</option>
                        </select>
                    </div>
                    <br>
                    <!-- Contact information -->
                    <h2>Contact Information</h2>
                    <!-- <p>Reach out to the tenant.</p> -->
                    <hr>
                    <div class="mb-3">
                        <label for="emailAddress" class="form-label">Email Address</label>
                        <input type="email" class="form-control py-2" id="emailAddress" name="emailAddress" value="<?php echo $request['emailAddress']; ?>" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="phoneNumber" class="form-label">Phone Number</label>
                        <input type="tel" class="form-control py-2" id="phoneNumber" name="phoneNumber" value="<?php echo $request['phoneNumber']; ?>" disabled>
                    </div>
                    <br>
                   
                    <!-- Display uploaded pictures -->
                    <h2>Valid Documents</h2>
                    <hr>
                    <div class="mb-3">
                        <label for="identificationPic" class="form-label">Personal Identification</label><br>
                        <?php if (!empty($request['identificationPic'])): ?>
                            <img src="<?php echo substr($request['identificationPic'], 6); ?>" class="img-fluid mb-3" alt="Identification Pic">
                        <?php endif; ?>
                    </div>
                    
                    <div class="mb-3">
                        <label for="addressPic" class="form-label">Address/Residency</label><br>
                        <?php if (!empty($request['addressPic'])): ?>
                            <img src="<?php echo substr($request['addressPic'], 6); ?>" class="img-fluid mb-3" alt="Address Pic">
                        <?php endif; ?>
                    </div>
                    
                    <div class="mb-3">
                        <label for="incomePic" class="form-label">Proof of Income</label><br>
                        <?php if (!empty($request['incomePic'])): ?>
                            <img src="<?php echo substr($request['incomePic'], 6); ?>" class="img-fluid mb-3" alt="Income Pic">
                        <?php endif; ?>
                    </div>
                    
                    <div class="mb-3">
                        <label for="othersPic" class="form-label">Additional Documents</label><br>
                        <?php if (!empty($request['othersPic'])): ?>
                            <img src="<?php echo substr($request['othersPic'], 6); ?>" class="img-fluid mb-3" alt="Other Documents Pic">
                        <?php endif; ?>
                    </div>



                    <button class="btn btn-primary mb-5" type="submit" name="submit" value="submit">Proceed to Lease</button>
                </form>
            </div>
        </div>
    </div>
</main>

<?php $conn->close(); ?>
