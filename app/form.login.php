<!-- Login Form -->
 <?php unset($_SESSION['emailForgot']); ?>
<form action="login.handler.php" method="POST" class="text-center" id="loginForm">
    <br><br><br>
    <h1 class="h3 mb-3 fw-normal">Login</h1>
    <br>
    <div class="form-floating mb-3">
        <input type="text" class="form-control" id="floatingInput" name="username" placeholder="Username" required>
        <label for="floatingInput">Username</label>
    </div>
    <div class="form-floating mb-3 position-relative">
        <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
        <label for="floatingPassword">Password</label>
        <span class="field-icon toggle-password position-absolute end-0 top-50 translate-middle-y">
            <i class="fas fa-eye"></i>
        </span>
    </div>

    <div class="d-flex justify-content-start my-3">
        <a href="?login[page]=form.forgot" class="text-decoration-none forgot-password-link">Forgot password?</a>
    </div>
    <div class="d-flex justify-content-start my-3">
        <a href="landing.php" class="text-decoration-none">Don't have an account?</a>
    </div>

    <button class="btn btn-primary w-100 py-2" type="submit">Login</button>
    <p class="mt-5 mb-3 text-body-secondary">&copy; C-Apartments 2024</p>
</form>

<script>
    // Password Eye Feature
    document.querySelector('.toggle-password').addEventListener('click', function() {
        const passwordInput = document.querySelector('#password');
        const eyeIcon = this.querySelector('i.fas');
    
        if (passwordInput) {
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.classList.remove('fa-eye');
            eyeIcon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            eyeIcon.classList.remove('fa-eye-slash');
            eyeIcon.classList.add('fa-eye');
        }
        } else {
        console.error('Password input not found');
        }
    });
</script>