<?php 
    include('handlers/tenant/retrieveInvoice.php'); 
    include('handlers/tenant/submitPaymentProof.php'); 
?>

<style>
    /* Center the modal within the main content */
    .modal-dialog-centered {
        display: flex;
        align-items: center;
        min-height: calc(100vh - 1rem);
    }
    
    .modal-content {
        margin: auto;
    }
</style>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Invoice</h1>
    </div>

    <?php if ($invoice): ?>
        <?php foreach ($invoice as $invoice): ?>
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h4 class="card-title">Bill To</h4>
                            <p class="card-text">
                                <strong><?php echo $invoice['firstName']; ?> <?php echo $invoice['middleName']; ?> <?php echo $invoice['lastName']; ?></strong><br>
                                <strong>Address:</strong> <?php echo $invoice['apartmentAddress']; ?><br>
                                <strong>Phone:</strong> <?php echo $invoice['phoneNumber']; ?><br>
                                <strong>Email:</strong> <?php echo $invoice['emailAddress']; ?>
                            </p>
                        </div>
                        <div class="col-md-4">
                            <h4 class="card-title">Invoice Details</h4>
                            <ul class="list-unstyled">
                                <li><strong>Invoice #:</strong> <?php echo $invoice['invoice_ID']; ?></li>
                                <li><strong>Date Issued:</strong> <?php echo $invoice['dateIssued']; ?></li>
                                <li><strong>Due Date:</strong> <?php echo $invoice['dueDate']; ?></li>
                                <li><strong>Status:</strong> Unpaid</li><br><br>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="card-title">Items</h4>
                            <div class="row">
                                <div class="col-md-4"><strong>Description</strong></div>
                                <div class="col-md-4 text-center"><strong>Amount (₱)</strong></div>
                                <div class="col-md-4 text-end"><strong>Total</strong></div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-4">Rent</div>
                                <div class="col-md-4 text-center">₱<?php echo $invoice['rent']; ?></div>
                                <div class="col-md-4 text-end">₱<?php echo $invoice['rent']; ?></div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">Maintenance</div>
                                <div class="col-md-4 text-center">₱<?php echo $invoice['maintenance']; ?></div>
                                <div class="col-md-4 text-end">₱<?php echo $invoice['maintenance']; ?></div>
                            </div>
                            <!-- Add more rows for other items if needed -->
                            <hr>
                            <div class="row">
                                <div class="col-md-8 text-end"><strong>Tax (5%):</strong></div>
                                <div class="col-md-4 text-end">₱<?php echo $invoice['tax']; ?></div>
                            </div>
                            <div class="row">
                                <div class="col-md-8 text-end"><strong>Total Amount:</strong></div>
                                <div class="col-md-4 text-end">₱<?php echo $invoice['totalAmount']; ?></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-3">
                        <div class="col-md-12 text-end">
                            <!-- Button to trigger modal -->
                            <button type="button" class="btn btn-danger mb-3" data-bs-toggle="modal" data-bs-target="#proofModal">
                                Send Proof of Payment
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No invoice found.</p>
    <?php endif; ?>
</main>

<!-- Modal -->
<div class="modal fade" id="proofModal" tabindex="-1" aria-labelledby="proofModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="handlers/tenant/submitPaymentProof.php" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="proofModalLabel">Send Proof of Payment</h5>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="invoice_ID" name="invoice_ID" value="<?php echo $invoice['invoice_ID']; ?>">
                    
                    <!-- Payment Method Select -->
                    <div class="mb-3">
                        <label for="paymentMethod" class="form-label">Payment Method</label>
                        <select class="form-control" id="paymentMethod" name="paymentMethod" required>
                            <option value="" disabled selected>What payment method was used</option>
                            <option value="Cash">Cash</option>
                            <option value="GCash">GCash</option>
                            <option value="Credit Card">Credit Card</option>
                            <option value="Bank Transfer">Bank Transfer</option>
                        </select>
                    </div>

                    <!-- File upload input -->
                    <div class="mb-3">
                        <label for="proofFile" class="form-label">Upload Picture</label>
                        <input type="file" class="form-control" id="proofFile" name="proofFile" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
