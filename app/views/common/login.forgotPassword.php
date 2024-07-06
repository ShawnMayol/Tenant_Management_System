<!-- Forgot Password Form -->
<?php 
    if (isset($_SESSION['error'])) {
        $error = $_SESSION['error'];
        echo '<script>alert("' . $error . '");</script>';
        unset($_SESSION['error']);
    }
?>
<form action="../../handlers/common/forgotPassword.php" method="POST" class="text-center mt-5" id="forgotPasswordForm">
    <br><br><br>
    <h1 class="h3 mb-3 fw-normal">Forgot Password?</h1>
    <br>
    <p>Enter your Email Address associated with your account and we'll get you right back on track in no time.</p>
    <br>
    <div class="form-floating mb-3 position-relative">
        <input type="email" class="form-control" id="emailForgot" name="emailForgot" placeholder="Email" required>
        <label for="emailForgot">Email</label>
        <!-- <div id="emailTooltip" class="tooltip-warning">Email does not exist.</div> -->
    </div>
    <div class="d-flex justify-content-start my-3">
        <a href="?login[page]=login.formInput" class="text-decoration-none go-back-link">Go back to login</a>
    </div>
    <button class="btn btn-primary w-100 py-2" type="submit">Next</button>
    <p class="mt-5 mb-3 text-body-secondary">&copy; C-Apartments 2024</p>
</form>