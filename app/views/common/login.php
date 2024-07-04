<!doctype html>
<html lang="en" data-bs-theme="auto">

<?php 
    session_start();

    if (isset($_SESSION['success'])) {
        $success = $_SESSION['success'];
        echo '<script>alert("' . $success . '");</script>';
        unset($_SESSION['success']);
    }

    // print_r($_SESSION);
    // print_r($_GET);
?>

<head>
    <script src="../../assets/dist/js/color-modes.js"></script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="../../assets/src/img/c-logo.svg" rel="icon">
     <title>Login | C-Apartments</title>

    <!-- eye icon for password -->
    <link href="../../assets/dist/font-awesome/css/all.min.css" rel="stylesheet">    

    <link href="../../assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../assets/src/css/login.css" rel="stylesheet">
    <link href="../../assets/src/css/themes.css" rel="stylesheet">
</head>

<style>
        .glass-navbar {
        background: rgba(0, 0, 0, 0.3); /* White background with 70% opacity */
        backdrop-filter: blur(0.5px); /* Blur effect */
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Subtle shadow */
    }
</style>

<body class="d-flex align-items-center py-4 bg-body-tertiary">
    
    <div id="notification-container" class="notification-container"></div>

    <?php include('../../core/themes.php') ?>

    <nav class="navbar navbar-light fixed-top justify-content-center align-items-center glass-navbar">
        <a class="navbar-brand logo" href="landing.php">
            <img id="banner" src="../../assets/src/svg/c.svg" alt="Website Logo" class="img-fluid" style="max-height: 50px;">
        </a>
    </nav>

    <div class="container">
        <div class="log-in">
            <?php 
                $page = isset($_GET['login']['page']) ? $_GET['login']['page'] : 'login.formInput'; 
                include $page . '.php'; 
            ?>
        </div>
    </div>

    <script src="../../assets/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>