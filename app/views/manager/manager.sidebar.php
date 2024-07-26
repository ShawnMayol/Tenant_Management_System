<style>
  .sidebar, .offcanvas-md {
    z-index: 1050;
  }
  .selected {
    background-color: rgba(0, 123, 255, 0.1); /* Subtle glass-like background */
    border-radius: 5px;
  }
  .selected:hover {
      background-color: rgba(0, 123, 255, 0.2); /* Slightly darker on hover */
  }
  .highlight {
      transition: background-color 0.3s;
  }
  .highlight:hover {
      background-color: rgba(0, 123, 255, 0.05); /* Lighter shade for hover */
      border-radius: 5px;
  }
  .door-icon {
    transition: all 0.3s ease-in-out;
  }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const logoutLink = document.getElementById('logout-link');
        const logoutIcon = document.getElementById('logout-icon');

        logoutLink.addEventListener('mouseenter', function() {
            logoutIcon.querySelector('.door-icon').setAttribute('xlink:href', '#door-open');
        });

        logoutLink.addEventListener('mouseleave', function() {
            logoutIcon.querySelector('.door-icon').setAttribute('xlink:href', '#door-closed');
        });
    });
</script>

<?php include('views/admin/modal.staffAccount.php'); ?>
<?php include('views/common/modal.changePassword.php'); ?>

<div class="container-fluid">
    <div class="row">
      <div class="sidebar position-fixed border border-right col-md-3 col-lg-2 p-0 bg-body-tertiary shadow">
        <div class="offcanvas-md offcanvas-end bg-body-tertiary" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
          <div class="offcanvas-header">
              <h5 class="offcanvas-title" id="sidebarMenuLabel">C-Apartments</h5>
              <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
          </div>
          <div class="offcanvas-body d-md-flex flex-column p-0 pt-lg-3 overflow-y-auto">
            <ul class="nav flex-column">

            <?php
              $currentPage = isset($_GET['page']) ? $_GET['page'] : '';
            ?>

              <li class="nav-item">
                <a class="nav-link d-flex align-items-center gap-2 <?php echo $currentPage === 'manager.dashboard' ? 'selected' : 'highlight'; ?>" aria-current="page" href="index.php?page=manager.dashboard">
                  <svg class="bi" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                      <use xlink:href="<?php echo $currentPage === 'manager.dashboard' ? '#house-fill' : '#house'; ?>" />
                  </svg>
                  Dashboard
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link d-flex align-items-center gap-2 <?php echo $currentPage === 'manager.requests' ? 'selected' : 'highlight'; ?>" aria-current="page" href="?page=manager.requests">
                  <svg class="bi" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                      <use xlink:href="<?php echo $currentPage === 'manager.requests' ? '#file-earmark-fill' : '#file-earmark'; ?>" />
                  </svg>
                  Requests
                </a>
              </li>

              <li class="nav-item">
                <a class="nav-link d-flex align-items-center gap-2 <?php echo $currentPage === 'manager.apartments' ? 'selected' : 'highlight'; ?>" aria-current="page" href="index.php?page=manager.apartments">
                  <svg class="bi" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                      <use xlink:href="<?php echo $currentPage === 'manager.apartments' ? '#building-fill' : '#building'; ?>" />
                  </svg>
                  Apartments
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link d-flex align-items-center gap-2 <?php echo $currentPage === 'manager.tenants' ? 'selected' : 'highlight'; ?>" aria-current="page" href="index.php?page=manager.tenants">
                  <svg class="bi" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                      <use xlink:href="<?php echo $currentPage === 'manager.tenants' ? '#people-fill' : '#people'; ?>" />
                  </svg>
                  Tenants
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link d-flex align-items-center gap-2 <?php echo $currentPage === 'manager.payments' ? 'selected' : 'highlight'; ?>" aria-current="page" href="index.php?page=manager.payments">
                  <svg class="bi" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                      <use xlink:href="<?php echo $currentPage === 'manager.payments' ? '#credit-card-fill' : '#credit-card'; ?>" />
                  </svg>
                  Payments
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link d-flex align-items-center gap-2 <?php echo $currentPage === 'tenant.transactionLog' ? 'selected' : 'highlight'; ?>" aria-current="page" href="index.php?page=manager.transactionLog">
                    <svg class="bi" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                        <use xlink:href="<?php echo $currentPage === 'tenant.transactionLog' ? '#cash-stack' : '#cash-stack'; ?>" />
                    </svg>
                    Transaction History
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link d-flex align-items-center gap-2 <?php echo $currentPage === 'manager.maintenance' ? 'selected' : 'highlight'; ?>" aria-current="page" href="index.php?page=manager.maintenance">
                  <svg class="bi" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                      <use xlink:href="<?php echo $currentPage === 'manager.maintenance' ? '#wrench-fill' : '#wrench'; ?>" />
                  </svg>
                  Maintenance
                </a>
              </li>
            </ul>
              

            <h6
              class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-body-secondary text-uppercase">
              <span>MANAGER</span>
            </h6>
            <ul class="nav flex-column mb-auto">
              <li class="nav-item">
                <a class="nav-link d-flex align-items-center gap-2 <?php echo $currentPage === 'manager.announcements' ? 'selected' : 'highlight'; ?>" aria-current="page" href="index.php?page=manager.announcements&staff_id=<?php echo htmlspecialchars($_SESSION['staff_id']); ?>">
                  <svg class="bi" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                      <use xlink:href="<?php echo $currentPage === 'manager.announcements' ? '#megaphone-fill' : '#megaphone'; ?>" />
                  </svg>
                  Announcements
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link d-flex align-items-center gap-2 <?php echo $currentPage === 'manager.viewLogs' ? 'selected' : 'highlight'; ?>" aria-current="page" href="index.php?page=manager.viewLogs&staff_id=<?php echo htmlspecialchars($_SESSION['staff_id']); ?>">
                  <svg class="bi" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                      <use xlink:href="<?php echo $currentPage === 'manager.viewLogs' ? '#calendar-range-fill' : '#calendar-range'; ?>" />
                  </svg>
                  Activity Log
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link d-flex align-items-center gap-2 <?php echo $currentPage === 'admin.analytics' ? 'selected' : 'highlight'; ?>" aria-current="page" href="index.php?page=manager.analytics">
                  <svg class="bi" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                      <use xlink:href="<?php echo $currentPage === 'admin.analytics' ? '#bar-chart-line-fill' : '#bar-chart-line'; ?>" />
                  </svg>
                  Analytics
                </a>
              </li>
              <!-- <li class="nav-item">
                <a class="nav-link d-flex align-items-center gap-2 <?php echo $currentPage === 'manager.report' ? 'selected' : 'highlight'; ?>" aria-current="page" href="index.php?page=manager.report">
                  <svg class="bi" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                      <use xlink:href="<?php echo $currentPage === 'manager.report' ? '#clipboard-fill' : '#clipboard'; ?>" />
                  </svg>
                  Report
                </a>
              </li> -->
            </ul>

            <hr class="my-3">

          <ul class="nav flex-column mb-auto">
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center gap-2 highlight" href="#" data-bs-toggle="modal" data-bs-target="#staffAccountModal">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-gear" viewBox="0 0 16 16">
                        <use xlink:href="#person-gear" />
                    </svg>
                    Account
                </a>
            </li>



            <li class="nav-item">
              <a id="logout-link" class="nav-link d-flex align-items-center gap-2 highlight" href="handlers/common/logout.php">
                  <svg id="logout-icon" class="bi" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                      <use xlink:href="#door-closed" class="door-icon" />
                  </svg>
                  Logout
              </a>
            </li>
          </ul>
          <br>
        </div>
      </div>
    </div>

