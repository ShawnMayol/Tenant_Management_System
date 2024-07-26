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
<?php
        // Include database connection file
        include ('core/database.php');

        $sql = "
        SELECT s.staff_ID, s.lastName, s.firstName, s.middleName, u.userStatus, a.activityDescription, a.activityTimestamp, u.picDirectory
        FROM staff s
        LEFT JOIN (
            SELECT staff_ID, activityDescription, activityTimestamp
            FROM activity
            WHERE activityTimestamp IN (
                SELECT MAX(activityTimestamp)
                FROM activity
                GROUP BY staff_ID
            )
        ) a ON s.staff_ID = a.staff_ID
        LEFT JOIN user u ON s.staff_ID = u.staff_ID
        WHERE s.staffRole != 'Admin' AND u.staff_ID IS NOT NULL
        ORDER BY u.userStatus DESC
    ";
    
    // Execute the query
    $result = $conn->query($sql);
    
    // Check if there are any managers
    if ($result->num_rows > 0) {
        // Fetch count of managers
        $countManagers = $result->num_rows;
    } else {
        $countManagers = 0;
    }
    ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h1">Managers </h1>
        <!-- <span class="h4">(<?php //echo $countManagers; ?>)</span> -->
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="input-group me-2">
                <input type="text" class="form-control" id="filterInput" placeholder="Search Manager..." oninput="searchManagers()">
                <span class="input-group-text">
                    <i class="bi bi-search d-flex align-items-center"></i>
                </span> 
            </div>
            <a href="#" class="text-secondary" id="addManagerButton" data-bs-toggle="modal" data-bs-target="#addManagerModal" title="Add Manager" style="text-decoration: none;">
                <button type="button" class="btn btn-outline-secondary d-flex align-items-center gap-1 hover-white">
                    <span class="m-1">Add Manager</span><i class="bi bi-plus-square icon-adjust m-1 d-flex align-items-center"></i>
                </button>
            </a>
        </div>
    </div>
    <?php include 'views/admin/modal.addManager.php'; ?>

    <div class="container">
        <div class="table-responsive">

    <?php
        // Check if there are any records
        if ($result->num_rows > 0) {
            echo '<table class="table table-striped table-hover">';
            echo '<thead class="h5">';
            echo '<tr>';
            echo '<th style="width: 8%;"></th>';
            echo '<th style="width: 25%;">Name</th>';
            echo '<th style="width: 40%;">Last Activity</th>';
            echo '<th style="width: 21%;">Status</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            // Output data of each row
            $count = 1;
            while ($row = $result->fetch_assoc()) {
                // Determine the status class based on staffStatus
                $statusClass = '';
                if ($row['userStatus'] === 'Online') {
                    $statusClass = 'bg-success';
                } elseif ($row['userStatus'] === 'Offline') {
                    $statusClass = 'bg-secondary';
                } elseif ($row['userStatus'] === 'Deactivated') {
                    $statusClass = 'bg-danger';
                }
                $picDirectory = substr($row['picDirectory'], 6);
                echo '<tr class="clickable-row" data-href="?page=admin.viewManager&staff_id=' . $row['staff_ID'] . '">';
                echo '<td class="py-3">';
                echo '<div style="width: 30px; height: 30px; border-radius: 50%; overflow: hidden; margin-left: 20px;">';
                echo '<img src="' . htmlspecialchars(substr($row['picDirectory'], 6)) . '" class="img-fluid rounded-circle me-3" style="width: 30px; height: 30px; object-fit: cover;" alt="Staff Picture">';
                echo '</div>';
                echo '</td>';
                echo '<td class="py-3">' . $row['lastName'] . ', ' . $row['firstName'] . ' ' . $row['middleName'] . '</td>';
                echo '<td class="py-3">' . (!empty($row['activityDescription']) ? $row['activityDescription'] . ' at ' . (new DateTime($row['activityTimestamp']))->format('F j, Y, g:i A') : 'No activity') . '</td>';
                echo '<td class="py-3 h6"><span class="badge ' . $statusClass . '">' . $row['userStatus'] . '</span></td>';
                echo '</tr>';
            }

            echo '</tbody>';
            echo '</table>';
        } else {
            echo 'No staff found.';
        }

        $conn->close();
        ?>
    </div>
</div>


    <script>
        let currentPage = 1;
        let rowsPerPage = 10;

        function displayTable(data) {
            const tableBody = document.getElementById('employeeTableBody');
            tableBody.innerHTML = '';

            const start = (currentPage - 1) * rowsPerPage;
            const end = start + rowsPerPage;
            const pageData = data.slice(start, end);

            for (let i = 0; i < pageData.length; i++) {
                const row = pageData[i];
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${row.id}</td>
                    <td>${row.name}</td>
                    <td>${row.position}</td>
                    <td>${row.office}</td>
                    <td>${row.age}</td>
                `;
                tableBody.appendChild(tr);
            }
        }

        function setupPagination(data) {
            document.getElementById('prevButton').addEventListener('click', () => {
                if (currentPage > 1) {
                    currentPage--;
                    displayTable(data);
                }
            });

            document.getElementById('nextButton').addEventListener('click', () => {
                if (currentPage * rowsPerPage < data.length) {
                    currentPage++;
                    displayTable(data);
                }
            });

            document.getElementById('rowsPerPage').addEventListener('change', (event) => {
                rowsPerPage = parseInt(event.target.value);
                currentPage = 1;
                displayTable(data);
            });
        }

        function setupSearch(data) {
            document.getElementById('searchInput').addEventListener('input', (event) => {
                const searchTerm = event.target.value.toLowerCase();
                const filteredData = data.filter(row => 
                    row.name.toLowerCase().includes(searchTerm) || 
                    row.position.toLowerCase().includes(searchTerm) ||
                    row.office.toLowerCase().includes(searchTerm)
                );
                currentPage = 1;
                displayTable(filteredData);
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            displayTable(dummyData);
            setupPagination(dummyData);
            setupSearch(dummyData);
        });
    </script>
    <script>
        function searchManagers() {
            // Get the input field and its value
            var input = document.getElementById("filterInput");
            var filter = input.value.toLowerCase();

            // Get the table and table rows
            var table = document.querySelector(".table tbody");
            var rows = table.getElementsByTagName("tr");

            // Loop through all table rows, and hide those who don't match the search query
            for (var i = 0; i < rows.length; i++) {
                var nameCell = rows[i].getElementsByTagName("td")[1]; // Get the name column (2nd column)
                if (nameCell) {
                    var nameText = nameCell.textContent || nameCell.innerText;
                    if (nameText.toLowerCase().indexOf(filter) > -1) {
                        rows[i].style.display = "";
                    } else {
                        rows[i].style.display = "none";
                    }
                }       
            }
        }
    </script>
</main>