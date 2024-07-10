<?php include('handlers/tenant/retrieveInvoice.php'); ?>

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
                                <th>#</th>
                                <th>Apartment Address</th>
                                <th>Date Issued</th>
                                <th>Due Date</th>
                                <th>Action</th> <!-- Added for the View button -->
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                            $counter = 1;
                            foreach ($invoices as $invoice): ?>
                                <tr>
                                    <td><?php echo $counter++; ?></td>
                                    <td><?php echo $invoice['apartmentAddress']; ?></td>
                                    <td><?php echo $invoice['dateIssued']; ?></td>
                                    <td><?php echo $invoice['dueDate']; ?></td>
                                    <td>
                                        <!-- Button to trigger modal -->
                                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#invoiceModal" data-invoice-id="<?php echo $invoice['invoice_ID']; ?>">
                                            View Invoice
                                        </button>
                                    </td>
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

<div class="modal fade" id="invoiceModal" tabindex="-1" aria-labelledby="invoiceModalLabel" aria-hidden="true">
  
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row mb-3">
                        <div class="col-12 col-sm-6 col-md-8">
                            <h4>Bill To</h4>
                            <address>
                                <strong><?php echo $invoice['firstName']; ?> <?php echo $invoice['middleName']; ?> <?php echo $invoice['lastName']; ?></strong><br>
                                <?php echo $invoice['apartmentAddress']; ?><br>
                                Phone: <?php echo $invoice['phoneNumber']; ?><br>
                                Email: <?php echo $invoice['emailAddress']; ?>
                            </address>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4">
                            <h4>Invoice Details</h4>
                            <div class="row">
                                <div class="col-6">Invoice #: </div>
                                <div class="col-6 text-end"><?php echo $invoice['invoice_ID']; ?></div>
                                <div class="col-6">Date Issued:</div>
                                <div class="col-6 text-end"><?php echo $invoice['dateIssued']; ?></div>
                                <div class="col-6">Due Date:</div>
                                <div class="col-6 text-end"><?php echo $invoice['dueDate']; ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                      <div class="col-12">
                          <div class="table-responsive">
                              <table class="table table-striped">
                                  <thead>
                                      <tr>
                                          <th scope="col">#</th>
                                          <th scope="col">Description</th>
                                          <th scope="col" class="text-end">Amount (₱)</th>
                                      </tr>
                                  </thead>
                                  <tbody class="table-group-divider">
                                      <?php
                                      // Assuming $invoiceDetails is an array containing details like rent and maintenance
                                      $itemCount = 1;
                                      foreach ($invoices as $item):
                                      ?>
                                      <tr>
                                          <th scope="row"><?php echo $itemCount++; ?></th>
                                          <td>Rent</td>
                                          <td class="text-end">₱<?php echo $item['rent']; ?></td>
                                      </tr>
                                      <tr>
                                          <th scope="row"><?php echo $itemCount++; ?></th>
                                          <td>Maintenance</td>
                                          <td class="text-end">₱<?php echo $item['maintenance']; ?></td>
                                      </tr>
                                      <!-- Add more rows for other items if needed -->
                                      <?php endforeach; ?>
                                  </tbody>
                                  <tfoot>
                                      <tr>
                                        <td colspan="2" class="text-end"><strong>Tax (5%):</strong></td>
                                        <td class="text-end"><strong>₱<?php echo $item['tax']; ?></strong></td>
                                      </tr>
                                      <tr>
                                          <td colspan="2" class="text-end"><strong>Total Amount:</strong></td>
                                          <td class="text-end"><strong>₱<?php echo $item['totalAmount']; ?></strong></td>
                                      </tr>
                                  </tfoot>
                              </table>
                          </div>
                      </div>
                  </div>

                    <div class="row">
                        <div class="col-12 text-end">
                            <button type="submit" class="btn btn-primary mb-3">Download Invoice</button>
                            <button type="submit" class="btn btn-danger mb-3">Submit Payment</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <!-- Additional buttons if necessary -->
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">