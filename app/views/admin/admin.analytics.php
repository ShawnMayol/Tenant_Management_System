<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h1">Managers</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="input-group me-2">
                <input type="text" class="form-control" id="filterInput" placeholder="Search Manager..." oninput="searchApartments()">
                <span class="input-group-text">
                    <i class="bi bi-search"></i>
                </span> 
            </div>
            <a href="" class="text-secondary" id="addApartmentButton" data-bs-toggle="modal" data-bs-target="#addApartmentModal" title="Add apartment" style="text-decoration: none;">
                <button type="button" class="btn btn-outline-secondary d-flex align-items-center gap-1 hover-white">
                    <span class="m-1">Add Manager</span><i class="bi bi-plus-square icon-adjust m-1"></i>
                </button>
            </a>
        </div>
    </div>

    <div class="container">

        <div class="table-responsive">

        <?php
    // Include database connection file
    include 'core/database.php';

    // Process search query if submitted
    // if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['search'])) {
    //     // Sanitize and store search query
    //     $search = mysqli_real_escape_string($conn, $_GET['search']);
    // }

    // Query to fetch staff data with search filter, excluding admin
    $sql = "SELECT * 
    FROM staff
    WHERE staffRole != 'Admin'";
    // --  AND CONCAT(lastName, ' ', firstName, ' ', middleName) LIKE '%$search%'";

    $result = $conn->query($sql);

    // Check if there are any records
    if ($result->num_rows > 0) {
        echo '<table class="table table-striped table-hover">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>#</th>';
        echo '<th>Name</th>';
        echo '<th>Last Activity</th>';
        echo '<th>Status</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        // Output data of each row
        $count = 1;
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $count++ . '</td>';
            echo '<td><a href="" style="text-decoration: none;">' . $row['lastName'] . ', ' . $row['firstName'] . ' ' . $row['middleName'] . '</a></td>';
            echo '<td>' . $row['lastActivity'] . '</td>';
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

        <!-- Pagination controls -->
        <div class="d-flex justify-content-between">
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
                        <li class="page-item disabled " id="prevButton"> 
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
                            <a class="page-link" href="#" >
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>

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



</main>