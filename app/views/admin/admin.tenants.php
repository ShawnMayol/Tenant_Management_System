<!-- Include Bootstrap CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

<style>
    .clickable-row {
        cursor: pointer;
    }
</style>

<!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script> -->

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
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "tms";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "
            SELECT t.tenant_ID, t.firstName, t.lastName, t.middleName, l.leaseStatus, l.startDate, u.userStatus, u.picDirectory
            FROM tenant t
            JOIN lease l ON t.lease_ID = l.lease_ID
            JOIN user u ON t.tenant_ID = u.tenant_ID
            WHERE t.tenantType = 'Lessee'
            ORDER BY l.lease_ID DESC
            ";

            $result = $conn->query($sql);

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

                while ($row = $result->fetch_assoc()) {
                    $leaseStatusClass = '';
                    if ($row['leaseStatus'] === 'Active') {
                        $leaseStatusClass = 'bg-success';
                    } elseif ($row['leaseStatus'] === 'Expired') {
                        $leaseStatusClass = 'bg-secondary';
                    } elseif ($row['leaseStatus'] === 'Terminated') {
                        $leaseStatusClass = 'bg-danger';
                    }

                    $userStatusClass = '';
                    if ($row['userStatus'] === 'Online') {
                        $userStatusClass = 'bg-success';
                    } elseif ($row['userStatus'] === 'Offline') {
                        $userStatusClass = 'bg-secondary';
                    } elseif ($row['userStatus'] === 'Deactivated') {
                        $userStatusClass = 'bg-danger';
                    }

                    echo '<tr class="clickable-row" data-href="?page=admin.viewUser&tenant_id=' . $row['tenant_ID'] . '">';
                    echo '<td class="py-3">';
                    echo '<div style="width: 30px; height: 30px; border-radius: 50%; overflow: hidden; margin-left: 20px;">';
                    echo '<img src="' . htmlspecialchars(substr($row['picDirectory'], 6)) . '" class="img-fluid rounded-circle me-3" style="width: 30px; height: 30px; object-fit: cover;" alt="Staff Picture">';
                    echo '</div>';
                    echo '</td>';
                    echo '<td class="py-3">' . $row['lastName'] . ', ' . $row['firstName'] . ' ' . $row['middleName'] . '</td>';
                    echo '<td class="py-3 h6 userStatus"><span class="badge ' . $userStatusClass . '">' . $row['userStatus'] . '</span></td>';
                    echo '<td class="py-3 h6 leaseStatus"><span class="badge ' . $leaseStatusClass . '">' . $row['leaseStatus'] . '</span></td>';
                    echo '<td class="py-3 startDate" style="display:none;">' . $row['startDate'] . '</td>';
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

<!-- Include Bootstrap JS -->

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var rows = document.querySelectorAll('.clickable-row');
        rows.forEach(function(row) {
            row.addEventListener('click', function() {
                window.location.href = row.dataset.href;
            });
        });
    });

    function searchTenants() {
        var input = document.getElementById("filterInput");
        var filter = input.value.toLowerCase();
        var table = document.querySelector(".table tbody");
        var rows = table.getElementsByTagName("tr");

        for (var i = 0; i < rows.length; i++) {
            var nameCell = rows[i].getElementsByTagName("td")[1];
            if (nameCell) {
                var nameText = nameCell.textContent || nameCell.innerText;
                if (nameText.toLowerCase().includes(filter)) {
                    rows[i].style.display = "";
                } else {
                    rows[i].style.display = "none";
                }
            }       
        }
    }

function filterStatus(statusType, filterValue) {
        var table = document.querySelector(".table tbody");
        var rows = table.getElementsByTagName("tr");

        for (var i = 0; i < rows.length; i++) {
            var statusCell = rows[i].getElementsByClassName(statusType)[0];
            if (statusCell) {
                var statusText = statusCell.textContent || statusCell.innerText;
                if (filterValue === 'All' || statusText.includes(filterValue)) {
                    rows[i].style.display = "";
                } else {
                    rows[i].style.display = "none";
                }
            }
        }
    }

    function orderTable(orderType) {
        var table = document.querySelector(".table tbody");
        var rows = Array.from(table.getElementsByTagName("tr"));

        rows.sort(function(a, b) {
            var dateA = new Date(a.querySelector(".startDate").innerText);
            var dateB = new Date(b.querySelector(".startDate").innerText);
            if (orderType === 'asc') {
                return dateA - dateB;
            } else {
                return dateB - dateA;
            }
        });

        rows.forEach(function(row) {
            table.appendChild(row);
        });
    }
</script>