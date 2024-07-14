<?php
    include('handlers/tenant/retrieveTransactionLog.php');
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Transaction History</h1>
    </div>

    <div class="row">
        <div class="col-md-12">
            
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Invoice #</th>
                                <th>Payment Method</th>
                                <th>Amount Paid</th>
                                <th>Overpayment</th>
                                <th>Outstanding Balance</th>
                                <th>Verified By</th>
                                <th>Transaction Status</th>
                                <th>Payment Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($bill as $bill): ?>
                                <tr>
                                    <td><?php echo $bill['invoice_ID']; ?></td>
                                    <td><?php echo $bill['paymentMethod']; ?></td>
                                    <td><?php echo $bill['amountPaid']; ?></td>
                                    <td><?php echo $bill['overpayment']; ?></td>
                                    <td><?php echo $bill['outstandingBalance']; ?></td>
                                    <td><?php echo $bill['receivedBy']; ?></td>
                                    <td><?php echo $bill['transactionStatus']; ?></td>
                                    <td><?php echo $bill['paymentDate']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            
        </div>
    </div>
</main>
