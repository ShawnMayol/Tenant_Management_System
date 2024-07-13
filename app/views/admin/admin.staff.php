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
        <h1 class="h1">Managers</h1>
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

        // Query to fetch staff data with their last activity, excluding admin
        $sql = "
        SELECT s.staff_ID, s.lastName, s.firstName, s.middleName, s.staffStatus, a.activityDescription, a.activityTimestamp
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
        WHERE s.staffRole != 'Admin'
        ORDER BY s.staffStatus
        ";

        $result = $conn->query($sql);

        // Check if there are any records
        if ($result->num_rows > 0) {
            echo '<table class="table table-striped table-hover">';
            echo '<thead class="h5">';
            echo '<tr>';
            echo '<th style="width: 10%;">#</th>';
            echo '<th style="width: 29%;">Name</th>';
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
                if ($row['staffStatus'] === 'Active') {
                    $statusClass = 'bg-success';
                } elseif ($row['staffStatus'] === 'Inactive') {
                    $statusClass = 'bg-secondary';
                } elseif ($row['staffStatus'] === 'Fired') {
                    $statusClass = 'bg-danger';
                }

                echo '<tr class="clickable-row" data-href="?page=admin.viewManager&staff_id=' . $row['staff_ID'] . '">';
                echo '<td class="py-3">' . $count++ . '</td>';
                echo '<td class="py-3">' . $row['lastName'] . ', ' . $row['firstName'] . ' ' . $row['middleName'] . '</td>';
                echo '<td class="py-3">' . (!empty($row['activityDescription']) ? $row['activityDescription'] . ' at ' . (new DateTime($row['activityTimestamp']))->format('F j, Y, g:i A') : 'No activity') . '</td>';
                echo '<td class="py-3"><span class="badge ' . $statusClass . '">' . $row['staffStatus'] . '</span></td>';
                echo '</tr>';
            }

            echo '</tbody>';
            echo '</table>';
        } else {
            echo 'No staff found.';
        }

        $conn->close();
        ?>

        <!-- Pagination controls -->
        <!-- <div class="d-flex justify-content-between">
            <div>
                <select id="rowsPerPage" class="form-select">
                    <option value="10">10 rows per page</option>
                    <option value="15">15 rows per page</option>
                    <option value="20">20 rows per page</option>
                </select>
            </div>
            <div>
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        <li class="page-item disabled" id="prevButton">
                            <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        <li class="page-item active" aria-current="page">
                            <a class="page-link" href="#">1 <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item" id="nextButton">
                            <a class="page-link" href="#">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div> -->
        
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