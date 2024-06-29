<!DOCTYPE html>
<html lang="en">
<head>
    <script src="assets/dist/js/color-modes.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/src/css/landing_page.css">
    <title>Landing Page</title>
</head>
<body class="bg-body-tertiary">
    <?php include('themes.php') ?>

    <div class="container min-vh-100 d-flex justify-content-center align-items-center">
        <div class="row">
            <div class="col-md-6 mb-4">
                <a href="login.php">
                    <div class="card custom-card">
                        <div class="card-body d-flex justify-content-center align-items-center">
                            <h5 class="card-title text-center">Login</h5>
                        </div>
                    </div>
                </a>
            </div>
            
            <div class="col-md-6 mb-4">
                <a href="apartment_catalogue.php">
                    <div class="card custom-card">
                        <div class="card-body d-flex justify-content-center align-items-center">
                            <h5 class="card-title text-center">View Apartments</h5>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <script src="assets/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>