<?php 
    include('handlers/manager/retrievePaymentProof.php'); 
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
                            <td>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#paymentModal<?php echo $row['paymentProof_ID']; ?>">
                                    View
                                </button>
                            </td>
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

<?php if ($result->num_rows > 0): ?>
    <?php $result->data_seek(0); // Reset pointer to the beginning of the result set ?>
    <?php while($row = $result->fetch_assoc()): ?>
        <div class="modal fade" id="paymentModal<?php echo $row['paymentProof_ID']; ?>" tabindex="-1" aria-labelledby="paymentModalLabel<?php echo $row['invoice_ID']; ?>" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="paymentModalLabel<?php echo $row['invoice_ID']; ?>">Payment Proof Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Invoice ID:</strong> <?php echo $row['invoice_ID']; ?></p>
                        <p><strong>Payment Method:</strong> <?php echo $row['paymentMethod']; ?></p>
                        <p><strong>Upload Date:</strong> <?php echo $row['uploadDate']; ?></p>
                        <p><strong>Status:</strong> <?php echo ucfirst($row['status']); ?></p>
                        <p><strong>Verified By:</strong> <?php echo $staffID ?></p>
                        <img src="a<?php echo $row['filePath']; ?>" alt="Payment Proof" style="width: 100%; height: auto;">
                    </div>
                    <div class="modal-footer">
                    <form action="http://localhost/Tenant_Management_System/app/handlers/manager/updatePayment.php" method="post" onsubmit="alert('Form is being submitted');">
                        <input type="hidden" name="paymentProofID" value="<?php echo $row['paymentProof_ID']; ?>">
                        <input type="hidden" name="staffID" value="<?php echo $staffID; ?>">
                        <button type="submit" name="status" value="paid" class="btn btn-success">Accept</button>
                        <button type="submit" name="status" value="rejected" class="btn btn-danger">Decline</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </form>

                    </div>
                </div>
            </div>
        </div>
    <?php endwhile; ?>
<?php endif; ?>
