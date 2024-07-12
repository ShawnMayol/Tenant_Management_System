<?php ?>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rejectModalLabel">Confirm Rejection</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-danger fw-bold">Notify the requestor before rejecting.</p>
                <div class="mb-3">
                    <label for="managerPassword" class="form-label">Enter your Password</label>
                    <input type="password" class="form-control" id="managerPassword" placeholder="Enter your password">
                </div>
                <input type="hidden" id="requestID" value="<?php echo $requestID; ?>"> <!-- Assuming you set $requestID in your PHP -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmRejectButton">Reject</button>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('confirmRejectButton').addEventListener('click', function() {
    var password = document.getElementById('managerPassword').value;
    var requestID = document.getElementById('requestID').value;

    if (password) {
        var form = document.createElement('form');
        form.method = 'POST';
        form.action = 'handlers/manager/rejectRequest.php';

        var inputPassword = document.createElement('input');
        inputPassword.type = 'hidden';
        inputPassword.name = 'managerPassword';
        inputPassword.value = password;

        var inputRequestID = document.createElement('input');
        inputRequestID.type = 'hidden';
        inputRequestID.name = 'requestID';
        inputRequestID.value = requestID;

        form.appendChild(inputPassword);
        form.appendChild(inputRequestID);
        document.body.appendChild(form);
        form.submit();
    } else {
        alert('Please enter your password to confirm.');
    }
});
</script>
