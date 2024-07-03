<!-- New Password Form -->
<?php 
    if (isset($_SESSION['error'])) {
        $error = $_SESSION['error'];
        echo '<script>alert("' . $error . '");</script>';
        unset($_SESSION['error']);
    }
?>
<form action="../../handlers/common/changePassword.php" method="POST" class="text-center" id="newPasswordForm">
    <br><br><br>
    <h1 class="h3 mb-3 fw-normal">Change Password</h1>
    <br>
    <div class="form-floating mb-3">
        <input type="password" class="form-control" id="newPassword" name="newPassword" placeholder="New Password" required>
        <label for="newPassword">New Password</label>
        <span class="field-icon toggle-password position-absolute end-0 top-50 translate-middle-y" data-target="newPassword">
            <i class="fas fa-eye"></i>
        </span>
    </div>
    <div class="form-floating mb-3">
        <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" required>
        <label for="confirmPassword">Confirm Password</label>
        <span class="field-icon toggle-password position-absolute end-0 top-50 translate-middle-y" data-target="confirmPassword">
            <i class="fas fa-eye"></i>
        </span>
    </div>
    <div class="d-flex justify-content-start my-3">
        <a href="?login[page]=login.formInput" class="text-decoration-none go-back-link">Go back to login</a>
    </div>
    <button class="btn btn-primary w-100 py-2" type="submit">Change Password</button>
    <p class="mt-5 mb-3 text-body-secondary">&copy; C-Apartments 2024</p>
</form>

<script>
    // Password Eye Feature
    document.addEventListener('DOMContentLoaded', function() {
        const togglePasswordIcons = document.querySelectorAll('.toggle-password');
        
        togglePasswordIcons.forEach(icon => {
            icon.addEventListener('click', function() {
                const targetId = icon.dataset.target;
                const passwordInput = document.getElementById(targetId);
                const eyeIcon = icon.querySelector('i.fas');
    
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
        });
    });
</script>
