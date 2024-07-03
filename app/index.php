<!doctype html>
<html lang="en" data-bs-theme="auto">

<?php
session_start();

// Debugging: Check session values
// print_r($_SESSION);
// print_r($_GET);

// Redirect to landing.php if user is not logged in yet
if (!isset($_SESSION['user_id'])) {
  header('Location: views/common/landing.php');
  exit();
}
?>

<head>
  <script src="assets/dist/js/color-modes.js"></script>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Dashboard | C-Apartments</title>
  <link rel="icon" href="assets/src/svg/c-logo.svg">

  <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">

  <link href="assets/src/css/dashboard.css" rel="stylesheet">
</head>

<body>

  <?php include ('core/themes.php'); ?>
  <?php include ('core/icons.php'); ?>

  <header class="navbar sticky-top flex-md-nowrap p-0 shadow" data-bs-theme="auto">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6 text-white" href="index.php">
      <img src="assets/src/svg/c.svg" alt="Company Logo" style="width: 100%; height: 80%">
    </a>
    <ul class="navbar-nav flex-row">
      <li class="nav-item text-nowrap">
        <button class="nav-link px-3 d-md-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu"
          aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
            class="bi bi-list theme-icon" viewBox="0 0 16 16">
            <path fill-rule="evenodd"
              d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5" />
          </svg>
        </button>
      </li>
      <li class="nav-item text-nowrap d-none d-md-block">
        <!-- Account Picture (Placeholder) -->
        <img src="placeholder.jpg" class="img-fluid rounded-circle mx-2" style="width: 32px; height: 32px;"
          alt="Account Picture">
        <!-- Username (Placeholder) -->
        <span class="nav-link px-2">Username</span>
      </li>
    </ul>
  </header>

  <?php
  // Check if the session role is set
  if (isset($_SESSION['role'])) {
    
    // Assign the appropriate sidebar and default dashboard based on the user role
    switch ($_SESSION['role']) {
      case 'Admin':
        $sideBar = 'views/admin/admin.sidebar';
        $dashboard = 'views/admin/admin.dashboard';
        break;
      case 'Manager':
        $sideBar = 'views/manager/manager.sidebar';
        $dashboard = 'views/manager/manager.dashboard';
        break;
      case 'Tenant':
        $sideBar = 'views/tenant/tenant.sidebar';
        $dashboard = 'views/tenant/tenant.dashboard';
        break;
      default:
        echo ('error');
    }

    // Check if a specific page is requested, override $dashboard if needed
    if (isset($_GET['page'])) {
      switch ($_GET['page']) {
        case 'dashboard':
          $dashboard = 'views/admin/admin.dashboard';
          break;
        case 'requests':
          $dashboard = 'views/admin/admin.request';
          break;
        // Add more cases for other pages if necessary(katong mga shit sa sidebar payments,fees etc.)
      }
    }

    // Include the sidebar and selected dashboard content
    include $sideBar . '.php';
    include $dashboard . '.php';
  }
  ?>


  </div>
  </div>

  <script src="assets/dist/js/bootstrap.bundle.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.2/dist/chart.umd.js"
    integrity="sha384-eI7PSr3L1XLISH8JdDII5YN/njoSsxfbrkCTnJrzXt+ENP5MOVBxD+l6sEG4zoLp"
    crossorigin="anonymous"></script>
  <script src="assets/src/js/dashboard.js"></script>
  <script src="assets/src/js/loading.js"></script>

</body>

</html>