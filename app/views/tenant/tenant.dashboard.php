<?php 
    include('handlers/tenant/tenantCardsHandler.php');
    include('handlers/tenant/retrieveAnnouncement.php');
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
      <h1 class="h2">Temporary Dashboard</h1>
    </div>

    <div class="row">
    <!-- Pending Rent Requests Card -->
    <div class="col-md-4 mb-4">
        <a href="index.php?page=admin.requests" class="card-link">
            <div class="card text-white bg-info hover-card">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-clock" style="margin-right: 10px;"></i> Pending Rent Requests</h5>
                    <p class="card-text display-4"><?php echo $totalRequestsPending; ?></p>
                </div>
            </div>
        </a>
    </div>

    <!-- Pending Payments Card -->
    <div class="col-md-4 mb-4">
        <a href="pending-payments.php" class="card-link">
            <div class="card text-white bg-primary hover-card">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-credit-card" style="margin-right: 10px;"></i> Pending Payments</h5>
                    <p class="card-text display-4">0</p>
                </div>
            </div>
        </a>
    </div>

    <!-- Overdue Payments Card -->
    <div class="col-md-4 mb-4">
        <a href="overdue-payments.php" class="card-link">
            <div class="card text-white bg-danger hover-card">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-exclamation-triangle" style="margin-right: 10px;"></i> Overdue Payments</h5>
                    <p class="card-text display-4">0</p>
                </div>
            </div>
        </a>
    </div>

    <!-- Apartments Available Card -->
    <div class="col-md-4 mb-4">
        <a href="apartments-available.php" class="card-link">
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
            <div class="card text-white bg-secondary hover-card">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-people" style="margin-right: 10px;"></i> Total Tenants</h5>
                    <p class="card-text display-4"><?php echo $totalTenantsCount; ?></p>
                </div>
            </div>
        </a>
    </div>

    <!-- Payments this month Card -->
    <div class="col-md-4 mb-4">
        <a href="payments-this-month.php" class="card-link">
            <div class="card text-white bg-success hover-card">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-cash" style="margin-right: 10px;"></i> Payments this month</h5>
                    <p class="card-text display-4">0</p>
                </div>
            </div>
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-12 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Announcements</h5>
            </div>
            <div class="card-body">
                <?php if (!empty($announcements)): ?>
                    <ul class="list-group">
                        <?php foreach ($announcements as $announcement): ?>
                            <li class="list-group-item">
                                <h5><?php echo $announcement['title']; ?></h5>
                                <p><?php echo $announcement['content']; ?></p>
                                <small>Posted by <?php echo $announcement['staff_name']; ?> on <?php echo date('F j, Y, g:i a', strtotime($announcement['created_at'])); ?></small>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p>No announcements available.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

</main>
