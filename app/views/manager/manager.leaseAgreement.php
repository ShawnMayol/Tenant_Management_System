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
    /* Custom styles for print */
    @media print {
        body * {
            visibility: hidden;
        }
        #printableDiv, #printableDiv * {
            visibility: visible;
        }
        #printableDiv {
            position: absolute;
            left: 0;
            top: 0;
        }
    }
</style>

<?php
include('core/database.php'); // Make sure to include the database connection

// Check if request_id is set in GET parameters
if (isset($_GET['request_id'])) {
    $requestID = $_GET['request_id'];

    // Query to fetch request details along with the apartment details
    $sql = "
        SELECT r.*, 
               a.apartmentType, a.rentPerMonth, a.apartmentAddress, a.apartmentStatus, a.apartmentPictures,
               a.maxOccupants,  -- Fetch the max occupants
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
            'occupiedAvailableBy' => $request['occupiedAvailableBy'],
            'maxOccupants' => $request['maxOccupants']  // Add max occupants to the array
        ];

        // Store request details
        $tenantDetails = [
            'firstName' => $request['firstName'],
            'middleName' => $request['middleName'],
            'lastName' => $request['lastName'],
            'gender' => $request['gender'],
            'dateOfBirth' => $request['dateOfBirth'],
            'phone' => $request['phoneNumber'],
            'email' => $request['emailAddress']
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

<script>
    // Pass the max occupants to JavaScript
    const maxOccupants = <?php echo $apartment['maxOccupants']; ?>;
</script>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4" data-theme="<?php echo $theme; ?>">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <div class="container">
            <div class="row">
                <div class="col-auto ps-2 pe-3">
                    <a href="?page=manager.viewRequest&request_id=<?php echo $requestID ?>" class="icon-wrapper" style="text-decoration: none;">
                        <i class="bi bi-arrow-left-circle text-secondary h2 icon-default"></i>
                        <i class="bi bi-arrow-left-circle-fill text-secondary h2 icon-hover"></i>
                    </a>
                </div>
                <div class="col">
                    <h1 class="h1 m-0">Lease Agreement</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="container mt-4">
        <div class="row bg-secondary-subtle rounded pt-3 pb-4">
            <div class="col">
                <h2>Occupant(s) Information</h2>
                <hr>
                <!-- Occupant information -->
                <form id="occupantsForm">
                    <div id="occupants">
                        <div class="occupant mb-3">
                            <h5>Lessee</h5>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="firstName" class="form-label">First Name*</label>
                                    <input type="text" class="form-control" name="firstName[]" value="<?php echo $tenantDetails['firstName']; ?>" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="middleName" class="form-label">Middle Name</label>
                                    <input type="text" class="form-control" name="middleName[]" value="<?php echo $tenantDetails['middleName']; ?>">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="lastName" class="form-label">Last Name*</label>
                                    <input type="text" class="form-control" name="lastName[]" value="<?php echo $tenantDetails['lastName']; ?>" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="dateOfBirth" class="form-label">Date of Birth*</label>
                                        <input type="date" class="form-control" name="dateOfBirth[]" value="<?php echo $tenantDetails['dateOfBirth']; ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="gender" class="form-label">Gender*</label>
                                        <select class="form-select" name="gender[]" required>
                                            <option value="">Select gender</option>
                                            <option value="Male" <?php if($tenantDetails['gender'] == 'Male') echo 'selected'; ?>>Male</option>
                                            <option value="Female" <?php if($tenantDetails['gender'] == 'Female') echo 'selected'; ?>>Female</option>
                                            <option value="Prefer not to say" <?php if($tenantDetails['gender'] == 'Prefer not to say') echo 'selected'; ?>>Prefer not to say</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">Phone*</label>
                                        <input type="text" class="form-control" name="phone[]" value="<?php echo $tenantDetails['phone']; ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email*</label>
                                        <input type="email" class="form-control" name="email[]" value="<?php echo $tenantDetails['email']; ?>" required>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <button type="button" class="btn btn-secondary" id="addOccupant">Add Occupant</button>
                </form>
            </div>
        </div>

        <div class="row mt-5 bg-secondary-subtle rounded pt-3 pb-3">
            <h2>Lease Terms</h2>
            <hr>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="termsOfStay" class="form-label">Terms of Stay*</label>
                    <select class="form-select" name="termsOfStay" id="termsOfStay" required>
                        <option value="short_term" <?php if($termsOfStay == 'short_term') echo 'selected'; ?>>Short Term (&lt; 6 months)</option>
                        <option value="long_term" <?php if($termsOfStay == 'long_term') echo 'selected'; ?>>Long Term (&gt; 6 months)</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="startDate" class="form-label">Start Date*</label>
                    <input type="date" class="form-control" name="startDate" id="startDate" value="<?php echo $startDate; ?>" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="endDate" class="form-label">End Date*</label>
                    <input type="date" class="form-control" name="endDate" id="endDate" value="<?php echo $endDate; ?>" required>
                </div>
            </div>
            
        </div>
        <div class="row mt-5 bg-secondary-subtle rounded pt-3 pb-3">
            <div class="col">
                <h2>Payment Terms</h2>
                <hr>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="billingPeriod" class="form-label">Billing Period*</label>
                        <select class="form-select" name="billingPeriod" id="billingPeriod" required>
                            <option value="weekly" <?php if($billingPeriod == 'weekly') echo 'selected'; ?> hidden>Weekly</option>
                            <option value="monthly" <?php if($billingPeriod == 'monthly') echo 'selected'; ?>>Monthly</option>
                            <option value="annually" <?php if($billingPeriod == 'annually') echo 'selected'; ?> hidden>Annually</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="numOccupants" class="form-label">Security Deposit*</label>
                        <input type="number" class="form-control" name="numOccupants" id="numOccupants" value="<?php echo $numOccupants; ?>" min="1" max="<?php echo $apartment['maxOccupants']; ?>" required>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container mt-5">
        <div class="row">
            <h2>Lease Preview</h2>
            <hr>
            <div class="col bg-secondary-subtle py-4 rounded">
                <div id="printableDiv">
                    <img src="assets/src/svg/c-banner.svg" alt="c-apartments" style="width: 300px;" class="mx-auto mt-2 d-block">
                    <h4 class="fw-bold mt-4 text-center">LEASE AGREEMENT</h4>

                    <h5 class="fw-bold">I. PARTIES</h5>
                    <p class="lh-base">This Lease Agreement (hereinafter referred to as the <strong>"Agreement"</strong>) made this ___, by and between ___ (hereinafter referred to as the <strong>"Tenant"</strong>), and ___ (hereinafter referred to as the <strong>"Landlord"</strong>)(collectively reffered to as the <strong>"Parties"</strong>).</p>
                    <p class="lh-base">NOW, THEREFORE, FOR AND IN CONSIDERATION of the mutual promises and agreements contained herein, the Tenant agrees to lease the Premises from the Landlord under the following terms and conditions:</p>
                    
                    <h5 class="fw-bold">II. LEASE TERM</h5>
                    <p>The tenant shall be allowed to occupy the Premises starting on ___, 20___ (the <strong>"Effective Date"</strong>), and end on ___, 20___ (<strong>"Lease Term"</strong>).</p>
                    <p>The tenant shall vacate the Premises at the end of the Lease Term if the Parties do not agree on a new Lease Agreement or an extension of this Agreement.</p>

                    <h5 class="fw-bold">III. PREMISES, USE AND OCCUPANCY</h5>
                    <P>The Premises that are to be rented are located at (address) ___.</P>
                    <p>The Premises to be used only for residential purposes and may be occupied only by the registered occupants.</p>

                    <h5 class="fw-bold">IV. PAYMENT TERMS</h5>
                    <P>The monthly rent to be paid by the Tenant to the Landlord is ___. It is to be paid by the Tenant before the first day of every month, such that the first rent payment is due on ___.</P>
                    <p>The method of payment preferred by both parties is ___.</p>
                    <p>In the event of late payments made by the Tenant, the Landlord is entitled to impose a ___ fine as <strong>late fee</strong> for each day of delay after a three (3) day grace period.</p>
                    <p>Prior to taking occupancy of the Premises, the Tenant will pay the Landlord an amount of ____ as a security deposit to cover the cost of any damages suffered by the premises and cleaning. Such security deposit will be returned to the Tenant upon the end of this Agreement, provided the Premises are left in the same condition as prior to the occupancy.</p>
                </div>
            </div>
        </div>
        <button class="btn btn-primary mt-5 mb-5" onclick="printDiv()">Print Lease Preview</button>
    </div>
</main>

<script>
    // Function to print the lease
    function printDiv() {
        var printContents = document.getElementById('printableDiv').innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }

    // Add occupant functionality
    $(document).ready(function() {
        let occupantCount = 1; // Lessee is the first occupant
        
        // Function to add a new occupant form
        $('#addOccupant').click(function() {
            if (occupantCount < maxOccupants) {
                let occupantForm = `
                    <div class="occupant mb-3">
                        <hr>
                        <h5>Occupant ${occupantCount + 1}</h5>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="firstName" class="form-label">First Name*</label>
                                <input type="text" class="form-control" name="firstName[]" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="middleName" class="form-label">Middle Name</label>
                                <input type="text" class="form-control" name="middleName[]">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="lastName" class="form-label">Last Name*</label>
                                <input type="text" class="form-control" name="lastName[]" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="dateOfBirth" class="form-label">Date of Birth*</label>
                                    <input type="date" class="form-control" name="dateOfBirth[]" required>
                                </div>
                                <div class="mb-3">
                                    <label for="gender" class="form-label">Gender*</label>
                                    <select class="form-select" name="gender[]" required>
                                        <option value="">Select gender</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                        <option value="Prefer not to say">Prefer not to say</option>
                                    </select>
                                </div>
                            </div>
                        
                            <div class="col">
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone*</label>
                                    <input type="text" class="form-control" name="phone[]" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email*</label>
                                    <input type="email" class="form-control" name="email[]" required>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-danger remove-occupant">Remove</button>
                `;
                $('#occupants').append(occupantForm);
                occupantCount++;
            } else {
                alert(`The maximum number of occupants for this apartment is ${maxOccupants}.`);
            }
        });

        // Function to remove an occupant form
        $('#occupants').on('click', '.remove-occupant', function() {
            $(this).closest('.occupant').remove();
            occupantCount--;
            // Update the heading of remaining occupants
            $('.occupant').each(function(index) {
                if (index > 0) {
                    $(this).find('h5').text(`Occupant ${index + 1}`);
                }
            });
        });
    });
</script>
