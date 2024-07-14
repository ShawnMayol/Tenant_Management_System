<?php 
    include('handlers/admin/cardsHandler.php');
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

<style>
    .card-link {
    text-decoration: none;
    }

    .hover-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .hover-card:hover {
        transform: scale(1.02);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
    }
</style>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
      <h1 class="h1">Admin Dashboard</h1>
    </div>

    <div class="row">
    <!-- Pending Rent Requests Card -->
    <!-- <div class="col-md-4 mb-4">
        <a href="index.php?page=admin.requests" class="card-link">
            <div class="card text-white bg-info hover-card">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-clock" style="margin-right: 10px;"></i> Pending Rent Requests</h5>
                    <p class="card-text display-4"><?php echo $totalRequestsPending; ?></p>
                </div>
            </div>
        </a>
    </div> -->

    <!-- Pending Payments Card -->
    <!-- <div class="col-md-4 mb-4">
        <a href="pending-payments.php" class="card-link">
            <div class="card text-white bg-primary hover-card">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-credit-card" style="margin-right: 10px;"></i> Pending Payments</h5>
                    <p class="card-text display-4">0</p>
                </div>
            </div>
        </a>
    </div> -->

    <!-- Overdue Payments Card -->
    <!-- <div class="col-md-4 mb-4">
        <a href="overdue-payments.php" class="card-link">
            <div class="card text-white bg-danger hover-card">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-exclamation-triangle" style="margin-right: 10px;"></i> Overdue Payments</h5>
                    <p class="card-text display-4">0</p>
                </div>
            </div>
        </a>
    </div> -->

    <!-- Apartments Available Card -->
    <div class="col-md-4 mb-4">
        <a href="?page=admin.apartments" class="card-link">
            <div class="card text-white bg-warning hover-card">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-house-door" style="margin-right: 10px;"></i> Apartments Available</h5>
                    <p class="card-text display-4"><?php echo $availableCount; ?></p>
                </div>
            </div>
        </a>
    </div>

    <!-- Total Tenants Card -->
    <div class="col-md-4 mb-4">
        <a href="index.php?page=admin.tenants" class="card-link">
            <div class="card text-white bg-primary hover-card">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-people" style="margin-right: 10px;"></i> Total Tenants</h5>
                    <p class="card-text display-4"><?php echo $totalUsers; ?></p>
                </div>
            </div>
        </a>
    </div>
    
    <!-- Managers Active Card -->
    <div class="col-md-4 mb-4">
        <a href="?page=admin.staff" class="card-link">
            <div class="card text-white bg-success hover-card">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="bi bi-file-code" style="margin-right: 10px;"></i> Total Managers
                    </h5>
                    <p class="card-text display-4"><?php echo $activeManagersCount; ?></p>
                </div>
            </div>
        </a>
    </div>

</div>
<hr>
<h3 class="mb-3">Announcements</h3>
    <div class="row">
        <?php
            // Include database connection
            include('core/database.php');

            // Query to fetch announcements with user and staff information
            $sql = "SELECT a.*, u.picDirectory, u.userRole, s.firstName, s.lastName, s.staffRole
                    FROM announcement a
                    INNER JOIN user u ON a.staff_id = u.staff_ID
                    INNER JOIN staff s ON u.staff_ID = s.staff_ID
                    ORDER BY a.created_at DESC
                    LIMIT 3;";

            // Execute the query
            $result = $conn->query($sql);

            // Check if there are any announcements
            if ($result->num_rows > 0) {
                // Output data of each row
                while($row = $result->fetch_assoc()) {
                    // Format the timestamp into a readable format
                    $created_at = date('l, F j, Y, h:i A', strtotime($row['created_at']));

                    // Output the announcement HTML
                    echo '<div class="col-md-12 mb-4">';
                    echo '<div class="card">';
                    echo '<div class="card-body d-flex">';
                    
                    // Display staff picture on the left side
                    echo '<img src="' . htmlspecialchars(substr($row['picDirectory'], 6)) . '" class="img-fluid rounded-circle me-3" style="width: 50px; height: 50px; object-fit: cover;" alt="Staff Picture">';

                    // Announcement body with arrow pointing to the staff picture
                    echo '<div>';
                    echo '<h5 class="card-title mb-0">' . htmlspecialchars($row['firstName'] . ' ' . $row['lastName']) . '</h5>';
                    echo '<p class="card-text mb-0">' . htmlspecialchars($row['staffRole']) . '</p>';
                    echo '<p class="card-text text-muted mb-3">' . htmlspecialchars($created_at) . '</p>';

                    echo '<h5 class="card-subtitle mb-3">' . htmlspecialchars($row['title']) . '</h5>';
                    echo '<p class="card-text">' . htmlspecialchars($row['content']) . '</p>';
                    echo '</div>';

                    echo '</div>'; // .card-body
                    echo '</div>'; // .card
                    echo '</div>'; // .col-md-12
                }
            } else {
                echo '<div class="alert alert-info">No announcements yet :)</div>';
            }

            // Close database connection
            $conn->close();
        ?>
    </div>
    <hr>
    <h3 class="mb-3">Analytics</h3>        
    <!-- Dummy Graph -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Monthly Rent Collections and Due</h5>
                    <canvas id="myChart"></canvas>
                </div>
            </div>
        </div>
    </div>

</main>

<script>
    // Dummy data for the graph
    const labels = ['January', 'February', 'March', 'April', 'May', 'June'];
    const data = {
        labels: labels,
        datasets: [
            {
                label: 'Rent Collected',
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1,
                data: [1200, 1900, 3000, 5000, 2000, 3000],
            },
            {
                label: 'Rent Due',
                backgroundColor: 'rgba(255, 206, 86, 0.2)',
                borderColor: 'rgba(255, 206, 86, 1)',
                borderWidth: 1,
                data: [1500, 2100, 3200, 4500, 2500, 3500],
            }
        ]
    };

    // Configuration for the graph with animation
    const config = {
        type: 'bar',
        data: data,
        options: {
            animation: {
                duration: 2000, // Duration of the animation in milliseconds
                easing: 'easeOutBounce' // Easing function for the animation
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    };

    // Render the graph
    const myChart = new Chart(
        document.getElementById('myChart'),
        config
    );
</script>

<div class="container">
  <footer class="py-3 my-4">
    <ul class="nav justify-content-center border-bottom pb-3 mb-3">
      <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">Home</a></li>
      <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">Features</a></li>
      <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">Pricing</a></li>
      <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">FAQs</a></li>
      <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">About</a></li>
    </ul>
    <p class="text-center text-body-secondary">&copy; C-Apartments 2024</p>
  </footer>
</div>