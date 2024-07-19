<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4" data-theme="<?php echo $theme; ?>">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <div class="row">
            <div class="col">
                <h1 class="h1 m-0">Payment</h1>
            </div>
        </div>
    </div>
    <div class="container mt-5">
        <div class="row">
            <?php if(isset($_GET['payment'])) {
                $page = $_GET['payment'];
            } else {
                $page = 'paymentOptions';
            }
            ?>
            <?php include $page .'.php'; ?>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">Assessment Summary</h2>
                        <p><strong>Total Amount Due:</strong> ₱<?php echo number_format($totalBalance, 2); ?></p>
                        <p><strong>Last Payment Date:</strong> <?php echo date('F j, Y', strtotime($lastPaymentDate)); ?></p>
                        <p><strong>Last Payment Amount:</strong> ₱<?php echo number_format($lastPaymentAmount, 2); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<footer class="py-3 my-4">
    <ul class="nav justify-content-center border-bottom pb-3 mb-3">
      <li class="nav-item"><a href="<?= htmlspecialchars($dashboardPage) ?>" class="nav-link px-2 text-body-secondary">Home</a></li>
      <li class="nav-item"><a href="views/common/browse.php" class="nav-link px-2 text-body-secondary">Apartments</a></li>
      <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">Pricing</a></li>
      <li class="nav-item"><a href="?page=../../views/common/faq" class="nav-link px-2 text-body-secondary">FAQs</a></li>
      <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">About</a></li>
    </ul>
    <p class="text-center text-body-secondary">&copy; C-Apartments 2024</p>
  </footer>