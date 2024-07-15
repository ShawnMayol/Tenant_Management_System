<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>

<style>
    .clickable-row {
        cursor: pointer;
    }
</style>


<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h1">Requests</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="input-group me-2">
                <input type="text" class="form-control" id="filterInput" placeholder="Search name..." oninput="searchRequest()">
                <span class="input-group-text">
                    <i class="bi bi-search d-flex align-items-center"></i>
                </span> 
            </div>
            <div class="dropdown me-2">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="apartmentStatusDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    Apartment Status
                </button>
                <ul class="dropdown-menu" aria-labelledby="apartmentStatusDropdown">
                    <li><a class="dropdown-item" href="#" onclick="filterStatus('apartmentStatus', 'All')">All</a></li>
                    <li><a class="dropdown-item" href="#" onclick="filterStatus('apartmentStatus', 'Available')">Available</a></li>
                    <li><a class="dropdown-item" href="#" onclick="filterStatus('apartmentStatus', 'Maintenance')">Maintenance</a></li>
                    <!-- Add more options as needed -->
                </ul>
            </div>
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="orderDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    Order by Request Date
                </button>
                <ul class="dropdown-menu" aria-labelledby="orderDropdown">
                    <li><a class="dropdown-item" href="#" onclick="orderTable('asc')">Ascending</a></li>
                    <li><a class="dropdown-item" href="#" onclick="orderTable('desc')">Descending</a></li>
                </ul>
            </div>
        </div>
    </div>
    
    <style>
    .icon-align {
        display: inline-block;
        vertical-align: middle;
        margin-top: -20px; 
        margin-right: 8px; 
    }
</style>
    <div class="container">
        <div class="table-responsive">
            <table id="pinnedTable" class="table table-striped table-hover">
            <thead class="h5">
            <tr>
            <th>#</th>
            <th style="width: 30%;">Name</th>
            <th>Request Date</th>
            <th>Apartment Type</th>
            <th style="width: 20%;">Apartment Status</th>
            </tr>
            </thead>
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

            // Query for Pinned requests
            $sql = "
                SELECT r.request_ID, r.firstName, r.middleName, r.lastName, r.requestDate, a.apartmentType, a.apartmentStatus
                FROM request r
                LEFT JOIN apartment a ON r.apartmentNumber = a.apartmentNumber
                WHERE r.requestStatus = 'Pinned'
                ORDER BY r.requestDate DESC
            ";

            $result = $conn->query($sql);

            // Check if there are any records
            if ($result->num_rows > 0) {
                echo '<h1 class="h4">';
                echo '<i class="bi bi-pin-angle-fill icon-align"></i> Pinned';
                echo '</h1>';
                echo '<tbody>';

                // Output data of each row
                $count = 1;
                while ($row = $result->fetch_assoc()) {
                    // Combine the names
                    $fullName = $row['lastName'] . ', ' . $row['firstName'] . ' ' . $row['middleName'];
                    
                    // Format the date
                    $formattedDate = (new DateTime($row['requestDate']))->format('F j, Y');
                    
                    // Determine the status class based on apartmentStatus
                    $statusClass = '';
                    $apartmentStatus = !empty($row['apartmentStatus']) ? $row['apartmentStatus'] : 'Unknown';
                    
                    if ($apartmentStatus === 'Available') {
                        $statusClass = 'bg-success';
                    } elseif ($apartmentStatus === 'Maintenance') {
                        $statusClass = 'bg-warning';
                    } elseif ($apartmentStatus === 'Occupied') {
                        $statusClass = 'bg-danger';
                    } elseif ($apartmentStatus === 'Hidden') {
                        $statusClass = 'bg-secondary';
                    } else {
                        $statusClass = 'bg-secondary';
                    }

                    echo '<tr class="clickable-row" data-href="?page=admin.viewRequest&request_id=' . $row['request_ID'] . '" style="cursor: pointer;">';
                    echo '<td class="py-3">' . $count++ . '</td>';
                    echo '<td class="py-3">' . $fullName . '</td>';
                    echo '<td class="py-3">' . $formattedDate . '</td>';
                    echo '<td class="py-3">' . (!empty($row['apartmentType']) ? $row['apartmentType'] : 'Unknown') . '</td>';
                    echo '<td class="py-3"><span class="badge ' . $statusClass . '">' . $apartmentStatus . '</span></td>';
                    echo '</tr>';
                }

                echo '</tbody>';
                echo '</table>';
                // echo '<hr>';
            } else {
                // echo 'No pinned request :)';
            }

            $conn->close();
            ?>
        </div>
    </div>
    <div class="container pt-2">
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

// Query for Pending requests
$sql_pending = "
    SELECT r.request_ID, r.firstName, r.middleName, r.lastName, r.requestDate, a.apartmentType, a.apartmentStatus
    FROM request r
    LEFT JOIN apartment a ON r.apartmentNumber = a.apartmentNumber
    WHERE r.requestStatus = 'Pending'
    ORDER BY r.requestDate ASC
";

$result_pending = $conn->query($sql_pending);

// Check if there are any records
if ($result_pending->num_rows > 0) {
    echo '<table id="pendingTable" class="table table-striped table-hover">';
    // echo '<thead class="h5">';
    // echo '<tr>';
    // echo '<th>#</th>';
    // echo '<th style="width: 30%;">Name</th>';
    // echo '<th>Request Date</th>';
    // echo '<th>Apartment Type</th>';
    // echo '<th style="width: 20%;">Apartment Status</th>';
    // echo '</tr>';
    // echo '</thead>';
    echo '<tbody>';

    // Output data of each row
    $count_pending = 1;
    while ($row_pending = $result_pending->fetch_assoc()) {
        // Combine the names
        $fullName_pending = $row_pending['lastName'] . ', ' . $row_pending['firstName'] . ' ' . $row_pending['middleName'];
        
        // Format the date
        $formattedDate_pending = (new DateTime($row_pending['requestDate']))->format('F j, Y');
        
        // Determine the status class based on apartmentStatus
        $statusClass_pending = '';
        $apartmentStatus_pending = !empty($row_pending['apartmentStatus']) ? $row_pending['apartmentStatus'] : 'Unknown';
        
        if ($apartmentStatus_pending === 'Available') {
            $statusClass_pending = 'bg-success';
        } elseif ($apartmentStatus_pending === 'Maintenance') {
            $statusClass_pending = 'bg-warning';
        } elseif ($apartmentStatus_pending === 'Occupied') {
            $statusClass_pending = 'bg-danger';
        } elseif ($apartmentStatus_pending === 'Hidden') {
            $statusClass_pending = 'bg-secondary';
        } else {
            $statusClass_pending = 'bg-secondary';
        }

        echo '<tr class="clickable-row" data-href="?page=admin.viewRequest&request_id=' . $row_pending['request_ID'] . '" style="cursor: pointer;">';
        echo '<td class="py-3">' . $count_pending++ . '</td>';
        echo '<td class="py-3">' . $fullName_pending . '</td>';
        echo '<td class="py-3">' . $formattedDate_pending . '</td>';
        echo '<td class="py-3">' . (!empty($row_pending['apartmentType']) ? $row_pending['apartmentType'] : 'Unknown') . '</td>';
        echo '<td class="py-3"><span class="badge ' . $statusClass_pending . '">' . $apartmentStatus_pending . '</span></td>';
        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';
} else {
    // Handle case where no pending requests are found
    echo '<p>No pending requests found.</p>';
}

$conn->close();
?>

        </div>
    </div>
</main>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var rows = document.querySelectorAll('.clickable-row');
        rows.forEach(function(row) {
            row.addEventListener('click', function() {
                window.location.href = row.dataset.href;
            });
        });
    });

    function searchRequest() {
        var input, filter, tables, tr, td, i, j, txtValue;
        input = document.getElementById("filterInput");
        filter = input.value.toLowerCase();
        tables = document.querySelectorAll("table");
        
        tables.forEach(function(table) {
            tr = table.getElementsByTagName("tr");
            for (i = 1; i < tr.length; i++) {
                tr[i].style.display = "none"; // Hide the row initially
                td = tr[i].getElementsByTagName("td");
                for (j = 0; j < td.length; j++) {
                    if (td[j]) {
                        txtValue = td[j].textContent || td[j].innerText;
                        if (txtValue.toLowerCase().indexOf(filter) > -1) {
                            tr[i].style.display = ""; // Show the row if a match is found
                            break;
                        }
                    }
                }
            }
        });
    }
    function filterStatus(statusType, filterValue) {
        var table = document.querySelector(".table tbody");
        var rows = table.getElementsByTagName("tr");

        for (var i = 0; i < rows.length; i++) {
            var statusCell = rows[i].querySelector("." + statusType);
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
