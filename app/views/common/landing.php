<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<?php 
    session_start();

    // for debugging
    // print_r($_SESSION);
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="../../assets/src/svg/c-logo.svg" rel="icon">
    <title>Tenant Management System | C-Apartments</title>
    
    <link href="../../assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../assets/src/css/landing.css" rel="stylesheet">

<style>
    .left-side {
        background-image: url('../../assets/src/img/tenant.jpg');
    }
    .right-side {
        background-image: url('../../assets/src/img/browse.jpg');
    }
    .glass-navbar {
        background: rgba(0, 0, 0, 0.3); /* White background with 70% opacity */
        backdrop-filter: blur(0.5px); /* Blur effect */
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Subtle shadow */
    }
</style>

</head>

<body>
    <?php //include('../../core/loading.php'); ?>

    <nav class="navbar navbar-light fixed-top justify-content-center align-items-center glass-navbar">
        <a class="navbar-brand logo" href="landing.php">
            <img id="banner" src="../../assets/src/svg/c.svg" alt="Website Logo" class="img-fluid" style="max-height: 50px;">
        </a>
    </nav>

    <div class="container-fluid">
        <div class="row no-gutters">
            <div class="col-md-6 half-page left-side">
                <div class="overlay">
                    <h1>Already a Tenant?</h1>
                    <a href="../../views/common/login.php?login[page]=login.formInput">Login</a>
                </div>  
            </div>
            <div class="col-md-6 half-page right-side">
                <div class="overlay">
                    <h1>New Here?</h1>
                    <a href="browse.php">Browse Apartments</a>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
