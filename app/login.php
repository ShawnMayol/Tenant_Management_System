<!doctype html>
<html lang="en" data-bs-theme="auto">

<?php 
    session_start();

    // print_r($_SESSION);

?>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="assets/src/img/c-logo.svg" rel="icon">
    <!-- <title><?php //echo isset($_SESSION['title']) ? $_SESSION['title'] : '' ?></title> -->
     <title>Login | C-Apartments</title>

    <!-- eye icon for password -->
    <link href="assets/dist/font-awesome/css/all.min.css" rel="stylesheet">    

    <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/src/css/login.css" rel="stylesheet">
    <link href="assets/src/css/loading.css" rel="stylesheet">
    <link href="assets/src/css/themes.css" rel="stylesheet">
</head>

<style>
    .navbar {
        position:absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 90px;
        display: flex;
        align-items: center;
        justify-content: center;
        /* background: rgba(0, 0, 0, 0.7); */
        z-index: 999;
        text-align: center;
        }
        .navbar-brand {
        display: flex;
        justify-content: center;
        width: 100%;
        }
        .logo {
        /* margin-top: -20px; */
        height: 100px;
        }

        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            display: none;
            padding: 10px 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        .notification.alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .notification.alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

</style>

<body class="d-flex align-items-center py-4 bg-body-tertiary">
    
    <div id="notification-container" class="notification-container"></div>

    <!-- LOADING ANIMATION -->
    <!-- <div id="loading-screen">
        <img src="assets/src/img/loading.gif" alt="Loading...">
    </div> -->

    <?php include('themes.php') ?>

    <nav class="navbar">
        <a class="navbar-brand logo" href="landing.php">
            <img src="assets/src/svg/c.svg" alt="Website Logo">
        </a>
    </nav>

    <div class="container">
        <div class="log-in">
            <?php 

                if (isset($_SESSION['error'])) {
                    echo '<script>';
                    echo 'showNotification("' . $_SESSION['error'] . '", "danger");';
                    echo '</script>';

                    // Unset the error message to clear it after displaying
                    unset($_SESSION['error']);
                }

                // Similarly, for success messages
                if (isset($_SESSION['success'])) {
                    echo '<script>';
                    echo 'showNotification("' . $_SESSION['success'] . '", "success");';
                    echo '</script>';

                    // Unset the success message to clear it after displaying
                    unset($_SESSION['success']);
                }

                $page = isset($_GET['login']['page']) ? $_GET['login']['page'] : 'form.login'; 
                include $page . '.php'; 
                //include 'form.forgot.php';
            ?>
        </div>
    </div>


    <script>
        function showNotification(message, type) {
            const notification = document.createElement('div');
            notification.className = `notification alert-${type}`;
            notification.textContent = message;

            document.body.appendChild(notification);

            setTimeout(function() {
                notification.style.opacity = '0';
                setTimeout(function() {
                    document.body.removeChild(notification);
                }, 600); // Remove after fade out animation (600ms)
            }, 3000); // Show for 3 seconds
        }
    </script>

    

    <script src="assets/src/js/loading.js"></script>
    <script src="assets/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>