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
    include('core/database.php');

    // Check if apartment is set in GET parameters
    if (isset($_GET['apartment'])) {
        $apartmentID = $_GET['apartment'];

        $sql = "
            SELECT *
            FROM apartment
            WHERE apartmentNumber = ?
        ";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $apartmentID);
        $stmt->execute();
        $result = $stmt->get_result();

        // Fetch the row from the result set
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $apartmentNumber = $row['apartmentNumber'];
            $apartmentType = $row['apartmentType'];
            $rentPerMonth = $row['rentPerMonth'];
            $apartmentDimensions = $row['apartmentDimensions'];
            $apartmentAddress = $row['apartmentAddress'];
            $maxOccupants = $row['maxOccupants'];
            $apartmentStatus = $row['apartmentStatus'];
            $availableBy = $row['availableBy'];
            $apartmentPictures = $row['apartmentPictures'];
            $apartmentDescription = $row['apartmentDescription'];
        } else {
            // Handle case where no apartment is found
            $apartmentNumber = "Apartment not found";
            // Set other variables to default or handle as needed
            $apartmentType = "";
            $rentPerMonth = 0.0;
            $apartmentDimensions = "";
            $apartmentAddress = "";
            $maxOccupants = 0;
            $apartmentStatus = "Hidden";
            $availableBy = null;
            $apartmentPictures = "";
            $apartmentDescription = "";
        }
    }
?>

<script>
    const maxOccupants = <?php echo $maxOccupants; ?>;
</script>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4" data-theme="<?php echo $theme; ?>">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h1">Lease Agreement</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="?page=admin.viewApartment&apartment=<?php echo $apartmentNumber; ?>" class="text-secondary" style="text-decoration: none;">
                <button type="button" class="btn btn-outline-secondary d-flex align-items-center gap-1 hover-white">
                    <span class="m-1 h6">Apartment Number: <?php echo $apartmentNumber; ?></span><i class="bi bi-building d-flex align-items-center"></i>
                </button>
            </a>
        </div>
    </div>

    <div class="container mt-4">
        <form id="leaseConfirmationForm" action="handlers/manager/leaseHandler.php" method="POST">
            <!-- HIDDEN -->
            <input type="hidden" name="apartmentNumber" value="<?php echo $apartmentNumber; ?>">
            <input type="hidden" name="rentPerMonth" value="<?php echo $rentPerMonth; ?>">

            <div class="row bg-secondary-subtle rounded pt-3 pb-4">
                <div class="col">
                    <h2>Lessee Information</h2>
                    <p>The Lessee will be the holder of the contract and user account to be created.</p>
                    <hr>
                    <!-- Lessee information -->
                    <div class="occupant mb-3">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="lesseeFirstName" class="form-label">First Name*</label>
                                <input type="text" class="form-control" name="lesseeFirstName" id="lesseeFirstName" placeholder="First Name" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="lesseeMiddleName" class="form-label">Middle Name</label>
                                <input type="text" class="form-control" name="lesseeMiddleName" id="lesseeMiddleName" placeholder="Middle Name">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="lesseeLastName" class="form-label">Last Name*</label>
                                <input type="text" class="form-control" name="lesseeLastName" id="lesseeLastName" placeholder="Last Name" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="dateOfBirth" class="form-label">Date of Birth*</label>
                                    <input type="date" class="form-control" name="lesseeDOB" required max="<?php echo date('Y-m-d'); ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="gender" class="form-label">Gender*</label>
                                    <select class="form-select" name="lesseeGender" required>
                                        <option value="">Select gender</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                        <option value="Prefer not to say">Prefer not to say</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col">
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone Number*</label>
                                    <input type="text" class="form-control" id="phoneNumber1" name="lesseePhone" placeholder="Phone Number" required maxlength="11" pattern="09\d{9}">
                                    <!-- <small id="phoneNumberHelp" class="form-text text-muted">Phone number must start with 09 and have 11 digits in total.</small> -->
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address*</label>
                                    <input type="email" class="form-control" placeholder="Email Address" name="lesseeEmail" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row bg-secondary-subtle rounded pt-3 pb-4 mt-5">
                <div class="col">
                    <h2>Occupant Information</h2>
                    <p>The Lessee may optionally not be an occupant.</p>
                    <hr>
                    <!-- Occupant information -->
                    <div id="occupants">
                        <h5>Occupant 1</h5>
                        <div class="occupant mb-3">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="firstName" class="form-label">First Name*</label>
                                    <input type="text" class="form-control" name="occFirstName[]" placeholder="First Name" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="middleName" class="form-label">Middle Name</label>
                                    <input type="text" class="form-control" name="occMiddleName[]" placeholder="Middle Name">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="lastName" class="form-label">Last Name*</label>
                                    <input type="text" class="form-control" name="occLastName[]" placeholder="Last Name" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="dateOfBirth" class="form-label">Date of Birth*</label>
                                        <input type="date" class="form-control" name="occDOB[]" required max="<?php echo date('Y-m-d'); ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="gender" class="form-label">Gender*</label>
                                        <select class="form-select" name="occGender[]" required>
                                            <option value="">Select gender</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                            <option value="Prefer not to say">Prefer not to say</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">Phone Number*</label>
                                        <input type="text" class="form-control" id="phoneNumber2" name="occPhone[]" placeholder="Phone Number" required maxlength="11" pattern="09\d{9}">
                                        <!-- <small id="phoneNumberHelp" class="form-text text-muted">Phone number must start with 09 and have 11 digits in total.</small> -->
                                    </div>

                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email Address*</label>
                                        <input type="email" class="form-control" name="occEmail[]" placeholder="Email Address" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-secondary" id="addOccupant">Add Occupant</button>
                </div>
            </div>

            <div class="row mt-5 bg-secondary-subtle rounded pt-3 pb-3">
                <h2>Lease Terms</h2>
                <hr>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="startDate" class="form-label">Start Date*</label>
                        <input type="date" class="form-control" name="startDate" id="startDate" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="endDate" class="form-label">End Date*</label>
                        <input type="date" class="form-control" name="endDate" id="endDate" required>
                    </div>
                </div>
                
            </div>
            <div class="row mt-5 bg-secondary-subtle rounded pt-3 pb-3">
                <div class="col">
                    <h2>Payment Terms</h2>
                    <hr>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="billingPeriod" class="form-label">Billing Period*</label>
                            <select class="form-select" name="billingPeriod" id="billingPeriod" required>
                                <option value="Weekly" hidden>Weekly</option>
                                <option value="Monthly" selected>Monthly</option>
                                <option value="Annually" hidden>Annually</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="maxOccupants" class="form-label">Rental Deposit*</label>
                            <input type="number" class="form-control" id="rentalDepositInput" value="<?php echo $rentPerMonth; ?>" name="rentalDeposit" placeholder="Rental Deposit" min="<?php echo $rentPerMonth; ?>" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="maxOccupants" class="form-label">Security Deposit*</label>
                            <input type="number" class="form-control" id="securityDepositInput" value="<?php echo $rentPerMonth; ?>" name="securityDeposit" placeholder="Security Deposit" min="<?php echo $rentPerMonth; ?>" required>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container mt-5">
            <h2>Lease Preview <span class="h6">A4</span></h2>
            <hr>
            <div class="row bg-secondary-subtle py-4 rounded"  id="printableDiv">
                <div class="col">
                    <div>
                        <!-- <div class="">
                            <img src="assets/src/svg/c-banner.svg" alt="c-apartments" style="width: 220px;" class="mx-auto mt-2 d-block">
                        </div> -->
                        <h4 class="fw-bold mt-4 text-center h2">LEASE AGREEMENT</h4>

                        <h5 class="fw-bold">I. PARTIES</h5>
                        <p class="lh-base">This Lease Agreement (hereinafter referred to as the <strong>"Agreement"</strong>) made this <u id="currentDate"> <?php echo date('F d, Y'); ?></u> , by and between <u id="tenantName">___</u> (hereinafter referred to as the <strong>"Tenant"</strong>), and <u>Lance Geo Majorenos Cerenio</u> (hereinafter referred to as the <strong>"Landlord"</strong>)(collectively referred to as the <strong>"Parties"</strong>).</p>
                        
                        <h5 class="fw-bold">II. PREMISES, USE AND OCCUPANCY</h5>
                        <P class="lh-base">The Premises that are to be rented are located at (address) <u><?php echo $apartmentAddress; ?>.</u></P>
                        <p class="lh-base">The Premises to be used only for residential purposes and may be occupied only by the registered occupants.</p>
                        <p class="lh-base">NOW, THEREFORE, FOR AND IN CONSIDERATION of the mutual promises and agreements contained herein, the Tenant agrees to lease the Premises from the Landlord under the following terms and conditions:</p>
                        
                        <h5 class="fw-bold">III. LEASE TERM</h5>
                        <p class="lh-base">The Tenant shall be allowed to occupy the Premises starting on <u id="effectiveDate">___</u>(the <strong>"Effective Date"</strong>), and end on <u id="leaseTerm">___</u>(<strong>"End Date"</strong>)(collectively referred to as the <strong>"Lease Term"</strong>).</p>
                        <p class="lh-base">The Tenant shall vacate the Premises at the end of the Lease Term if the Parties do not agree on a new Lease Agreement or an extension of this Agreement.</p>

                        <h5 class="fw-bold">IV. PAYMENT TERMS</h5>
                        <P class="lh-base">The monthly rent to be paid by the Tenant to the Landlord is <u>₱<?php echo $rentPerMonth; ?>/month</u>. It is to be paid by the Tenant before the first day of every month.</P>
                        <!-- , such that the first rent payment is due on <u><span id="firstRentPaymentDueDate">___</span></u> -->
                        <!-- <p class="lh-base">The method of payment preferred by both parties is/are <u id="preferredPayment">Cash/Gcash/Bank</u>.</p> -->
                        <p class="lh-base">In the event of late payments made by the Tenant, the Landlord is entitled to impose a <u>₱<span id="lateFee">___</span>(10% of monthly rent)</u> fine as <strong>late fee</strong> for each day of delay after a <u>three (3) day grace period.</u></p>
                        <p id="depositParagraph" class="lh-base">Prior to taking occupancy of the Premises, the Tenant will pay the Landlord an amount of <u>₱<span id="rentalDepositSpan">0</span></u> as a <strong>Rental Deposit</strong> as well as an amount of <u>₱<span id="securityDepositSpan">0</span></u> as a <strong>Security Deposit</strong> to cover the cost of any damages suffered by the Premises and cleaning. Such security deposit will be returned to the Tenant upon the end of this Agreement, provided the Premises are left in the same condition as prior to the occupancy.</p>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col text-center">
                        <p class="lh-base">______________________________________</p>
                        <p class="lh-base">Tenant signature over printed name</p>
                    </div>
                    <div class="col text-center">
                        <p class="lh-base">______________________________________</p>
                        <p class="lh-base">Landlord signature over printed name</p>
                    </div>
                </div>
            </div>
            <button class="btn btn-info mt-5 mb-5" onclick="printDiv()">
                <i class="bi bi-printer"></i> Print Lease
            </button>
            <?php //include'views/manager/modal.finalizeLease.php'; ?>

            <!-- Modal structure -->
            <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="confirmationModalLabel">Confirm Lease Finalization</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                Are you sure you want to finalize the lease? Please review all details before proceeding.
                            </div>
                            <div class="mb-3">
                                <label for="managerPassword" class="form-label">Enter your password to proceed</label>
                                <input type="password" class="form-control" id="managerPassword" name="managerPassword" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" form="leaseConfirmationForm" class="btn btn-primary">Confirm</button>
                        </div>
                    </div>
                </div>
            </div>

            <button type="button" class="btn btn-primary mt-5 mb-5" data-bs-toggle="modal" data-bs-target="#confirmationModal">
                <i class="bi bi-check-lg"></i> Finalize Lease
            </button>
        </div>
    </form>
</main>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var phoneNumber1Input = document.getElementById("phoneNumber1");
        var phoneNumber2Input = document.getElementById("phoneNumber2");

        if (phoneNumber1Input) {
            phoneNumber1Input.addEventListener("input", function() {
                // Remove any non-numeric characters
                this.value = this.value.replace(/\D/g, '');

                // Limit length to 11 characters
                if (this.value.length > 11) {
                    this.value = this.value.slice(0, 11);
                }
            });
        }

        if (phoneNumber2Input) {
            phoneNumber2Input.addEventListener("input", function() {
                // Remove any non-numeric characters
                this.value = this.value.replace(/\D/g, '');

                // Limit length to 11 characters
                if (this.value.length > 11) {
                    this.value = this.value.slice(0, 11);
                }
            });
        }
    });
</script>

<script>
    // Function to update deposit paragraph
    function updateDepositParagraph() {
        var rentalDepositValue = document.getElementById("rentalDepositInput").value;
        var securityDepositValue = document.getElementById("securityDepositInput").value;

        document.getElementById("rentalDepositSpan").textContent = rentalDepositValue;
        document.getElementById("securityDepositSpan").textContent = securityDepositValue;
    }

    // Call update function on page load
    updateDepositParagraph();

    // Add event listeners for input changes
    document.getElementById("rentalDepositInput").addEventListener("input", updateDepositParagraph);
    document.getElementById("securityDepositInput").addEventListener("input", updateDepositParagraph);


    document.addEventListener('DOMContentLoaded', function() {
    // Get the current date formatted as Month Day, Year
    const currentDate = new Date();
    const formattedDate = currentDate.toLocaleString('en-US', {
        month: 'long',
        day: 'numeric',
        year: 'numeric'
    });
    document.getElementById('currentDate').innerText = formattedDate;

    // Function to update the tenant name in the agreement
    function updateTenantName() {
        const firstName = document.getElementById('lesseeFirstName').value || '___';
        const middleName = document.getElementById('lesseeMiddleName').value || '';
        const lastName = document.getElementById('lesseeLastName').value || '___';
        const fullName = `${firstName} ${middleName} ${lastName}`.trim();
        document.getElementById('tenantName').innerText = fullName;
    }

    // Function to format the date to Month Day, Year
    function formatDate(date) {
        if (!date) return '___';
        const options = { month: 'long', day: 'numeric', year: 'numeric' };
        return new Date(date).toLocaleDateString('en-US', options);
    }

    // Function to calculate the first rent payment due date (1 month from the effective date)
    function calculateFirstRentPaymentDueDate(effectiveDate) {
        if (!effectiveDate) return '___';
        const date = new Date(effectiveDate);
        date.setMonth(date.getMonth() + 1);
        return formatDate(date);
    }

     // Function to update the preferred payment methods
     function updatePreferredPayment() {
        const paymentMethods = document.querySelectorAll('input[name="paymentMethods"]:checked');
        const selectedMethods = Array.from(paymentMethods).map(method => method.value);

        // Ensure "Cash" is always included
        if (!selectedMethods.includes('Cash')) {
            selectedMethods.unshift('Cash');
        }

        document.getElementById('preferredPayment').innerText = selectedMethods.join('/');
    }

    // Function to update the lease dates and first rent payment due date in the agreement
    function updateLeaseDates() {
        const startDate = document.getElementById('startDate').value;
        const endDate = document.getElementById('endDate').value;
        document.getElementById('effectiveDate').innerText = formatDate(startDate);
        document.getElementById('leaseTerm').innerText = formatDate(endDate);

        // const firstRentPaymentDueDate = calculateFirstRentPaymentDueDate(startDate);
        // document.getElementById('firstRentPaymentDueDate').innerText = firstRentPaymentDueDate;
    }

    // Function to update the late fee based on the monthly rent
    function updateLateFee() {
    const monthlyRent = <?php echo $rentPerMonth; ?>; // Get the monthly rent from the PHP variable
    const lateFee = (monthlyRent * 0.10).toFixed(2); // Calculate 10% of the monthly rent
    document.getElementById('lateFee').innerText = lateFee;
    }

    // Load the values from the form inputs on page load
    updateTenantName();
    updateLeaseDates();
    updateLateFee();
    updatePreferredPayment();

    // Add event listeners to update tenant name and lease dates on input
    document.getElementById('lesseeFirstName').addEventListener('input', updateTenantName);
    document.getElementById('lesseeMiddleName').addEventListener('input', updateTenantName);
    document.getElementById('lesseeLastName').addEventListener('input', updateTenantName);

    // Add event listeners to update lease dates on input
    document.getElementById('startDate').addEventListener('input', updateLeaseDates);
    document.getElementById('endDate').addEventListener('input', updateLeaseDates);

    // Add event listeners to the checkboxes to update the preferred payment methods on selection
    document.querySelectorAll('input[name="paymentMethods"]').forEach(function(checkbox) {
        checkbox.addEventListener('change', updatePreferredPayment);
    });
});
</script>

<script>
    // Function to print the lease
    function printDiv() {
        var printContents = document.getElementById('printableDiv').innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }

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
                            <input type="text" class="form-control" name="occFirstName[]" placeholder="First Name" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="middleName" class="form-label">Middle Name</label>
                            <input type="text" class="form-control" name="occMiddleName[]" placeholder="Middle Name">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="lastName" class="form-label">Last Name*</label>
                            <input type="text" class="form-control" name="occLastName[]" placeholder="Last Name" required>
                        </div>
                    </div>
    
                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label for="dateOfBirth" class="form-label">Date of Birth*</label>
                                <input type="date" class="form-control" name="occDOB[]" required max="<?php echo date('Y-m-d'); ?>">
                            </div>
                            <div class="mb-3">
                                <label for="gender" class="form-label">Gender*</label>
                                <select class="form-select" name="occGender[]" required>
                                    <option value="">Select gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Prefer not to say">Prefer not to say</option>
                                </select>
                            </div>
                        </div>
                    
                        <div class="col">
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="text" class="form-control" name="occPhone[]" maxlength="11" placeholder="Phone Number" pattern="09\d{9}">
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" placeholder="Email Address" name="occEmail[]">
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-danger remove-occupant">Remove</button>
                </div>
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
