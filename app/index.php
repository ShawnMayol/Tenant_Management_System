<!doctype html>
<html lang="en" data-bs-theme="light">

<?php
  session_start();
  date_default_timezone_set('Asia/Manila');
// Debugging: Check session values
  // print_r($_SESSION);
  // print_r($_GET);

// Redirect to landing.php if user is not logged in yet
  if(!isset($_SESSION['user_id'])) {
    header('Location: views/common/landing.php');
    exit(); 
  }

include('core/database.php');

// Retrieve user ID from session
$user_id = $_SESSION['user_id'];

// Query to check user status
$statusSql = "SELECT userStatus FROM user WHERE user_ID = ?";
$statusStmt = $conn->prepare($statusSql);
$statusStmt->bind_param("i", $user_id);
$statusStmt->execute();
$statusResult = $statusStmt->get_result();

if ($statusResult->num_rows === 1) {
    $user = $statusResult->fetch_assoc();
    $userStatus = $user['userStatus'];

    // Check if user status is 'Deactivated'
    if ($userStatus === 'Deactivated') {
      $conn->close();

      echo '<script>alert("Your account has been deactivated. Contact Admin if you think this is a mistake.");</script>';
      echo '<script>setTimeout(function() { window.location.href = "handlers/common/destroySession.php"; }, 100);</script>';
      exit(); 
    }
} else {
    // User not found in database
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

  <title>C-Apartments | Tenant Management System</title>
  <link rel="icon" href="assets/src/svg/c-logo.svg">

  <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">

  <link href="assets/src/css/dashboard.css" rel="stylesheet">
  <link href="assets/src/css/themes.css" rel="stylesheet">
  
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

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
      
      $userRole = isset($_SESSION['role']) ? $_SESSION['role'] : '';

      if ($userRole === 'admin') {
          $modalTarget = '#adminAccountModal';
      } elseif ($userRole === 'manager') {
          $modalTarget = '#staffAccountModal';
      } elseif ($userRole === 'tenant') {
          $modalTarget = '#tenantAccountModal';
      } else {
          $modalTarget = '#staffAccountModal'; // Default to staff modal for safety
      }
      ?>
  
    <?php
        include 'core/database.php';

        // Retrieve user data from session
        $loggedInUserID = $_SESSION['user_id'] ?? null;
        $user = "";
        $picDirectory = "uploads/staff/placeholder.jpg"; 

        $query = "SELECT username, picDirectory FROM user WHERE user_ID = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $loggedInUserID);
        $stmt->execute();
        $stmt->bind_result($user, $picDirectory);
        $stmt->fetch();
        $stmt->close();

        $conn->close();
    ?>
 <header class="navbar sticky-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6 text-white" href="<?= htmlspecialchars($dashboardPage) ?>">
        <img src="assets/src/svg/c.svg" alt="Company Logo" style="width: 100%; height: 80%">
    </a>
    <ul class="navbar-nav flex-row w-100">
        <!-- <li class="nav-item text-nowrap d-flex align-items-center text-white ms-4">
            <div class="navbar-nav">
                <span id="current-time"></span>
                <span id="current-date"></span>
            </div>
        </li> -->
        <!-- <li class="nav-item text-nowrap d-flex align-items-center text-white ms-4">
            <div class="navbar-nav h3">
                <span id="dynamic-greeting"></span>
            </div>
        </li> -->
        <li class="nav-item text-nowrap ms-auto">
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
        <li class="nav-item text-nowrap d-none d-md-flex align-items-center text-white ms-auto">
            <div class="navbar-nav">
                <span class="px-2"><?= htmlspecialchars($user) ?></span>
            </div>
            <a href="#" id="accountPictureTrigger" data-bs-toggle="modal" data-bs-target="<?php echo $modalTarget; ?>">
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
          include('core/database.php');
      
          // Query to get tenant_ID
          $sql = "SELECT tenant_ID FROM user WHERE user_ID = ?";
          $stmt = $conn->prepare($sql);
          $stmt->bind_param("i", $user_id);
          $stmt->execute();
          $stmt->bind_result($tenant_id);
          $stmt->fetch();
          $stmt->close();
      
          // Query to get lease_ID
          $sql = "SELECT lease_ID FROM tenant WHERE tenant_ID = ?";
          $stmt = $conn->prepare($sql);
          $stmt->bind_param("i", $tenant_id);
          $stmt->execute();
          $stmt->bind_result($lease_id);
          $stmt->fetch();
          $stmt->close();
      
          // Query to get apartmentNumber using lease_ID
          $sql = "SELECT apartmentNumber FROM lease WHERE lease_ID = ?";
          $stmt = $conn->prepare($sql);
          $stmt->bind_param("i", $lease_id);
          $stmt->execute();
          $stmt->bind_result($apartmentNumber);
          $stmt->fetch();
          $stmt->close();
      
          $sideBar = 'views/tenant/tenant.sidebar';  //remove s from tenants
          $page = 'views/tenant/tenant.dashboard';
          $conn->close();
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




  <script src="assets/dist/js/bootstrap.bundle.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.2/dist/chart.umd.js"
    integrity="sha384-eI7PSr3L1XLISH8JdDII5YN/njoSsxfbrkCTnJrzXt+ENP5MOVBxD+l6sEG4zoLp"
    crossorigin="anonymous"></script>
  <script src="assets/src/js/dashboard.js"></script>

  <script>
    function updateTimeAndDate() {
        const timeElement = document.getElementById('current-time');
        const dateElement = document.getElementById('current-date');

        const now = new Date();

        // Format the time as HH:MM AM/PM
        let hours = now.getHours();
        const minutes = now.getMinutes();
        const ampm = hours >= 12 ? 'PM' : 'AM';
        hours = hours % 12;
        hours = hours ? hours : 12; // the hour '0' should be '12'
        const formattedTime = `${hours}:${minutes.toString().padStart(2, '0')} ${ampm}`;

        // Format the date as Day of the week, Month Day, Year
        const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        const months = [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ];
        const formattedDate = `${days[now.getDay()]}, ${months[now.getMonth()]} ${now.getDate()}, ${now.getFullYear()}`;

        // Update the HTML content
        timeElement.textContent = formattedTime;
        dateElement.textContent = formattedDate;
    }

    // Update the time and date every second
    setInterval(updateTimeAndDate, 1000);

    // Initial call to set the time and date immediately
    updateTimeAndDate();

//     function updateGreeting() {
//     const now = new Date();
//     const hours = now.getHours();
//     let greeting;

//     if (hours < 12) {
//         greeting = "Good Morning, <?= htmlspecialchars($user) ?>!";
//     } else if (hours < 18) {
//         greeting = "Good Afternoon, <?= htmlspecialchars($user) ?>!";
//     } else {
//         greeting = "Good Evening, <?= htmlspecialchars($user) ?>!";
//     }

//     document.getElementById('dynamic-greeting').innerText = greeting;
// }

// // Update the greeting when the page loads
// document.addEventListener('DOMContentLoaded', updateGreeting);
</script>

</body>

</html>