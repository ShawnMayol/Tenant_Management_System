<?php
  include('handlers/tenant/retrieveInvoice.php');
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Invoice</h1>
    </div>

    <div class="row">
        <div class="col-md-12">
            <?php if (!empty($invoices)): ?>
              <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                          <th>Invoice ID</th>
                          <th>Rent</th>
                          <th>Tax</th>
                          <th>Maintenance</th>
                          <th>Total Amount</th>
                          <th>Due Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($invoices as $invoice): ?>
                            <tr>
                              <td><?php echo $invoice['invoice_ID']; ?></td>
                              <td><?php echo $invoice['rent']; ?></td>
                              <td><?php echo $invoice['tax']; ?></td>
                              <td><?php echo $invoice['maintenance']; ?></td>
                              <td><?php echo $invoice['totalAmount']; ?></td>
                              <td><?php echo $invoice['dueDate']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
              </div>
            <?php else: ?>
                <p>No invoices found.</p>
            <?php endif; ?>
        </div>
    </div>
</main>
