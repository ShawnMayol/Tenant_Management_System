<!doctype html>
<html lang="en" data-bs-theme="auto">

<?php 
    session_start();

    //$_SESSION['title'] = 'Tenant Management System' // initialize title
    // Redirect to login.php if user is not logged in yet

    // if(!isset($_SESSION['login_id']))
    // header('location:login.php');
?>

<head>
    <script src="assets/dist/js/color-modes.js"></script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="assets/src/svg/c-logo.svg" rel="icon">
    <!-- dynamic title -->
    <!-- <title><?php //echo isset($_SESSION['title']) ? $_SESSION['title'] : '' ?></title>  -->
     <title>Dashboard | C-Apartments</title>

    <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/src/css/dashboard.css" rel="stylesheet">
    <link href="assets/src/css/themes.css" rel="stylesheet">
    <link href="assets/src/css/loading.css" rel="stylesheet">
    
    <!-- causes problems -->
    <!-- <link href="assets/src/css/sidebar.css" rel="stylesheet"> -->
</head>

<body class="d-flex align-items-center py-4 bg-body-tertiary">

    <!-- LOADING ANIMATION -->
    <div id="loading-screen">
        <img src="assets/src/img/loading.gif" alt="Loading...">
    </div>

    <?php //include('topbar.php'); ?>

    <!-- themes button -->
    <?php include('themes.php') ?>
    
<div class="container">
    
    <!-- sidebar -->
    <?php include('sidebar.php') ?>
    <?php //include('x.php') ?>


    <!-- Div to display the content -->
    <div id="display-content">
    <!-- Content will be dynamically loaded here -->
    </div>

</div>

<script src="assets/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/src/js/user.js"></script>
<script src="assets/src/js/menu.js"></script>
<script src="assets/src/js/loading.js"></script>

<!-- para asa ni ahahah -->
<!-- di mo gana ang themes if naa ni siya -->
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script> -->
<!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script> -->

</body>

</html>