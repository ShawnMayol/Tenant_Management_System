<div class="col-md-8">
    <div class="progress mb-4">
        <div class="progress-bar bg-primary" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center mb-4">
                <div class="step-number me-3">
                    <div class="step-box">3</div>
                </div>
                <h2 class="card-title mb-0">Upload your proof of payment</h2>
            </div>
            <form method="POST" action="handlers/tenant/uploadProof.php" id="paymentForm">
                <div class="mb-3">
                    <label for="paymentAmount" class="form-label">Payment Amount</label>
                    <input type="number" class="form-control" id="paymentAmount" placeholder="Payment Amount" name="paymentAmount" value="0" pattern="[0-9]*" required>
                    <div class="invalid-feedback">
                        Please enter a valid amount.
                    </div>
                </div>
                <div class="mb-3">
                    <label for="proofOfPayment" class="form-label">Proof of Payment</label>
                    <input type="file" class="form-control" id="proofOfPayment" name="proofOfPayment" accept="image/*, .pdf" required>
                    <small class="form-text text-muted">Upload a clear image or scan of your proof of payment.</small>
                </div>
                <button type="submit" class="btn btn-primary mt-3" style="width: 100%;">Confirm Payment</button>
            </form>
        </div>
    </div>
</div>
<style>
    .step-box {
        background-color: #007bff;
        color: white;
        width: 30px;
        height: 30px;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 50%;
    }
    .step-number {
        flex-shrink: 0;
    }
    input:invalid {
        border-color: #dc3545;
    }
    input[type="file"]:invalid {
        border-color: grey; 
    }
    .invalid-feedback {
        color: #dc3545;
        display: none;
        margin-top: 0.25rem;
    }
    input:invalid + .invalid-feedback {
        display: block;
    }
</style>