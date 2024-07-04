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
    <link rel="stylesheet" href="../../assets/src/css/apartments.css">
    <link rel="stylesheet" href="../../assets/src/css/themes .css">
    <!-- <link href="assets/src/css/loading.css" rel="stylesheet"> -->
    <?php include ('../../core/themes.php') ?>
</head>

<body class="bg-body-tertiary">

    <header class="navbar sticky-top bg-dark flex-md-nowrap p-0 shadow" data-bs-theme="dark">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6 text-white" href="../../index.php">
            <img src="../../assets/src/svg/c.svg" alt="Company Logo" style="width: 100%; height: 80%">
        </a>

        <?php //include('topbar.php'); ?>

    </header>

    <main class="col-md-12 col-lg-12 px-md-4">
        <!-- Apartment List -->
        <div class="container mt-4 text-center">
            <div class="row">
                <div class="container card px-4" id="cards-container">
                    <div class="row custom-row">

                        <!-- Retrieve Info from databse -->
                        <?php

                        $sql = "SELECT apartmentNumber, apartmentType, rentPerMonth, apartmentStatus, maxOccupants FROM apartment";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <div class="col-xl-3 col-md-4 mb-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div id="carouselExample<?= $row['apartmentNumber']; ?>" class="carousel slide">
                                                <div class="carousel-inner">
                                                    <div class="carousel-item active">
                                                        <img src="../../assets/src/img/apartment-img-template-1.jpg"
                                                            class="d-block w-100" alt="...">
                                                    </div>
                                                    <div class="carousel-item">
                                                        <img src="../../assets/src/img/apartment-img-template-1.jpg"
                                                            class="d-block w-100" alt="...">
                                                    </div>
                                                    <div class="carousel-item">
                                                        <img src="../../assets/src/img/apartment-img-template-1.jpg"
                                                            class="d-block w-100" alt="...">
                                                    </div>
                                                </div>
                                                <button class="carousel-control-prev" type="button"
                                                    data-bs-target="#carouselExample<?= $row['apartmentNumber']; ?>"
                                                    data-bs-slide="prev">
                                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                    <span class="visually-hidden">Previous</span>
                                                </button>
                                                <button class="carousel-control-next" type="button"
                                                    data-bs-target="#carouselExample<?= $row['apartmentNumber']; ?>"
                                                    data-bs-slide="next">
                                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                    <span class="visually-hidden">Next</span>
                                                </button>
                                            </div>
                                            <div class="apartment-info">
                                                <h5 class="card-title">Apartment <?= $row['apartmentNumber']; ?></h5>
                                                <p>Size: <?= $row['apartmentType']; ?></p>
                                                <p>Price: ₱<?= $row['rentPerMonth']; ?>/month</p>
                                                <p>Status: <?= $row['apartmentStatus']; ?></p>
                                                <p>Max Occupants: <?= $row['maxOccupants']; ?></p>
                                            </div>
                                            <a href="../common/mk_request.php?apartmentNumber=<?= $row['apartmentNumber']; ?>">
                                                <button class="btn btn-primary w-100">Rent</button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        } else {
                            echo "<p>No apartments found.</p>";
                        }
                        $conn->close();
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="../../assets/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/src/js/loading.js"></script>

</body>

</html>