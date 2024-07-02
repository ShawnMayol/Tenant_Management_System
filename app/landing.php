<!DOCTYPE html>
<html lang="en">

<?php 
    session_start();
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="assets/src/svg/c-logo.svg" rel="icon">
    <title>Tenant Management System | C-Apartments</title>
    
    <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/src/css/landing.css" rel="stylesheet">
    <link href="assets/src/css/loading.css" rel="stylesheet">

<style>
    .left-side {
        background-image: url('assets/src/img/tenant.jpg');
    }
    .right-side {
        background-image: url('assets/src/img/browse.jpg');
    }
</style>

</head>

<body>
    <div id="loading-screen">
        <img src="assets/src/img/loading.gif" alt="Loading...">
    </div>

    <div class="container-fluid">
        <div class="row no-gutters">
            <div class="col-md-6 half-page left-side">
                <div class="overlay">
                    <h1>Already a Tenant?</h1>
                    <a href="login/login.php">Login</a>
                </div>
            </div>
            <div class="col-md-6 half-page right-side">
                <div class="overlay">
                    <h1>New Here?</h1>
                    <a href="apartments.php">Browse Apartments</a>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/src/js/loading.js"></script>
</body>
</html>
