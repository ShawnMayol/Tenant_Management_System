<!-- Request Pending Notification -->
<?php 
    session_start();
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

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
            <img id="banner" src="../../assets/src/svg/c.svg" alt="Website Logo" class="img-fluid" style="max-height: 50px;">
        </a>
    </nav>
    <div id="confetti"></div>
    
    <div class="container center-screen">
        <div>
            <h1 class="h3 pt-3 mb-1 fw-normal">Thank You For Choosing C-Apartments!</h1>
            <div class="container py-3">
                <div>
                    <p>Your request has been submitted.</p>
                    <p>Please keep your phone and email active for notifications.</p>
                    <p>We will contact you once we have reviewed your request.</p>
                </div>
                <br>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../../assets/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


<style>
    #confetti {
    left: 0;
    position: fixed;
    right: 0; 
    top: -160px;
    z-index: 10000;
    }
    
    #confetti .ball {
    animation-iteration-count :infinite !important;
    -webkit-animation-iteration-count :infinite !important;
    border-radius: 50%;
    cursor: default;
    display: inline-block;
    height: 10px;
    user-select: none; 
    -webkit-user-select: none; 
    width: 10px;
    } 
    
    @-webkit-keyframes falling-left {
    0% {-webkit-transform: translate3d(0,0,0);opacity: 1;}
    10% { opacity: 0;}
    20% { opacity: 1;}
    30% { opacity: 0;}
    40% { opacity: 1;}
    50% { opacity: 0;}
    60% { opacity: 1;}
    70% { opacity: 0;}
    80% { opacity: 1;}
    90% { opacity: 0;}
    100% {-webkit-transform: translate3d(0,120vh,0); opacity: 1;}
    }
    
    @keyframes falling-left {
    0% {-webkit-transform: translate3d(0,0,0);opacity: 1;}
    10% { opacity: 0;}
    20% { opacity: 1;}
    30% { opacity: 0;}
    40% { opacity: 1;}
    50% { opacity: 0;}
    60% { opacity: 1;}
    70% { opacity: 0;}
    80% { opacity: 1;}
    90% { opacity: 0;}
    100% {-webkit-transform: translate3d(0,120vh,0); opacity: 1;}
    }
    
    #confetti .ball:nth-child(2n) {
    -webkit-animation: falling-left linear;
    animation: falling-left linear ;
    }
    
    @-webkit-keyframes falling-right {
    0% {-webkit-transform: translate3d(0,0,0);opacity: 0;}
    10% { opacity: 1;}
    20% { opacity: 0;}
    30% { opacity: 1;}
    40% { opacity: 0;}
    50% { opacity: 1;}
    60% { opacity: 0;}
    70% { opacity: 1;}
    80% { opacity: 0;}
    90% { opacity: 1;}
    100% {-webkit-transform: translate3d(0,120vh,0); opacity: 0;}
    }
    
    @keyframes falling-right {
    0% {-webkit-transform: translate3d(0,0,0);opacity: 1;}
    10% { opacity: 0;}
    20% { opacity: 1;}
    30% { opacity: 0;}
    40% { opacity: 1;}
    50% { opacity: 0;}
    60% { opacity: 1;}
    70% { opacity: 0;}
    80% { opacity: 1;}
    90% { opacity: 0;}
    100% {-webkit-transform: translate3d(0,120vh,0); opacity: 0;} 
    }
    
    #confetti .ball:nth-of-type(2n+1) {
    -webkit-animation: falling-right linear ;
    animation: falling-right linear;
    }
</style>

<script>
    jQuery("document").ready(function($){
    var flakes = '',
    randomColor;
    for(var i = 0, len = 400; i < len; i++) {
    randomColor = Math.floor(Math.random()*16777215).toString(16);
    flakes += '<div class="ball" style="background: #'+randomColor;
    flakes += '; animation-duration: '+(Math.random() * 9 + 2)+'s; animation-delay: ';
    flakes += (Math.random() * 2 + 0)+'s;"></div>';
    }
    document.getElementById('confetti').innerHTML = flakes;
    });
</script>