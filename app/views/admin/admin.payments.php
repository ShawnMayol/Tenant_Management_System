<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

<style>
    .clickable-row {
        cursor: pointer;
    }
</style>

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

<script>
    function searchTenants() {
        // Get the input field and its value
        var input = document.getElementById("filterInput");
        var filter = input.value.toLowerCase();

        // Get the table and table rows
        var table = document.querySelector(".table tbody");
        var rows = table.getElementsByTagName("tr");

        // Loop through all table rows, and hide those that don't match the search query
        for (var i = 0; i < rows.length; i++) {
            var nameCell = rows[i].getElementsByTagName("td")[1]; // Assuming the name is in the second column (index 1)
            if (nameCell) {
                var nameText = nameCell.textContent || nameCell.innerText;
                if (nameText.toLowerCase().includes(filter)) {
                    rows[i].style.display = ""; // Show row if the name matches the filter
                } else {
                    rows[i].style.display = "none"; // Hide row if it doesn't match
                }
            }       
        }
    }
</script>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h1">Payments</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
        <div class="input-group me-2">
                <input type="text" class="form-control" id="filterInput" placeholder="Search Tenant..." oninput="searchTenants()">
                <span class="input-group-text">
                    <i class="bi bi-search d-flex align-items-center"></i>
                </span> 
            </div>
            <div class="dropdown me-2">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="statusDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    Status
                </button>
                <ul class="dropdown-menu" aria-labelledby="statusDropdown">
                    <li><a class="dropdown-item" href="#" onclick="filterStatus('userStatus', 'All')">All</a></li>
                    <li><a class="dropdown-item" href="#" onclick="filterStatus('userStatus', 'Online')">Online</a></li>
                    <li><a class="dropdown-item" href="#" onclick="filterStatus('userStatus', 'Offline')">Offline</a></li>
                    <li><a class="dropdown-item" href="#" onclick="filterStatus('userStatus', 'Deactivated')">Deactivated</a></li>
                </ul>
            </div>
            <div class="dropdown me-2">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="leaseStatusDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    Lease Status
                </button>
                <ul class="dropdown-menu" aria-labelledby="leaseStatusDropdown">
                    <li><a class="dropdown-item" href="#" onclick="filterStatus('leaseStatus', 'All')">All</a></li>
                    <li><a class="dropdown-item" href="#" onclick="filterStatus('leaseStatus', 'Active')">Active</a></li>
                    <li><a class="dropdown-item" href="#" onclick="filterStatus('leaseStatus', 'Expired')">Expired</a></li>
                    <li><a class="dropdown-item" href="#" onclick="filterStatus('leaseStatus', 'Terminated')">Terminated</a></li>
                </ul>
            </div>
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="orderDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    Order by Start Date
                </button>
                <ul class="dropdown-menu" aria-labelledby="orderDropdown">
                    <li><a class="dropdown-item" href="#" onclick="orderTable('asc')">Ascending</a></li>
                    <li><a class="dropdown-item" href="#" onclick="orderTable('desc')">Descending</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="table-responsive">
            <?php
            // Include database connection file
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "tms";

            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Query to fetch lessee data
            $sql = "
            SELECT t.tenant_ID, t.firstName, t.lastName, t.middleName, l.leaseStatus, u.userStatus, u.picDirectory
            FROM tenant t
            JOIN lease l ON t.lease_ID = l.lease_ID
            JOIN user u ON t.tenant_ID = u.tenant_ID
            WHERE t.tenantType = 'Lessee' AND l.leaseStatus = 'Active'
            ORDER BY l.lease_ID DESC
            ";

            $result = $conn->query($sql);

            // Check if there are any records
            if ($result->num_rows > 0) {
                echo '<table class="table table-striped table-hover">';
                echo '<thead class="h5">';
                echo '<tr>';
                echo '<th style="width: 12%;"></th>';
                echo '<th style="width: 30%;">Name</th>';
                echo '<th style="width: 35%;">Status</th>';
                echo '<th style="width: 21%;">Lease</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';

                // Output data of each row
                $count = 1;
                while ($row = $result->fetch_assoc()) {
                    // Determine the status class based on leaseStatus
                    $leaseStatusClass = '';
                    if ($row['leaseStatus'] === 'Active') {
                        $leaseStatusClass = 'bg-success';
                    } elseif ($row['leaseStatus'] === 'Expired') {
                        $leaseStatusClass = 'bg-secondary';
                    } elseif ($row['leaseStatus'] === 'Terminated') {
                        $leaseStatusClass = 'bg-danger';
                    }

                    // Determine the status class based on userStatus
                    $userStatusClass = '';
                    if ($row['userStatus'] === 'Online') {
                        $userStatusClass = 'bg-success';
                    } elseif ($row['userStatus'] === 'Offline') {
                        $userStatusClass = 'bg-secondary';
                    } elseif ($row['userStatus'] === 'Deactivated') {
                        $userStatusClass = 'bg-danger';
                    }

                    echo '<tr class="clickable-row" data-href="?page=admin.viewBilling&tenant_id=' . $row['tenant_ID'] . '">';
                    echo '<td class="py-3">';
                    echo '<div style="width: 30px; height: 30px; border-radius: 50%; overflow: hidden; margin-left: 20px;">';
                    echo '<img src="' . htmlspecialchars(substr($row['picDirectory'], 6)) . '" class="img-fluid rounded-circle me-3" style="width: 30px; height: 30px; object-fit: cover;" alt="Staff Picture">';
                    echo '</div>';
                    echo '</td>';
                    echo '<td class="py-3">' . $row['lastName'] . ', ' . $row['firstName'] . ' ' . $row['middleName'] . '</td>';
                    echo '<td class="py-3 h6"><span class="badge ' . $userStatusClass . '">' . $row['userStatus'] . '</span></td>';
                    echo '<td class="py-3 h6"><span class="badge ' . $leaseStatusClass . '">' . $row['leaseStatus'] . '</span></td>';
                    echo '</tr>';
                }

                echo '</tbody>';
                echo '</table>';
            } else {
                echo 'No active lessees found.';
            }

            $conn->close();
            ?>
        </div>
    </div>

</main>
