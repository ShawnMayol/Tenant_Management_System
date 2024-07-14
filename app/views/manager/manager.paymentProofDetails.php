<?php 
    include('handlers/manager/retrievePaymentProofDetails.php'); 
    include('handlers/manager/updatePayment.php'); 
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Payment Proof Details</h1>
    </div>

    <?php if ($data): ?>
        <div class="card mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-5">
                        <h4>Invoice</h4><hr>
                        <h4 class="card-title">Bill To</h4>
                        <p class="card-text">
                            <strong><?php echo htmlspecialchars($data['firstName']); ?> <?php echo htmlspecialchars($data['middleName']); ?> <?php echo htmlspecialchars($data['lastName']); ?></strong><br>
                            <strong>Address:</strong> <?php echo htmlspecialchars($data['apartmentAddress']); ?><br>
                            <strong>Phone:</strong> <?php echo htmlspecialchars($data['phoneNumber']); ?><br>
                            <strong>Email:</strong> <?php echo htmlspecialchars($data['emailAddress']); ?>
                        </p>

                        <h4 class="card-title">Invoice Details</h4>
                        <ul class="list-unstyled">
                            <li><strong>Invoice #:</strong> <?php echo htmlspecialchars($data['invoice_ID']); ?></li>
                            <li><strong>Date Issued:</strong> <?php echo htmlspecialchars($data['dateIssued']); ?></li>
                            <li><strong>Due Date:</strong> <?php echo htmlspecialchars($data['dueDate']); ?></li>
                            <li><strong>Status:</strong> <?php echo htmlspecialchars(ucfirst($data['status'])); ?></li><br><br>
                        </ul>

                        <h4 class="card-title">Items</h4>
                        <div class="row">
                            <div class="col-md-4"><strong>Description</strong></div>
                            <div class="col-md-4 text-center"><strong>Amount (₱)</strong></div>
                            <div class="col-md-4 text-end"><strong>Total</strong></div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-4">Rent</div>
                            <div class="col-md-4 text-center">₱<?php echo htmlspecialchars($data['rent']); ?></div>
                            <div class="col-md-4 text-end">₱<?php echo htmlspecialchars($data['rent']); ?></div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">Maintenance</div>
                            <div class="col-md-4 text-center">₱<?php echo htmlspecialchars($data['maintenance']); ?></div>
                            <div class="col-md-4 text-end">₱<?php echo htmlspecialchars($data['maintenance']); ?></div>
                        </div>
                        <!-- Add more rows for other items if needed -->
                        <hr>
                        <div class="row">
                            <div class="col-md-8 text-end"><strong>Tax (5%):</strong></div>
                            <div class="col-md-4 text-end">₱<?php echo htmlspecialchars($data['tax']); ?></div>
                        </div>
                        <div class="row">
                            <div class="col-md-8 text-end"><strong>Total Amount:</strong></div>
                            <div class="col-md-4 text-end">₱<?php echo htmlspecialchars($data['totalAmount']); ?></div>
                        </div>
                    </div>

                    <div class="col-md-1 d-flex align-items-center justify-content-center">
                        <div style="border-left: 1px solid #000; height: 100%;"></div>
                    </div>

                    <div class="col-md-6">
                        <h4 class="card-title">Payment Proof</h4>
                        <hr>
                        <img src="a<?php echo htmlspecialchars($data['imageProof']); ?>" alt="Payment Proof" style="width: 100%; height: auto;">

                        <form action="handlers/manager/updatePayment.php" method="POST">
                            <div class="mt-3">
                                <label for="amountPaid" class="form-label">Amount Paid (₱)</label>
                                <input type="number" class="form-control" id="amountPaid" name="amountPaid" required>
                            </div>

                            <input type="hidden" name="paymentProofID" value="<?php echo $data['paymentProof_ID']; ?>">
                            
                            <div id="rejectReason" style="display: none;" class="mt-3">
                                <label for="rejectComment" class="form-label">Reason for Rejection</label>
                                <textarea class="form-control" id="rejectComment" name="rejectComment" rows="3"></textarea>
                            </div>

                            <div class="mt-3">
                                <button type="submit" name="action" value="accept" class="btn btn-success">Accept Payment</button>
                                <button type="button" id="rejectButton" class="btn btn-danger">Reject Payment</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-danger" role="alert">
            Payment proof details not found.
        </div>
    <?php endif; ?>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('rejectButton').addEventListener('click', function() {
            document.getElementById('rejectReason').style.display = 'block';
        });
    });
</script>