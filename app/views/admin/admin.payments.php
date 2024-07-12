<?php 
    include('handlers/admin/retrievePaymentProof.php'); 
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Payments - temporary ui gonna change later</h1>
    </div>

    <!-- Payment Proof Table -->
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Invoice ID</th>
                    <th scope="col">Picture - gonna place in view later</th>
                    <th scope="col">Comment - in view</th>
                    <th scope="col">Upload Date</th>
                    <th scope="col">Status</th>
                    <th scope="col">View</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['paymentProof_ID']; ?></td>
                            <td><?php echo $row['invoice_ID']; ?></td>
                            <td>
                                <img src="a<?php echo $row['filePath']; ?>" alt="Payment Proof" style="width: 100px; height: auto;">
                            </td>
                            <td><?php echo $row['comment']; ?></td>
                            <td><?php echo $row['uploadDate']; ?></td>
                            <td><?php echo ucfirst($row['status']); ?></td>
                            <td><?php echo $row['verifiedBy']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center">No payment proofs found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</main>
