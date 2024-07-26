<link href="assets/dist/font-awesome/css/all.min.css" rel="stylesheet">    
<?php ?>
<style>
    .field-icon:hover {
    cursor: pointer ;
    }
    .field-icon {
        padding: .375rem .75rem;
    }
</style>

<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="handlers/common/updatePassword.php" method="POST"> <!-- Form action for updating password -->
                <div class="modal-header">
                    <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="oldPassword" class="form-label">Old Password:</label>
                        <div class="position-relative">
                            <input type="password" class="form-control py-2" id="oldPassword" name="oldPassword" required>
                            <span class="field-icon toggle-password position-absolute end-0 top-50 translate-middle-y">
                                <i class="fas fa-eye"></i>
                            </span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="newPassword" class="form-label">New Password:</label>
                        <div class="position-relative">
                            <input type="password" class="form-control py-2" id="newPassword" name="newPassword" required>
                            <span class="field-icon toggle-password position-absolute end-0 top-50 translate-middle-y">
                                <i class="fas fa-eye"></i>
                            </span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="confirmPassword" class="form-label">Confirm Password:</label>
                        <div class="position-relative">
                            <input type="password" class="form-control py-2" id="confirmPassword" name="confirmPassword" required>
                            <span class="field-icon toggle-password position-absolute end-0 top-50 translate-middle-y">
                                <i class="fas fa-eye"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-outline-danger">Change Password & Sign out</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    // Password Eye Feature
    document.addEventListener('DOMContentLoaded', function() {
        const togglePasswordIcons = document.querySelectorAll('.toggle-password');
        togglePasswordIcons.forEach(icon => {
            icon.addEventListener('click', function() {
                const passwordInput = icon.previousElementSibling;
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