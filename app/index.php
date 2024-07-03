<!doctype html>
<html lang="en" data-bs-theme="auto">

<?php 
  session_start();

  // Debugging: Check session values
  print_r($_SESSION);
  print_r($_GET);

  // Redirect to landing.php if user is not logged in yet
  if(!isset($_SESSION['user_id'])) {
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

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/js/bootstrap.bundle.min.js"></script>


</head>

<style>

#accountPictureTrigger img {
    display: block;
    margin-right: 30px; /* Adjust this value to add margin to the right of the account image */
}

</style>

<body>

  <?php include ('core/themes.php'); ?>
  <?php include ('core/icons.php'); ?>

  <header class="navbar sticky-top bg-dark-subtle flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6 text-white" href="index.php">
        <img src="assets/src/svg/c.svg" alt="Company Logo" style="width: 100%; height: 80%">
    </a>
    <ul class="navbar-nav flex-row">
        <li class="nav-item text-nowrap">
            <button class="nav-link px-3 d-md-none" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false"
                aria-label="Toggle navigation">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-list theme-icon" viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5" />
                </svg>
            </button>
        </li>
        <li class="nav-item text-nowrap d-none d-md-flex align-items-center">
            <!-- Username (Placeholder) -->
            <span class="px-2">Admin</span>
            <!-- Account Picture (Placeholder) -->
            <a href="#" id="accountPictureTrigger" data-bs-toggle="modal" data-bs-target="#accountModal">
                <img src="uploads/admin/profile_pictures/placeholder.jpg" class="img-fluid rounded-circle" style="width: 32px; height: 32px;" alt="Account Picture">
            </a>
        </li>
    </ul>
</header>

<?php 
    // Check if the session role is set
    if (isset($_SESSION['role'])) {
      // Assign the appropriate sidebar based on the user role
      switch ($_SESSION['role']) {
          case 'admin':
              $sideBar = 'views/admin/admin.sidebar';
              break;
          case 'manager':
              $sideBar = 'views/manager/manager.sidebar';
              break;
          case 'tenant':
              $sideBar = 'views/tenant/tenant.sidebar';
              break;
          default:
              echo('error');
      }

      include $sideBar . '.php'; 
      
    } else {
        // do nothing
    }
    if (isset($_GET['page'])) {
        $dashboard = $_GET['page']; 
        $role = $_SESSION['role'];
        include 'views/' .  $role . '/' . $dashboard . '.php'; 
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