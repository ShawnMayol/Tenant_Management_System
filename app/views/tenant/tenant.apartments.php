<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <style>
        /* Custom CSS to remove padding around card image */
        .sidebar, .offcanvas-md {
        z-index: 1000; /* Lower z-index for the sidebar */
        }

        .card:hover {
            cursor: pointer;
        }

        .card-body {
            padding: 0;
        }

        .apartment-info {
            padding: 12px;
        }

        .custom-modal-dialog {
            max-width: 80%; /* Set maximum width of the modal */
            margin: auto; /* Center horizontally */
        }

        .custom-modal-content {
            width: 100%; /* Ensure modal content fills the dialog */
        }

        .custom-modal-body {
            padding: 20px; /* Add padding to the modal body */
        }

        .custom-img {
            width: 100%;
            height: auto; /* Adjust maximum height of the image */
            object-fit: cover;
        }
    </style>

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Apartments</h1>
    </div>

    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "tms";

    // Create a PDO connection
    $pdo = new PDO("mysql:host=$servername;dbname=$database;charset=utf8mb4", $username, $password);

    // Retrieve tenant ID from the session
    $loggedInUserID = $_SESSION['user_id'] ?? null;
    $tenantID = null;

    if ($loggedInUserID) {
        // Fetch the tenant_id based on logged-in user ID
        $query = "SELECT tenant_ID FROM user WHERE user_ID = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$loggedInUserID]);
        $tenantID = $stmt->fetchColumn();
    } else {
        echo "User not logged in.";
        exit();
    }

    if ($tenantID) {
        // Fetch apartment data for the logged-in tenant
        $sql = "
            SELECT a.*, l.*
            FROM apartment a
            JOIN lease l ON a.apartmentNumber = l.apartmentNumber
            WHERE l.tenant_ID = :tenantID
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['tenantID' => $tenantID]);

        // Display apartment information
        echo '<div class="row">';
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <div class="col-lg-3 col-sm-6 mb-4">
                <div class="card">
                    <!-- Trigger modal on click -->
                    <div class="card-body" data-bs-toggle="modal" data-bs-target="#modal<?= htmlspecialchars($row['apartmentNumber']) ?>">
                        <img src="a<?= htmlspecialchars($row['apartmentPictures']) ?>" class="card-img-top" alt="<?= htmlspecialchars($row['apartmentType']) ?>">
                        <div class="apartment-info">
                            <div><?= htmlspecialchars($row['apartmentAddress']) ?></div><br>
                            <div class="d-flex justify-content-between">
                                <div><?= htmlspecialchars($row['apartmentDimensions']) ?></div>
                                <div><strong><?= htmlspecialchars($row['rentPerMonth']) ?> /Month</strong></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="modal<?= htmlspecialchars($row['apartmentNumber']) ?>" tabindex="-1" aria-labelledby="modal<?= htmlspecialchars($row['apartmentNumber']) ?>Label" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered custom-modal-dialog">
                    <div class="modal-content custom-modal-content">
                        <div class="modal-header">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body custom-modal-body">
                            <div class="row">
                                <div class="col-lg-8">
                                    <img src="a<?= htmlspecialchars($row['apartmentPictures']) ?>" class="img-fluid mb-3 custom-img" alt="<?= htmlspecialchars($row['apartmentType']) ?>">
                                </div>
                                <div class="col-lg-4">
                                    <h1><?= htmlspecialchars($row['apartmentType']) ?></h1><hr>
                                    <p><strong>Rent:</strong> <?= htmlspecialchars($row['rentPerMonth']) ?> /Month</p>
                                    <p><strong>Dimensions:</strong> <?= htmlspecialchars($row['apartmentDimensions']) ?></p>
                                    <p><strong>Address:</strong> <?= htmlspecialchars($row['apartmentAddress']) ?></p>
                                    <p><strong>Max Occupants:</strong> <?= htmlspecialchars($row['maxOccupants']) ?></p>
                                    <p><strong>Description:</strong> <?= htmlspecialchars($row['apartmentDescription']) ?></p><br>
                                    <h3>Lease Information</h3><hr>
                                    <p><strong>Start Date:</strong> <?= htmlspecialchars($row['startDate']) ?></p>
                                    <p><strong>End Date:</strong> <?= htmlspecialchars($row['endDate']) ?></p>
                                    <p><strong>Billing Period:</strong> <?= htmlspecialchars($row['billingPeriod']) ?></p>
                                    <!-- Add more lease details as needed -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
        echo '</div>';
    } else {
        echo "No tenant ID found.";
    }
    ?>
</main>