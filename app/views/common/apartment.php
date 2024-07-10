<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<?php
  session_start();

    // Debugging: Check session values
    //   print_r($_SESSION);
    //   print_r($_GET);
    //   print_r($_POST);
?>
<head>
    <script src="../../assets/dist/js/color-modes.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apartment Information</title>
    <link rel="icon" href="../../assets/src/svg/c-logo.svg">
    <link href="../../assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../assets/src/css/themes.css" rel="stylesheet">
    <style>
        body {
            padding-top: 56px; /* Adjust based on the height of your navbar */
        }
        .glass-navbar {
            background: rgba(0, 0, 0, 0.3); /* White background with 70% opacity */
            backdrop-filter: blur(0.5px); /* Blur effect */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Subtle shadow */
        }
        #banner {
             max-height: 50px; /* Minimized logo size */
             transition: 0.8s; /* Smooth transition */
         }
        input[disabled] {
            color: #6c757d; /* Neutral gray for text color */
            cursor: not-allowed; /* Show disabled cursor */
        }
        html {
            scroll-behavior: smooth !important;
        }
    </style>
</head>
<body class="bg-body-tertiary">
    <?php include ('../../core/themes.php') ?>
    <?php include ('../../core/database.php') ?>

    <?php
    // Fetch apartment data based on apartmentNumber
        if (isset($_GET['apartment'])) {
            $apartmentNumber = $_GET['apartment'];
        } else {
            echo "Apartment number is not specified.";
        }
        $sql = "SELECT * FROM apartment WHERE apartmentNumber = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $apartmentNumber);
        $stmt->execute();
        $result = $stmt->get_result();
        $apartment = $result->fetch_assoc();
        $conn->close();
    ?>

    <nav class="navbar navbar-light fixed-top justify-content-center align-items-center bg-dark-subtle border-bottom">
        <a class="navbar-brand logo" href="landing.php">
            <img id="banner" src="../../assets/src/svg/c.svg" alt="Website Logo" class="img-fluid">
        </a>
    </nav>
    

    <main class="container-xl container mt-3 pt-3 px-0">
        <div class="container" style="padding-top: 10px; padding-bottom: 25px;">
            <div class="text-center">
                <span class="">
                    <a href="../../views/common/landing.php" class="text-decoration-none text-secondary" title="Back to Home Page">Home</a> / 
                    <a href="../../views/common/browse.php" class="text-decoration-none text-secondary" title="Back to Browse Apartments">Browse</a> / 
                    <span class="text-secondary"><?php echo $apartment['apartmentType']; ?></span>
                </span>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-12 mb-4">
                    <img src="<?php echo $apartment['apartmentPictures']; ?>" style="width: 100%;" class="img-fluid shadow" alt="<?php echo $apartment['apartmentType']; ?>">
                </div>
                <div class="col-lg-4 col-md-12">
                    <h1><?php echo $apartment['apartmentType']; ?></h1>
                    <hr>
                    <h5>₱<?php echo number_format($apartment['rentPerMonth'], 2); ?> / month</h5>
                    <p><?php echo $apartment['apartmentDescription']; ?></p>
                    <p><strong>Max Occupants:</strong> <?php echo $apartment['maxOccupants']; ?></p>
                    <p><strong>Address:</strong> <?php echo $apartment['apartmentAddress']; ?></p>
                    <p><strong>Apartment Dimensions:</strong> <?php echo $apartment['apartmentDimensions']; ?></p><br>
                    <h3>Availability</h3><hr>
                    <?php 
                            $availableBy = !empty($apartment['availableBy']) ? date('F j, Y', strtotime($apartment['availableBy'])) : 'N/A';
                            $leaseEndDate = !empty($lease['endDate']) ? date('F j, Y', strtotime($lease['endDate'])) : 'N/A';
                            
                            switch($apartment['apartmentStatus']) {
                                case 'Available':
                                    echo '<div class="p-3 mb-2 bg-success-subtle text-success-emphasis rounded">This apartment is available for rent</div>';
                                    break;
                                case 'Occupied':
                                    echo '<div class="p-3 mb-2 bg-danger-subtle text-danger-emphasis rounded">This apartment is currently occupied<br>Will be available by ' . $leaseEndDate . '</div>';
                                    break;
                                case 'Maintenance':
                                    echo '<div class="p-3 mb-2 bg-warning-subtle text-warning-emphasis rounded">This apartment is currently under maintenance<br>Will be available by ' . $availableBy . '</div>';
                                    break;
                                case 'Hidden':
                                    echo '<div class="p-3 mb-2 bg-secondary-subtle text-secondary-emphasis rounded">This apartment is hidden from view</div>';
                                    break;
                                default:
                                    echo '<div class="p-3 mb-2 bg-secondary-subtle text-secondary-emphasis rounded">Unknown apartment status</div>';
                            }
                        ?>
                    
                    <div class="mt-5">
                        <h3 id="makeRequest">Make a Request</h3>
                        <hr>
                        <form action="../../views/tenant/leaseProposal.php?apartment=<?php echo $apartmentNumber; ?>" method="POST">
                            <div class="mb-3">
                                <label for="termsOfStay" class="form-label">Term of Stay*</label>
                                <select class="form-select" id="termsOfStay" name="termsOfStay" required onchange="setEndDateMin()">
                                    <option value="short">Short term (< 6 months)</option>
                                    <option value="long">Long term (>= 6 months)</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="startDate" class="form-label">Start Date*</label>
                                <input type="date" class="form-control" id="startDate" name="startDate" required
                                    min="<?php echo date('Y-m-d'); ?>" value="<?php echo date('Y-m-d'); ?>">
                            </div>
                            <div class="mb-3">
                                <label for="endDate" class="form-label">End Date*</label>
                                <input type="date" class="form-control" id="endDate" name="endDate" required>
                            </div>
                            <div class="mb-3">
                                <label for="billingPeriod" class="form-label">Billing Period*</label>
                                <select class="form-select" id="billingPeriod" name="billingPeriod" required>
                                    <option value="monthly">Monthly</option>
                                    <option value="weekly" hidden>Weekly</option>
                                    <option value="annually" hidden>Annually</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="numOccupants" class="form-label">Number of Occupants*</label>
                                <input type="number" class="form-control" id="numOccupants" name="numOccupants" min="1" max="<?php echo $apartment['maxOccupants']; ?>" value="1" required>
                            </div>
                            <div class="mb-3">
                                <label for="message" class="form-label">Message</label>
                                <textarea class="form-control" id="message" name="message" rows="3"></textarea>
                            </div><br>
                            <button type="submit" class="btn btn-primary" style="width: 100%; height: 50px;">Proceed to Tenant Information Filling</button>
                        </form>
                    </div><br>
                    <div class="container">
                        <p class="text-centered">Contact us: <a href="mailto:info@tenantmanagement.com">info@tenantmanagement.com</a> | <a href="tel:+1234567890">+963 412 2347</a></p>
                    </div>
                </div>
            </div>
        </div>    
    </main>
    <script>
        // // Function to handle scroll event
        window.addEventListener('scroll', function() {
            var banner = document.getElementById('banner');
            var navbar = document.getElementsByClassName('glass-navbar')[0]; // Select the first element

            if (window.scrollY > 80) {
                banner.style.maxHeight = '35px'; // Adjusted size when scrolled down
                // navbar.style.background = 'none'; // Remove background when scrolled down
                navbar.style.backdropFilter = 'none'; // Remove backdrop filter when scrolled down
                navbar.style.boxShadow = 'none'; // Remove box shadow when scrolled down
            } else {
                banner.style.maxHeight = '50px'; // Default size when not scrolled down
                navbar.style.background = 'rgba(0, 0, 0, 0.3)'; // Default background color
                navbar.style.backdropFilter = 'blur(0.5px)'; // Restore backdrop filter when not scrolled down
                navbar.style.boxShadow = '0 4px 6px rgba(0, 0, 0, 0.1)'; // Restore box shadow when not scrolled down
            }
        });
    </script>
    <script>
        // Select all form inputs
        const formInputs = document.querySelectorAll('input, select, textarea');

        // Function to save form data to localStorage
        function saveFormData() {
            formInputs.forEach(input => {
                localStorage.setItem(input.id, input.value);
            });
        }

        // Event listeners to save data on input change
        formInputs.forEach(input => {
            input.addEventListener('input', saveFormData);
        });

        // Function to load form data from localStorage
        function loadFormData() {
            formInputs.forEach(input => {
                const savedValue = localStorage.getItem(input.id);
                if (savedValue) {
                    input.value = savedValue;
                }
            });
        }

        // Call loadFormData on page load
        window.addEventListener('load', loadFormData);

        // Clear localStorage on form submit
        // const form = document.querySelector('form');

        // form.addEventListener('submit', function() {
        //     localStorage.clear(); // Clear all stored form data
        // });
        </script>
        <script>
            function setEndDateMin() {
                var termsOfStay = document.getElementById('termsOfStay').value;
                var endDateInput = document.getElementById('endDate');
    
                // Get current date in YYYY-MM-DD format
                var today = new Date();
                var todayFormatted = today.toISOString().split('T')[0];
    
                // Calculate minimum date based on termsOfStay
                var minDate;
                if (termsOfStay === 'short') {
                    // Set minimum date to 1 month from today
                    var oneMonthLater = new Date();
                    oneMonthLater.setMonth(oneMonthLater.getMonth() + 1);
                    minDate = oneMonthLater.toISOString().split('T')[0];
                } else if (termsOfStay === 'long') {
                    // Set minimum date to 6 months from today
                    var sixMonthsLater = new Date();
                    sixMonthsLater.setMonth(sixMonthsLater.getMonth() + 6);
                    minDate = sixMonthsLater.toISOString().split('T')[0];
                }
    
                // Set min attribute of the endDate input
                endDateInput.setAttribute('min', minDate);
    
                // Reset the value to ensure it's within the new min/max range
                endDateInput.value = minDate;
            }
    
            // Call setEndDateMin initially to set initial min/max based on default selection
            window.addEventListener('load', setEndDateMin);
            document.getElementById('termsOfStay').addEventListener('change', setEndDateMin);
        </script>
    


    <script src="../../assets/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
