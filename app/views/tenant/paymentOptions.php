<style>
    .card-hover:hover {
        cursor: pointer;
    }
</style>
<div class="col-md-8">
    <div class="progress mb-4">
        <div class="progress-bar bg-primary" role="progressbar" style="width: 33%;" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center mb-4">
                <div class="step-number me-3">
                    <div class="step-box">1</div>
                </div>
                <h2 class="card-title mb-0">How would you like to pay?</h2>
            </div>
            <div class="payment-option card card-hover mb-3" data-option="gcash">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title">Gcash</h5>
                            <p class="card-text">Pay using Gcash.</p>
                        </div>
                        <div class="col-auto">
                            <img src="https://www.rappler.com/tachyon/2021/11/gcash.jpeg" alt="" class="rounded" style="width: 50px;">
                        </div>
                    </div>
                </div>
            </div>
            <div class="payment-option card card-hover mb-3" data-option="bank_transfer">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title">Bank Transfer</h5>
                            <p class="card-text">Transfer funds via bank.</p>
                        </div> 
                        <div class="col-auto">
                            <img src="https://i0.wp.com/stocksilog.com/wp-content/uploads/2015/05/PNB-logo.gif?ssl=1" alt="" class="rounded" style="height: 50px;">
                            <img src="https://a3x2k4e2.rocketcdn.me/wp-content/uploads/2019/08/BPI-logo.jpg" alt="" class="rounded" style="height: 50px;">
                            <img src="https://loadcentral.com.ph/wp-content/uploads/2021/10/bdo-logo-2.png" alt="" class="rounded" style="height: 50px;">
                        </div>
                    </div>
                </div>
            </div>
            <div class="payment-option card-hover card mb-3" data-option="paymaya">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title">PayMaya</h5>
                            <p class="card-text">Use PayMaya for payment.</p>
                        </div>
                        <div class="col-auto">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/9/9a/PayMaya_Logo.png" alt="" class="rounded" style="height: 50px;">
                        </div>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-primary mt-3" id="continueBtn" style="width: 100%;" disabled>Proceed to Payment Amount</button>
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
</style>

<script>
    const paymentOptions = document.querySelectorAll('.payment-option');
    const continueBtn = document.getElementById('continueBtn');

    paymentOptions.forEach(option => {
        option.addEventListener('click', function() {
            paymentOptions.forEach(opt => opt.classList.remove('selected'));
            option.classList.add('selected');

            continueBtn.disabled = false;
        });
    });

    continueBtn.addEventListener('click', function() {
        const selectedOption = document.querySelector('.payment-option.selected');
        if (selectedOption) {
            const paymentMethod = selectedOption.getAttribute('data-option');
            
            window.location.href = '?page=tenant.payment&payment=makePayment&method=' + encodeURIComponent(paymentMethod);
        } else {
            alert('Please select a payment option.');
        }
    });
</script>
