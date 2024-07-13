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
        <?php foreach ($invoice as $invoiceItem): ?>
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h4 class="card-title">Bill To</h4>
                            <p class="card-text">
                                <strong><?php echo $invoiceItem['firstName']; ?> <?php echo $invoiceItem['middleName']; ?> <?php echo $invoiceItem['lastName']; ?></strong><br>
                                <strong>Address:</strong> <?php echo $invoiceItem['apartmentAddress']; ?><br>
                                <strong>Phone:</strong> <?php echo $invoiceItem['phoneNumber']; ?><br>
                                <strong>Email:</strong> <?php echo $invoiceItem['emailAddress']; ?>
                            </p>
                        </div>
                        <div class="col-md-4">
                            <h4 class="card-title">Invoice Details</h4>
                            <ul class="list-unstyled">
                                <li><strong>Invoice #:</strong> <?php echo $invoiceItem['invoice_ID']; ?></li>
                                <li><strong>Date Issued:</strong> <?php echo $invoiceItem['dateIssued']; ?></li>
                                <li><strong>Due Date:</strong> <?php echo $invoiceItem['dueDate']; ?></li>
                                <li><strong>Status:</strong> HARDCODED Unpaid</li><br><br>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="card-title">Items</h4>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">Description</th>
                                            <th class="text-center">Amount (₱)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center">1</td>
                                            <td class="text-center">Rent</td>
                                            <td class="text-center">+ ₱<?php echo $invoiceItem['rent']; ?></td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">2</td>
                                            <td class="text-center">Maintenance</td>
                                            <td class="text-center">+ ₱<?php echo $invoiceItem['maintenance']; ?></td>
                                        </tr>
                                        <?php $counter = 3; ?>
                                        <?php foreach ($billItems as $billItem): ?>
                                            <tr>
                                                <td class="text-center"><?php echo $counter++; ?></td>
                                                <td class="text-center">Bill #<?php echo htmlspecialchars($billItem['bill_ID']); ?></td>
                                                <td class="text-center">- ₱<?php echo htmlspecialchars($billItem['amountPaid']); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="text-end"><strong>Tax (5%): </strong>₱<?php echo $invoiceItem['tax']; ?></div>
                            </div>
                            <div class="row">
                                <div class="text-end"><strong>Total Amount: </strong>₱<?php echo $invoiceItem['totalAmount']; ?></div>
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
                    <input type="hidden" id="invoice_ID" name="invoice_ID" value="<?php echo $invoiceItem['invoice_ID']; ?>">
                    
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