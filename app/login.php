<!doctype html>
<html lang="en" data-bs-theme="auto">

<?php 
    session_start();
?>

<head>
    <script src="assets/dist/js/color-modes.js"></script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="assets/src/img/web-icon.png" rel="icon">
    <title><?php echo isset($_SESSION['title']) ? $_SESSION['title'] : '' ?></title>

    <!-- eye icon for password -->
    <link href="assets/dist/font-awesome/css/all.min.css" rel="stylesheet">    

    <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/src/css/login.css" rel="stylesheet">
    <link href="assets/src/css/themes.css" rel="stylesheet">
</head>

<body class="d-flex align-items-center py-4 bg-body-tertiary">

<?php include('themes.php') ?>
    <!-- LOG IN FORM -->
    <div class="container">
        <div class="log-in">
        <form action="login_handler.php" method="POST">
            <img class="mb-4" src="assets/src/img/web-icon.png" alt="" width="72" height="60">
            <h1 class="h3 mb-3 fw-normal">C Apartments</h1>

            <div class="form-floating">
            <input type="" class="form-control" id="floatingInput" name="email" placeholder="name@example.com" required>
            <label for="floatingInput">Email</label>
            </div>
            <div class="form-floating">
            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
            <label for="floatingPassword">Password</label>
            <span class="field-icon toggle-password position-absolute end-0 top-50 translate-middle-y">
                <i class="fas fa-eye"></i>
            </span>
            </div>

            <div class="d-flex justify-content-start my-3">
            <a href="#" class="text-decoration-none">Forgot password?</a>
            </div>
            <div class="d-flex justify-content-start my-3">
            <a href="signup.php" class="text-decoration-none">Don't have an account?</a>
            </div>

            <button class="btn btn-primary w-100 py-2" type="submit">Login</button>
            <p class="mt-5 mb-3 text-body-secondary">&copy; C-Apartments 2024</p>
        </form>
        </div>
    </div>
    <script src="assets/src/js/login.js"></script>
    <script src="assets/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>