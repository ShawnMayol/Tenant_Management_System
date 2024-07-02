<!doctype html>
<html lang="en" data-bs-theme="auto">

<?php
session_start();
?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="../assets/src/svg/c-logo.svg" rel="icon">
    <!-- <title><?php //echo isset($_SESSION['title']) ? $_SESSION['title'] : '' ?></title> -->
    <title>Login | C-Apartments</title>

    <!-- eye icon for password -->
    <link href="../assets/dist/font-awesome/css/all.min.css" rel="stylesheet">

    <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/src/css/login.css" rel="stylesheet">
    <link href="../assets/src/css/loading.css" rel="stylesheet">
    <link href="../assets/src/css/themes.css" rel="stylesheet">
    <?php include('../aesthetics/themes.php'); ?>
</head>


<body class="bg-body-tertiary">

    <!-- LOADING ANIMATION -->
    <div id="loading-screen">
        <img src="../assets/src/img/loading.gif" alt="Loading...">
    </div>

    <div class="container">

        <!--LOGO-->
        <div class="brand-logo">
            <a  href="landing.php">
                <img src="../assets/src/svg/c.svg" alt="Website Logo">
            </a>
        </div>

        <!-- LOG IN FORM -->
        <div class="log-in">
            <form action="login_handler.php" method="POST" class="text-center">

                <div class="form-floating mb-3">
                    <input type="" class="form-control" id="floatingInput" name="email"
                        placeholder="name@example.com" required>
                    <label for="floatingInput">Email</label>
                </div>
                <div class="form-floating mb-3 position-relative">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password"
                        required>
                    <label for="floatingPassword">Password</label>
                    <span class="field-icon toggle-password position-absolute end-0 top-50 translate-middle-y">
                        <i class="fas fa-eye"></i>
                    </span>
                </div>

                <div class="d-flex justify-content-start my-3">
                    <a href="#" class="text-decoration-none">Forgot password?</a>
                </div>
                <div class="d-flex justify-content-start my-3">
                    <a href="../landing.php" class="text-decoration-none">Don't have an account?</a>

                </div>

                <button class="btn btn-primary w-100 py-2" type="submit">Login</button>
                <p class="mt-5 mb-3 text-body-secondary">Copyright &copy; C-Apartments - Tenant Management System 2024
                </p>
            </form>
        </div>
    </div>


    <script src="../assets/src/js/loading.js"></script>
    <script src="../assets/src/js/login.js"></script>
    <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>