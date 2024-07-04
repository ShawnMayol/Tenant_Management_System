<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Staff</h1>
    </div>
    <?php
        $search = '';
    ?>

    <!-- Search Form -->
    <form class="mb-4" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="GET">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Search staff..." name="search" value="<?php echo htmlspecialchars($search); ?>">
            <button class="btn btn-primary" type="submit">Search</button>
        </div>
    </form>

    <div class="table-responsive">
    <?php
    // Include database connection file
    include 'core/database.php';

    // Process search query if submitted
    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['search'])) {
        // Sanitize and store search query
        $search = mysqli_real_escape_string($conn, $_GET['search']);
    }

    // Query to fetch staff data with search filter, excluding admin
    $sql = "SELECT * FROM staff WHERE staffRole != 'Admin' AND CONCAT(lastName, ' ', firstName, ' ', middleName) LIKE '%$search%'";

    $result = $conn->query($sql);

    // Check if there are any records
    if ($result->num_rows > 0) {
        echo '<table class="table table-striped table-hover">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>#</th>';
        echo '<th>Name</th>';
        echo '<th>Date of Birth</th>';
        echo '<th>Phone Number</th>';
        echo '<th>Email</th>';
        echo '<th>Role</th>';
        echo '<th>Status</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        // Output data of each row
        $count = 1;
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $count++ . '</td>';
            echo '<td>' . $row['lastName'] . ', ' . $row['firstName'] . ' ' . $row['middleName'] . '</td>';
            echo '<td>' . $row['dateOfBirth'] . '</td>';
            echo '<td>' . $row['phoneNumber'] . '</td>';
            echo '<td>' . $row['emailAddress'] . '</td>';
            echo '<td>' . $row['staffRole'] . '</td>';
            echo '<td>' . $row['staffStatus'] . '</td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
    } else {
        echo 'No staff found.';
    }

    // Close database connection
    $conn->close();
    ?>

    </div>

    <!-- Pagination -->
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <li class="page-item disabled">
                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            <li class="page-item active" aria-current="page">
                <a class="page-link" href="#">1 <span class="sr-only">(current)</span></a>
            </li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item">
                <a class="page-link" href="#">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
</main>
