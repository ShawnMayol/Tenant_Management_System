<!doctype html>
<html lang="en" data-bs-theme="light">

<?php
  session_start();

// Debugging: Check session values
  // print_r($_SESSION);
  // print_r($_GET);

// Redirect to landing.php if user is not logged in yet
  if(!isset($_SESSION['user_id'])) {
    header('Location: views/common/landing.php');
    exit(); 
  }

?>
<!-- Bootstrap Bundle with Popper -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/js/bootstrap.bundle.min.js"></script>

<head>
  <script src="assets/dist/js/color-modes.js"></script>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Dashboard | C-Apartments</title>
  <link rel="icon" href="assets/src/svg/c-logo.svg">

  <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">

  <link href="assets/src/css/dashboard.css" rel="stylesheet">
  <link href="assets/src/css/themes.css" rel="stylesheet">
  
  

</head>

<style>

#accountPictureTrigger img {
    display: block;
    margin-right: 30px;
}

</style>

<body>

  <?php 
      include ('core/themes.php'); 
      include ('core/icons.php'); 

      $role = $_SESSION['role'] ?? 'tenant';
      $dashboardPage = match ($role) {
          'admin' => 'index.php?page=admin.dashboard',
          'manager' => 'index.php?page=manager.dashboard',
          'tenant' => 'index.php?page=tenant.dashboard',
      };
  ?>

  <header class="navbar sticky-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6 text-white" href="<?= htmlspecialchars($dashboardPage) ?>">
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

      <?php
        include 'core/database.php';

        // Retrieve user data from session
        $loggedInUserID = $_SESSION['user_id'] ?? null;
        $username = "";
        $picDirectory = "uploads/staff/placeholder.jpg"; 

        $query = "SELECT username, picDirectory FROM user WHERE user_ID = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $loggedInUserID);
        $stmt->execute();
        $stmt->bind_result($username, $picDirectory);
        $stmt->fetch();
        $stmt->close();

        $conn->close();
        ?>

        <li class="nav-item text-nowrap d-none d-md-flex align-items-center text-white">
            <div class="navbar-nav">
                <span class="px-2"><?= htmlspecialchars($username) ?></span>
            </div>
            <a href="#" id="accountPictureTrigger" data-bs-toggle="modal" data-bs-target="#staffAccountModal">
              <?php $picDirectory = substr($picDirectory, 6); ?>
              <img src="<?php echo $picDirectory; ?>" class="img-fluid rounded-circle" style="width: 32px; height: 32px; object-fit: cover;" alt="Account Picture">
            </a>
        </li>
    </ul>
  </header>

  <?php
  // Check if the session role is set
  if (isset($_SESSION['role'])) {

    // Assign the appropriate sidebar and default dashboard based on the user role
    switch ($_SESSION['role']) {
      case 'admin':
        $sideBar = 'views/admin/admin.sidebar';
        $page = 'views/admin/admin.dashboard';
        break;
      case 'manager':
        $sideBar = 'views/manager/manager.sidebar';
        $page = 'views/manager/manager.dashboard';
        break;
      case 'tenant':
        $sideBar = 'views/tenant/tenant.sidebar';
        $page = 'views/tenant/tenant.dashboard';
        break;
      default:
      echo ('error');
    }
    
    include $sideBar . '.php';
    
    // Check if a specific page is requested, override $page if needed
    if (isset($_GET['page'])) {
      $page = $_GET['page']; 
      include 'views/' .  $role . '/' . $page . '.php'; 
    } else {
      include $page . '.php';
    }

  }
  ?>


  </div>
  </div>

  <script src="assets/dist/js/bootstrap.bundle.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.2/dist/chart.umd.js"
    integrity="sha384-eI7PSr3L1XLISH8JdDII5YN/njoSsxfbrkCTnJrzXt+ENP5MOVBxD+l6sEG4zoLp"
    crossorigin="anonymous"></script>
  <script src="assets/src/js/dashboard.js"></script>

</body>

</html>