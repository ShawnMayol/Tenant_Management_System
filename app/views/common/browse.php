<!DOCTYPE html>
<html lang="en" data-bs-theme="auto">

<?php
session_start();
include '../../core/database.php';
// print_r($_SESSION);
?>

<head>
    <script src="../../assets/dist/js/color-modes.js"></script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Browse Apartments | C-Apartments</title>
    <link rel="icon" href="../../assets/src/svg/c-logo.svg">

    <link rel="stylesheet" href="../../assets/dist/css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="../../assets/src/css/themes .css"> -->
</head>

<style>
    * {
    margin: 0px;
    padding: 0px;
    }

    .bi {
    vertical-align: -.125em;
    fill: currentColor;
    }

    .btn-bd-primary {
    --bd-violet-bg: #712cf9;
    --bd-violet-rgb: 112.520718, 44.062154, 249.437846;

    --bs-btn-font-weight: 600;
    --bs-btn-color: var(--bs-white);
    --bs-btn-bg: var(--bd-violet-bg);
    --bs-btn-border-color: var(--bd-violet-bg);
    --bs-btn-hover-color: var(--bs-white);
    --bs-btn-hover-bg: #6528e0;
    --bs-btn-hover-border-color: #6528e0;
    --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
    --bs-btn-active-color: var(--bs-btn-hover-color);
    --bs-btn-active-bg: #5a23c8;
    --bs-btn-active-border-color: #5a23c8;
    }

    .bd-mode-toggle {
    z-index: 99999;
    }

    .bd-mode-toggle .dropdown-menu .active .bi {
    display: block !important;
    }
    .navbar {
    position: absolute;
    z-index: 999;
    }
    .navbar-brand {
        display: flex;
        justify-content: center;
        width: 100%;
    }
    .logo {
        padding-left: 10px;
        height: 100px;
    }

    #banner {
        height: 60px;
    }
</style>

<body class="bg-body-tertiary">
    <?php include ('../../core/themes.php') ?>

    <nav class="navbar justify-content-center align-items-center">
        <a class="navbar-brand logo" href="landing.php">
            <img id="banner" src="../../assets/src/svg/c.svg" alt="Website Logo">
        </a>
    </nav>

    <main class="col-md-12 col-lg-12 px-md-4">
        
    </main>

    <script src="../../assets/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>