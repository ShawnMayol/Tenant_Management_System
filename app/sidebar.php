<?php ?>
<!-- Home Menu -->

<div class="home-menu" style="width: 280px;">
        <a href="index.php" class="d-flex align-items-center pb-3 mb-3 link-body-emphasis text-decoration-none border-bottom">
        <img src="assets/src/img/c.svg" style="height: 50px; width: 300px">
        <!-- <span class="fs-4 fw-semibold">DASHBOARD</span> -->
        </a>
        <ul class="list-unstyled ps-0">
        <li class="mb-1">
            <button id="apartments-btn" class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed">Apartments</button>
        </li>
        <li class="mb-1">
            <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#dashboard-collapse" aria-expanded="false">
            Payments
            </button>
            <div class="collapse" id="dashboard-collapse">
            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                <li><a href="#" id="invoice-btn" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Invoice</a></li>
                <li><a href="#" id="history-btn" class="link-body-emphasis d-inline-flex text-decoration-none rounded">History</a></li>
            </ul>
            </div>
        </li>
        <li class="mb-1">
            <button id="maintenance-btn" class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#orders-collapse" aria-expanded="false">
            Maintenance
            </button>
            <div class="collapse" id="orders-collapse">
            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                <li><a href="#" id="req-maintenance-btn" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Maintenance Request</a></li>
                <li><a href="#" id="status-maintenance-btn" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Maintenance Status</a></li>
            </ul>
            </div>
        </li>
        <li class="mb-1">
            <button id="admin-btn" class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#admin-collapse" aria-expanded="false">
            Admin
            </button>
            <div class="collapse" id="admin-collapse">
            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                <li><a href="#" id="admin-users-btn" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Users</a></li>
                <li><a href="#" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Apartments</a></li>
            </ul>
            </div>
        </li>
        <li class="border-top my-3"></li>
        <li class="mb-1">
            <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#account-collapse" aria-expanded="false">
            Account
            </button>
            <div class="collapse" id="account-collapse">
            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                <li><a href="#" id="account-new-btn" class="link-body-emphasis d-inline-flex text-decoration-none rounded">New...</a></li>
                <li><a href="#" id="account-profile-btn" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Profile</a></li>
                <li><a href="#" id="account-settings-btn" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Settings</a></li>
                <li><a href="landing.php" id="account-signout-btn" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Sign out</a></li>
            </ul>
            </div>
        </li>
        </ul>
    </div>