<style>
  .sidebar {
    /* display: none; */
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

<?php include('views/common/modal.account.php'); ?>
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
                <a class="nav-link d-flex align-items-center gap-2 <?php echo $currentPage === 'tenant.dashboard' ? 'selected' : 'highlight'; ?>" aria-current="page" href="index.php?page=tenant.dashboard">
                  <svg class="bi" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                      <use xlink:href="<?php echo $currentPage === 'tenant.dashboard' ? '#house-fill' : '#house'; ?>" />
                  </svg>
                  Dashboard
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link d-flex align-items-center gap-2 <?php echo $currentPage === 'tenant.viewUser' ? 'selected' : 'highlight'; ?>" aria-current="page" href="index.php?page=tenant.viewUser&tenant_id=<?php echo $tenant_id; ?>">
                  <svg class="bi" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                      <use xlink:href="<?php echo $currentPage === 'tenant.viewUser' ? '#file-earmark-text-fill' : '#file-earmark-text'; ?>" />
                  </svg>
                  Lease
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link d-flex align-items-center gap-2 <?php echo $currentPage === 'tenant.apartment' ? 'selected' : 'highlight'; ?>" aria-current="page" href="index.php?page=tenant.apartment&apartment=<?php echo $apartmentNumber; ?>">
                  <svg class="bi" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                      <use xlink:href="<?php echo $currentPage === 'tenant.apartment' ? '#building-fill' : '#building'; ?>" />
                  </svg>
                  Apartment
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link d-flex align-items-center gap-2 <?php echo $currentPage === 'tenant.viewBilling' ? 'selected' : 'highlight'; ?>" aria-current="page" href="index.php?page=tenant.viewBilling&tenant_id=<?php echo $tenant_id; ?>">
                    <svg class="bi" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                        <use xlink:href="<?php echo $currentPage === 'tenant.viewBilling' ? '#credit-card-fill' : '#credit-card'; ?>" />
                    </svg>
                    Assessment
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link d-flex align-items-center gap-2 <?php echo $currentPage === 'tenant.transactionLog' ? 'selected' : 'highlight'; ?>" aria-current="page" href="index.php?page=tenant.transactionLog">
                    <svg class="bi" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                        <use xlink:href="<?php echo $currentPage === 'tenant.transactionLog' ? '#cash-stack' : '#cash-stack'; ?>" />
                    </svg>
                    Transaction History
                </a>
              </li>
            </ul>

            <h6
              class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-body-secondary text-uppercase">
              <span>TENANT</span>
            </h6>
            <ul class="nav flex-column mb-auto">
              <li class="nav-item">
                <a class="nav-link d-flex align-items-center gap-2 <?php echo $currentPage === 'tenant.payment' ? 'selected' : 'highlight'; ?>" aria-current="page" href="index.php?page=tenant.payment&payment=paymentOptions">
                  <svg class="bi" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                      <use xlink:href="<?php echo $currentPage === 'tenant.payment' ? '#credit-card-fill' : '#credit-card'; ?>" />
                  </svg>
                  Make payment
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link d-flex align-items-center gap-2 <?php echo $currentPage === 'tenant.maintenance' ? 'selected' : 'highlight'; ?>" aria-current="page" href="index.php?page=tenant.maintenance">
                  <svg class="bi" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                      <use xlink:href="<?php echo $currentPage === 'tenant.maintenance' ? '#wrench-fill' : '#wrench'; ?>" />
                  </svg>
                  Request Maintenance
                </a>
              </li>
            </ul>

            <hr class="my-3">

          <ul class="nav flex-column mb-auto">
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center gap-2 highlight" href="#" data-bs-toggle="modal" data-bs-target="#tenantAccountModal">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-gear" viewBox="0 0 16 16">
                        <use xlink:href="#person-gear" />
                    </svg>
                    Account
                </a>
            </li>

            <?php include('views/common/modal.account.php'); ?>
            <?php include('views/common/modal.changePassword.php'); ?>

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

