<?php
include ('handlers/admin/retrieveTransactionLog.php');
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Transaction History</h1>
    </div>

    <div class="row">
        <div class="col-md-12">

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">Bill #</th>
                            <th class="text-center">Amount Paid</th>
                            <th class="text-center">Payment Date</th>
                            <th class="text-center">Transaction Status</th>
                            <th class="text-center">Received By: </th>
                            <th class="text-center">Proof of Payment</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($paymentsLog as $plogs):
                            $baseUrl = '/TMSv11/app/uploads/payment/';          // Change TMSv11 to Tenant_Management_System

                            // Generate the URL dynamically
                            $imageUrl = $baseUrl . htmlspecialchars($plogs['proofOfPayment']);
                            ?>

                            <tr>
                                <td class="text-center"><?php echo $plogs['bill_ID']; ?></td>
                                <td class="text-center"><?php echo $plogs['paymentAmount']; ?></td>
                                <td class="text-center"><?php echo $plogs['paymentDate']; ?></td>
                                <td class="text-center"><?php echo $plogs['paymentStatus']; ?></td>
                                <td class="text-center"><?php echo $plogs['Staff']; ?></td>
                                <td class="text-center">
                                <a href="<?= $imageUrl ?>" target="_blank" class="btn btn-primary">
                                    View
                                </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>