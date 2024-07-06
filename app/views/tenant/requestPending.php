<!-- Request Pending Notification -->
<?php 
    session_start();
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="auto">

<head>
    <script src="../../assets/dist/js/color-modes.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href="../../assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../assets/src/css/login.css" rel="stylesheet">
    <link rel="icon" href="../../assets/src/svg/c-logo.svg">
    <link href="../../assets/src/css/themes.css" rel="stylesheet">
    <title>Thank you | C-Apartments</title>
</head>
<style>
    .glass-navbar {
        background: rgba(0, 0, 0, 0.3); /* White background with 70% opacity */
        backdrop-filter: blur(0.5px); /* Blur effect */
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Subtle shadow */
    }
    html, body {
        height: 100%;
        margin: 0;
        overflow: hidden;
    }
    .center-screen {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100%;
        text-align: center;
    }
</style>

<body class="d-flex align-items-center py-4 bg-body-tertiary">
    <?php include ('../../core/themes.php') ?>  

    <nav class="navbar navbar-light fixed-top justify-content-center align-items-center glass-navbar">
        <a class="navbar-brand logo" href="../../views/common/landing.php">
            <img id="banner" src="../../assets/src/svg/c.svg" alt="Website Logo" class="img-fluid" style="max-height: 80px;">
        </a>
    </nav>
    
    <div class="container center-screen">
        <div>
            <h1 class="h3 pt-3 mb-3 fw-normal">REQUEST SUBMITTED</h1>
            <div class="container py-3">
                <div>
                    <p>Please keep your phone and email active for notifications. Thank you.</p>
                </div>
                <div>
                    <p id="redirectMessage">Redirecting to home page in <span id="countdown">15</span> seconds...</p>
                </div>
            </div>
            
            <div>
                <p class="mt-2 mb-3 text-body-secondary">&copy; C-Apartments 2024</p>
            </div>
        </div>
    </div>

    <script>
        let countdown = 15;
        const countdownElement = document.getElementById('countdown');
        const interval = setInterval(() => {
            countdown--;
            countdownElement.textContent = countdown;
            if (countdown === 0) {
                clearInterval(interval);
                window.location.href = '../../views/common/landing.php';
            }
        }, 1000);
    </script>

    <script src="../../assets/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>