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

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h1">Tenants</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="input-group me-2">
                <input type="text" class="form-control" id="filterInput" placeholder="Search Tenant..." oninput="searchTenants()">
                <span class="input-group-text">
                    <i class="bi bi-search d-flex align-items-center"></i>
                </span> 
            </div>

            <!-- <a href="#" class="text-secondary" id="addManagerButton" data-bs-toggle="modal" data-bs-target="#addManagerModal" title="Add Manager" style="text-decoration: none;">
                <button type="button" class="btn btn-outline-secondary d-flex align-items-center gap-1 hover-white">
                    <span class="m-1">Add User</span><i class="bi bi-plus-square icon-adjust m-1"></i>
                </button>
            </a> -->
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

            // Query to fetch active lessee data
            $sql = "
                SELECT t.tenant_ID, t.firstName, t.lastName, t.middleName, l.leaseStatus, u.username
                FROM tenant t
                JOIN lease l ON t.lease_ID = l.lease_ID
                LEFT JOIN user u ON t.tenant_ID = u.tenant_ID
                WHERE t.tenantType = 'Lessee'
                ORDER BY l.lease_ID DESC
            ";

            $result = $conn->query($sql);

            // Check if there are any records
            if ($result->num_rows > 0) {
                echo '<table class="table table-striped table-hover">';
                echo '<thead class="h5">';
                echo '<tr>';
                echo '<th style="width: 10%;">#</th>';
                echo '<th style="width: 29%;">Name</th>';
                echo '<th style="width: 40%;">Username</th>';
                echo '<th style="width: 21%;">Lease Status</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';

                // Output data of each row
                $count = 1;
                while ($row = $result->fetch_assoc()) {
                    // Determine the status class based on leaseStatus
                    $statusClass = '';
                    if ($row['leaseStatus'] === 'active') {
                        $statusClass = 'bg-success';
                    } elseif ($row['leaseStatus'] === 'expired') {
                        $statusClass = 'bg-secondary';
                    } elseif ($row['leaseStatus'] === 'terminated') {
                        $statusClass = 'bg-danger';
                    }

                    echo '<tr class="clickable-row" data-href="?page=manager.viewUser&tenant_id=' . $row['tenant_ID'] . '">';
                    echo '<td class="py-3">' . $count++ . '</td>';
                    echo '<td class="py-3">' . $row['lastName'] . ', ' . $row['firstName'] . ' ' . $row['middleName'] . '</td>';
                    echo '<td class="py-3">' . $row['username'] . '</td>';
                    echo '<td class="py-3"><span class="badge ' . $statusClass . '">' . $row['leaseStatus'] . '</span></td>';
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
