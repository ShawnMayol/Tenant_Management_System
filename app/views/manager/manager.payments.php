<?php 
    include('handlers/manager/retrievePaymentProof.php'); 
    include('handlers/manager/retrievePaymentProofDetails.php'); 
    include('handlers/manager/updatePayment.php'); 
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Payments</h1>
    </div>

    <!-- Payment Proof Table -->
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">Invoice ID</th>
                    <th scope="col">Upload Date</th>
                    <th scope="col">Status</th>
                    <th scope="col">Payment Proof ID</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['invoice_ID']; ?></td>
                            <td><?php echo $row['uploadDate']; ?></td>
                            <td><?php echo ucfirst($row['status']); ?></td>
                            <td><?php echo $row['paymentProof_ID']; ?></td>
                            <td>
                            <a href="index.php?page=manager.paymentProofDetails&paymentProof_ID=<?php echo $row['paymentProof_ID']; ?>" class="btn btn-primary">
                                View
                            </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">No payment proofs found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</main>
