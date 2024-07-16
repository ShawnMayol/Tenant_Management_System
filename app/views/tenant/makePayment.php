<div class="col-md-8">
    <div class="progress mb-4">
        <div class="progress-bar bg-primary" role="progressbar" style="width: 66%;" aria-valuenow="66" aria-valuemin="0" aria-valuemax="100"></div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center mb-4">
                <div class="step-number me-3">
                    <div class="step-box">2</div>
                </div>
                <h2 class="card-title mb-0">Make your payment</h2><br>
            </div>
            <p class="ms-4">Make sure to take a picture or screenshot upon payment.</p>
            <div class="container d-flex justify-content-center align-items-center">
                <img src="https://cdn.shopify.com/s/files/1/0006/2842/4756/files/Gcash-QR_480x480.png?v=1682492347" alt="" class="img-fluid">
            </div>
            <button type="button" class="btn btn-primary mt-4" style="width: 100%;" onclick="redirectToCheckout()">Proceed to Checkout</button>
        </div>
    </div>
</div>

<script>
    function redirectToCheckout() {
        window.location.href = '?page=tenant.payment&payment=checkout';
    }
</script>

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
