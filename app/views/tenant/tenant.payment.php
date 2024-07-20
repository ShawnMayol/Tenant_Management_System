<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

<?php
include ('core/database.php');

// Retrieve user ID from session
$user_id = $_SESSION['user_id'];

// Query bills associated with the lease
$billSql = "SELECT b.* 
            FROM bill b
            JOIN tenant t ON t.lease_ID = b.lease_ID
            JOIN user us ON us.tenant_ID = t.tenant_ID
            WHERE us.user_ID = ? AND b.billStatus = 'Pending'
            ORDER BY b.bill_ID DESC
            LIMIT 1";
$retbillStmt = $conn->prepare($billSql);
$retbillStmt->bind_param("i", $user_id);
$retbillStmt->execute();
$billResult = $retbillStmt->get_result();

$retBill = null;
if ($billResult->num_rows > 0) {
    $retBill = $billResult->fetch_assoc();
}

$totalAmount = $retBill['amountDue'] + $retBill['lateFees'];

$retbillStmt->close();
$conn->close();
?>

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
            <?php 
            if (isset($_GET['payment'])) {
                $page = $_GET['payment'];
            } else {
                $page = 'paymentOptions';
            }
            include $page . '.php'; 
            ?>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">Payment Summary</h2>
                        <?php if (!empty($retBill)): ?>
                            <p><strong>Total Amount Due:</strong> ₱<?php echo number_format($totalAmount, 2); ?></p>
                            <p><strong>Bill Date:</strong> <?php echo date('F j, Y', strtotime($retBill['billDate'])); ?></p>
                            <p><strong>Due Date:</strong> <?php echo date('F j, Y', strtotime($retBill['dueDate'])); ?></p>
                        <?php else: ?>
                            <p>No pending bills.</p>
                        <?php endif; ?>
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
