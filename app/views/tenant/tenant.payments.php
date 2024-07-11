<?php 
    include('handlers/tenant/retrieveTransactionLog.php');
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
      <h1 class="h2">Transaction History</h1>
  </div>
  
  <div class="table-responsive">
      <table class="table table-striped table-hover">
          <thead>
              <tr>
                  <th>Bill ID</th>
                  <th>Payment Method</th>
                  <th>Amount Paid</th>
                  <th>Overpayment</th>
                  <th>Payment Date</th>
              </tr>
          </thead>
          <tbody>
              <?php if (!empty($paymentHistory)): ?>
                  <?php foreach ($paymentHistory as $payment): ?>
                      <tr>
                          <td><?= htmlspecialchars($payment['bill_ID']) ?></td>
                          <td><?= htmlspecialchars($payment['paymentMethod']) ?></td>
                          <td><?= htmlspecialchars($payment['amountPaid']) ?></td>
                          <td><?= htmlspecialchars($payment['overpayment']) ?></td>
                          <td><?= htmlspecialchars($payment['paymentDate']) ?></td>
                      </tr>
                  <?php endforeach; ?>
              <?php else: ?>
                  <tr>
                      <td colspan="5">No payment history found.</td>
                  </tr>
              <?php endif; ?>
          </tbody>
      </table>
  </div>
</main>