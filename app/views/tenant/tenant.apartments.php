<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
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
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <div class="card mb-3">
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="a<?= htmlspecialchars($row['apartmentPictures']) ?>" style="width: 100%;" class="img-fluid shadow" alt="<?= htmlspecialchars($row['apartmentType']) ?>">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <p class="card-text"><strong>Type:</strong> <?= htmlspecialchars($row['apartmentType']) ?></p>
                            <p class="card-text"><strong>Dimensions:</strong> <?= htmlspecialchars($row['apartmentDimensions']) ?></p>
                            <p class="card-text"><strong>Address:</strong> <?= htmlspecialchars($row['apartmentAddress']) ?></p>
                            <p class="card-text"><strong>Rent:</strong> PHP<?= htmlspecialchars($row['rentPerMonth']) ?></p>
                            <p class="card-text"><strong>Max Occupants:</strong> <?= htmlspecialchars($row['maxOccupants']) ?></p>
                            <p class="card-text"><strong>Description:</strong> <?= htmlspecialchars($row['apartmentDescription']) ?></p>
                            <p class="card-text"><strong>Billing Period:</strong> <?= htmlspecialchars($row['billingPeriod']) ?></p>
                            <p class="card-text"><strong>Lease Start Date:</strong> <?= htmlspecialchars($row['startDate']) ?></p>
                            <p class="card-text"><strong>Lease End Date:</strong> <?= htmlspecialchars($row['endDate']) ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    } else {
        echo "No tenant ID found.";
    }
    ?>
</main>
