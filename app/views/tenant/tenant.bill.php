<?php
    include('handlers/tenant/retrieveBill.php'); // Include the script to retrieve bills
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Transactions</h1>
    </div>

    <div class="row">
        <div class="col-md-12">
            <?php if (!empty($bills)): ?>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Invoice #</th>
                                <th>Payment Method</th>
                                <th>Amount Paid</th>
                                <th>Overpayment</th>
                                <th>Outstanding Balance</th>
                                <th>Payment Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($bills as $bill): ?>
                                <tr>
                                    <td><?php echo $bill['invoice_ID']; ?></td>
                                    <td><?php echo $bill['paymentMethod']; ?></td>
                                    <td><?php echo $bill['amountPaid']; ?></td>
                                    <td><?php echo $bill['overpayment']; ?></td>
                                    <td><?php echo $bill['outstandingBalance']; ?></td>
                                    <td><?php echo $bill['paymentDate']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p>No bills found.</p>
            <?php endif; ?>
        </div>
    </div>
</main>