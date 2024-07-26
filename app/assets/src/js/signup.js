document.addEventListener('DOMContentLoaded', checkPass);

// Match Cofirm Password Feature
function checkPass(params) {
    document.getElementById('confirmPassword').addEventListener('input', function () {
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirmPassword').value;
        const warningMessage = document.getElementById('passwordWarning');
        const signupButton = document.getElementById('signup-btn');
        
            if (password === '' || confirmPassword === '') {
                warningMessage.style.display = 'none';
                signupButton.disabled = true;
            } else if (password !== confirmPassword) {
                warningMessage.style.display = 'block';
                signupButton.disabled = true;
            } else {
                warningMessage.style.display = 'none';
                signupButton.disabled = false;
            }
    });
}

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

  // Confirm Password Eye Feature
  document.querySelector('.toggle-confirm-password').addEventListener('click', function() {
    const passwordInput = document.querySelector('#confirmPassword'); 
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










