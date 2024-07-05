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
                <div class="card-body">
                    <div>
                        <img src="<?= htmlspecialchars($row['apartmentPictures']) ?>" alt="Apartment Image">
                    </div>
                    <div>
                        <h5 class="card-title">Apartment <?= htmlspecialchars($row['apartmentNumber']) ?></h5>
                    </div>
                    <div>
                        <p class="card-text">Type: <?= htmlspecialchars($row['apartmentType']) ?></p>
                    </div>
                    <div>
                        <p class="card-text">Rent: PHP<?= htmlspecialchars($row['rentPerMonth']) ?></p>
                    </div>
                    <div>
                        <p class="card-text">Max Occupants: <?= htmlspecialchars($row['maxOccupants']) ?></p>
                    </div>
                    <div>
                        <p class="card-text">Current Occupants: <?= htmlspecialchars($row['numOccupants']) ?></p>
                    </div>
                    <div>
                        <p class="card-text">Description: <?= htmlspecialchars($row['description']) ?></p>
                    </div>
                    <div>
                        <p class="card-text">Billing Period: <?= htmlspecialchars($row['billingPeriod'])?></p>
                    </div>
                    <div>
                        <p class="card-text">Lease Start Date: <?= htmlspecialchars($row['startDate']) ?></p>
                    </div>
                    <div>
                        <p class="card-text">Lease End Date: <?= htmlspecialchars($row['endDate']) ?></p>
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
