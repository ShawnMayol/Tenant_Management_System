    <!DOCTYPE html>
<html lang="en" data-bs-theme="auto">
<?php
  session_start();

    // Debugging: Check session values
    //   print_r($_SESSION);
    //   print_r($_GET);
    //   print_r($_POST);

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Sanitize and assign POST variables
        
        $termsOfStay = htmlspecialchars($_POST['termsOfStay']);
        $startDate = htmlspecialchars($_POST['startDate']);
        $endDate = htmlspecialchars($_POST['endDate']);
        $billingPeriod = htmlspecialchars($_POST['billingPeriod']);
        $numOccupants = htmlspecialchars($_POST['numOccupants']);
        $message = htmlspecialchars($_POST['message']);
    } else {
        // Redirect to the form page if the request method is not POST
        header("Location: ../../views/common/browse.php");
        exit();
    }
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
         html {
            scroll-behavior: smooth;
        }
        .message-section {
            word-wrap: break-word;
        }
    </style>
</head>
<body class="bg-body-tertiary">
    <?php include ('../../core/themes.php') ?>
    <?php include ('../../core/database.php') ?>

    <?php
        // Fetch apartment data based on apartmentNumber
        if (isset($_GET['apartment'])) {
            $apartmentNumber = htmlspecialchars($_GET['apartment']);
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

    <nav class="navbar navbar-light fixed-top bg-dark-subtle shadow justify-content-center align-items-center glass-navbar">
        <a class="navbar-brand logo" href="../../views/common/landing.php">
            <img id="banner" src="../../assets/src/svg/c.svg" alt="Website Logo" class="img-fluid">
        </a>
    </nav>

    <main class="col-md-12 col-lg-12 px-md-4">
        <div class="container" style="padding-top: 40px;">
            <div class="text-center">
                <span class="">
                    <a href="../../views/common/landing.php" class="text-decoration-none text-secondary" title="Back to home page">Home</a> / 
                    <a href="../../views/common/browse.php" class="text-decoration-none text-secondary" title="Back to Browse Apartments">Browse</a> / 
                    <a href="../../views/common/apartment.php?apartment=<?php echo $apartmentNumber; ?>" class="text-decoration-none text-secondary" title="Back to <?php echo $apartment['apartmentType']; ?>"><?php echo $apartment['apartmentType']; ?></a> /
                    <span class="text-secondary">Tenant Information</span>
                </span>
            </div>
        </div>

        <div class="container mt-4 pt-2">
            <div class="row">
                <!-- Request column -->
                <div class="col-lg-5 mb-4">
                    <img src="<?php echo $apartment['apartmentPictures']; ?>" style="width: 100%;" class="img-fluid shadow" alt="<?php echo $apartment['apartmentType']; ?>">
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
                            $availableBy = !empty($apartment['availableBy']) ? date('F j, Y', strtotime($apartment['availableBy'])) : 'N/A';
                            
                            switch($apartment['apartmentStatus']) {
                                case 'Available':
                                    echo '<div class="p-3 mb-2 bg-success-subtle text-success-emphasis rounded">This apartment is available for rent</div>';
                                    break;
                                case 'Occupied':
                                    echo '<div class="p-3 mb-2 bg-danger-subtle text-danger-emphasis rounded text-center">Occupied<br>Available by ' . $availableBy . '</div>';
                                    break;
                                case 'Maintenance':
                                    echo '<div class="p-3 mb-2 bg-warning-subtle text-warning-emphasis rounded text-center">Under maintenance<br>Available by ' . $availableBy . '</div>';
                                    break;
                                case 'Hidden':
                                    echo '<div class="p-3 mb-2 bg-secondary-subtle text-secondary-emphasis rounded">This apartment is hidden from view</div>';
                                    break;
                                default:
                                    echo '<div class="p-3 mb-2 bg-secondary-subtle text-secondary-emphasis rounded">Unknown apartment status</div>';
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
                    <div class="mt-4">
                        <a href="../../views/common/apartment.php?apartment=<?php echo $apartmentNumber; ?>#makeRequest" class="btn btn-secondary shadow">Back</a>
                    </div>
                </div>
                    
                <!-- Form column -->
                <div class="col-lg-7 ps-4">
                    <h2>Tenant Information</h2>
                    <p>Enter your personal information so that we may get to know you better.</p>
                    <hr>
                    <!-- Tenant details form -->
                    <form action="../../handlers/tenant/requestHandler.php" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="firstName" class="form-label">First Name*</label>
                            <input type="text" class="form-control py-2" id="firstName" name="firstName" placeholder="First Name" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="middleName" class="form-label">Middle Name</label>
                            <input type="text" class="form-control py-2" id="middleName" name="middleName" placeholder="Middle Name">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="lastName" class="form-label">Last Name*</label>
                            <input type="text" class="form-control py-2" id="lastName" name="lastName" placeholder="Last Name" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="dateOfBirth" class="form-label">Date of Birth*</label>
                        <input type="date" class="form-control py-2" id="dateOfBirth" name="dateOfBirth" placeholder="mm/dd/yyyy" required>
                    </div>
                    <div class="mb-3">
                        <label for="gender" class="form-label">Gender*</label>
                        <select class="form-select py-2" id="gender" name="gender" required>
                            <option value="">Select gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Prefer not to say">Prefer not to say</option>
                        </select>
                    </div>
                    <br>
                    <!-- Contact information -->
                    <h2>Contact Information</h2>
                    <p>Enter your contact information so that we may be able to get back to you.</p>
                    <hr>
                    <div class="mb-3">
                        <label for="emailAddress" class="form-label">Email Address*</label>
                        <input type="email" class="form-control py-2" id="emailAddress" name="emailAddress" placeholder="juandelacruz@domain.com" required>
                    </div>
                    <div class="mb-3">
                        <label for="phoneNumber" class="form-label">Phone Number*</label>
                        <input type="tel" class="form-control py-2" id="phoneNumber" name="phoneNumber" placeholder="Phone Number" required>
                    </div>
                    <br>
                    <!-- Valid documents upload -->
                    <h2>Valid Documents</h2>
                    <p>Upload a picture or scan of your <a href="#" data-toggle="modal" data-target="#validDocumentsModal" style="text-decoration: none;">valid documents</a> to assist with your lease.</p>
                    <hr>

                    <div class="mb-3">
                        <label for="identificationPic" class="form-label">Personal Identification*</label>
                        <input type="file" class="form-control py-2" id="identificationPic" name="identificationPic" accept="image/*" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="addressPic" class="form-label">Address/Residency*</label>
                        <input type="file" class="form-control py-2" id="addressPic" name="addressPic" accept="image/*" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="incomePic" class="form-label">Proof of Income*</label>
                        <input type="file" class="form-control py-2" id="incomePic" name="incomePic" accept="image/*" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="othersPic" class="form-label">Additional Documents*</label>
                        <input type="file" class="form-control py-2" id="othersPic" name="othersPic" accept="image/*" required>
                    </div>
                        
                        <!-- Hidden fields -->
                        <input type="hidden" name="apartmentNumber" value="<?php echo htmlspecialchars($_GET['apartment']); ?>">
                        <input type="hidden" name="termsOfStay" value="<?php echo htmlspecialchars($_POST['termsOfStay']); ?>">
                        <input type="hidden" name="startDate" value="<?php echo htmlspecialchars($_POST['startDate']); ?>">
                        <input type="hidden" name="endDate" value="<?php echo htmlspecialchars($_POST['endDate']); ?>">
                        <input type="hidden" name="billingPeriod" value="<?php echo htmlspecialchars($_POST['billingPeriod']); ?>">
                        <input type="hidden" name="numOccupants" value="<?php echo htmlspecialchars($_POST['numOccupants']); ?>">
                        <input type="hidden" name="message" value="<?php echo htmlspecialchars($_POST['message']); ?>">
                        
                        <!-- Submit button -->
                        <button type="submit" class="btn btn-primary shadow mt-2 mb-5">Submit Tenant Information</button>
                    </form>
                </div>
            </div>
        </div>
        <?php include 'modal.validDocuments.php'; ?>
    </main>
    <script>
        // Function to handle scroll event
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
        // Clear localStorage on form submit
        const form = document.querySelector('form');

        form.addEventListener('submit', function() {
            localStorage.clear(); // Clear all stored form data
        });
    </script>
    <script src="../../assets/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
