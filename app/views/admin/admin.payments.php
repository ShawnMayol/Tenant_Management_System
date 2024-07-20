<?php
include ('handlers/manager/retrievePaymentProof.php');
?>
<link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    .payment-th,
    .payment-td {
        text-align: center;
    }

    .payment-td {
        vertical-align: middle;
    }
</style>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Payments</h1>
    </div>

    <!-- Payment Proof Table -->
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">Bill ID/Tenant</th>
                    <th scope="col" class="payment-th">Payment Amount</th>
                    <th scope="col" class="payment-th">Payment Date</th>
                    <th scope="col" class="payment-th">Payment Proof</th>
                    <th scope="col" class="payment-th">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()):
                        $baseUrl = '/TMSv10/app/uploads/request/';

                        // Generate the URL dynamically
                        $imageUrl = $baseUrl . htmlspecialchars($row['proofOfPayment']);
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['bill_ID']) . '<br>' . $row['Name']; ?></td>
                            <td class="payment-td"><?php echo htmlspecialchars($row['paymentAmount']); ?></td>
                            <td class="payment-td"><?php echo htmlspecialchars(ucfirst($row['paymentDate'])); ?></td>
                            <td class="payment-td">
                                <a href="<?= $imageUrl ?>" target="_blank" class="btn btn-primary">
                                    View
                                </a>
                            </td>
                            <td class="payment-td">
                                <button class="receive-btn btn btn-success"
                                    data-bill-id="<?php echo htmlspecialchars($row['bill_ID']); ?>"
                                    data-payment-id="<?php echo htmlspecialchars($row['payment_ID']); ?>">Received</button>
                                <button class="reject-btn btn btn-danger"
                                    data-payment-id="<?php echo htmlspecialchars($row['payment_ID']); ?>">Reject</button>
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

        <!-- The Modal -->
        <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="rejectModalLabel">Reject Payment</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="rejectForm">
                            <input type="hidden" id="rejectPaymentId" name="paymentId">
                            <div class="mb-3">
                                <label for="rejectNote" class="form-label">Reason for Rejection:</label>
                                <textarea class="form-control" id="rejectNote" name="note" rows="4" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-danger">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    </div>
</main>
<script src="assets/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.querySelectorAll('.receive-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            var paymentId = this.getAttribute('data-payment-id');
            var billId = this.getAttribute('data-bill-id');
            console.log('Receive button clicked for payment ID:', paymentId);
            console.log('Bill ID:', billId);

            fetch('handlers/manager/updatePayment.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'paymentId=' + encodeURIComponent(paymentId) + '&status=Received' + '&billId=' + encodeURIComponent(billId)
            })
                .then(response => response.text())
                .then(responseText => {
                    console.log('Response text:', responseText);
                    if (responseText.trim() === 'Success') {
                        alert('Payment status updated to received.');
                        location.reload();
                    } else {
                        alert('Error updating payment status: ' + responseText);
                    }
                })
                .catch(error => console.error('Error:', error));
        });
    });

    var rejectModal = new bootstrap.Modal(document.getElementById('rejectModal'), {
        keyboard: false
    });

    document.querySelectorAll('.reject-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            var paymentId = this.getAttribute('data-payment-id');
            document.getElementById('rejectPaymentId').value = paymentId;
            rejectModal.show();
        });
    });

    document.getElementById('rejectForm').addEventListener('submit', function(event) {
        event.preventDefault();
        var paymentId = document.getElementById('rejectPaymentId').value;
        var note = document.getElementById('rejectNote').value;

        fetch('handlers/manager/updatePayment.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'paymentId=' + encodeURIComponent(paymentId) + '&status=Rejected' + '&note=' + encodeURIComponent(note)
        })
            .then(response => response.text())
            .then(responseText => {
                console.log('Response text:', responseText);
                if (responseText.trim() === 'Success') {
                    alert('Payment status updated to rejected.');
                    location.reload();
                } else {
                    alert('Error updating payment status: ' + responseText);
                }
            })
            .catch(error => console.error('Error:', error));
    });
</script>
