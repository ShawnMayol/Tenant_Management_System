<!DOCTYPE html>
<html lang="en" data-bs-theme="auto">

<?php 
    session_start();
    include '../../core/database.php';
    // print_r($_SESSION);
?>

<head>
    <script src="assets/dist/js/color-modes.js"></script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Browse Apartments | C-Apartments</title>
    <link rel="icon" href="../../assets/src/svg/c-logo.svg">

    <link rel="stylesheet" href="../../assets/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/src/css/apartments.css">
    <!-- <link href="assets/src/css/loading.css" rel="stylesheet"> -->

</head>

<body class="bg-body-tertiary">
  
  <header class="navbar sticky-top bg-dark flex-md-nowrap p-0 shadow" data-bs-theme="dark">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6 text-white" href="../../index.php">
        <img src="../../assets/src/svg/c.svg" alt="Company Logo" style="width: 100%; height: 80%">
    </a>
  
    <?php //include('topbar.php'); ?>

  </header>

  <main class="col-12 px-md-4"> 
  <!-- <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">   -->
      <div class="container mt-4 text-center">
          <div class="row">
              <div class="container card px-4" id="cards-container">
                  <div class="row custom-row">
                      <?php
                      $sql = "SELECT apartmentNumber, apartmentSize, apartmentPrice, apartmentStatus, maxOccupants FROM apartment";
                      $result = $conn->query($sql);

                      if ($result->num_rows > 0) {
                          while ($row = $result->fetch_assoc()) {
                              echo '<div class="col-xl-3 col-md-4 mb-4">';
                              echo '    <div class="card">';
                              echo '        <div class="card-body">';
                              echo '            <div id="carouselExample' . $row["apartmentNumber"] . '" class="carousel slide">';
                              echo '                <div class="carousel-inner">';
                              echo '                    <div class="carousel-item active">';
                              echo '                        <img src="../../assets/src/img/apartment-img-template-1.jpg" class="d-block w-100" alt="...">';
                              echo '                    </div>';
                              echo '                    <div class="carousel-item">';
                              echo '                        <img src="../../assets/src/img/apartment-img-template-1.jpg" class="d-block w-100" alt="...">';
                              echo '                    </div>';
                              echo '                    <div class="carousel-item">';
                              echo '                        <img src="../../assets/src/img/apartment-img-template-1.jpg" class="d-block w-100" alt="...">';
                              echo '                    </div>';
                              echo '                </div>';
                              echo '                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample' . $row["apartmentNumber"] . '" data-bs-slide="prev">';
                              echo '                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>';
                              echo '                    <span class="visually-hidden">Previous</span>';
                              echo '                </button>';
                              echo '                <button class="carousel-control-next" type="button" data-bs-target="#carouselExample' . $row["apartmentNumber"] . '" data-bs-slide="next">';
                              echo '                    <span class="carousel-control-next-icon" aria-hidden="true"></span>';
                              echo '                    <span class="visually-hidden">Next</span>';
                              echo '                </button>';
                              echo '            </div>';
                              echo '            <div class="apartment-info">';
                              echo '                <h5 class="card-title">Apartment ' . $row["apartmentNumber"] . '</h5>';
                              echo '                <p>Size: ' . $row["apartmentSize"] . '</p>';
                              echo '                <p>Price: ₱' . $row["apartmentPrice"] . '/month</p>';
                              echo '                <p>Status: ' . $row["apartmentStatus"] . '</p>';
                              echo '                <p>Max Occupants: ' . $row["maxOccupants"] . '</p>';
                              echo '            </div>';
                              echo '            <a href="client/request.php"> <button class="btn btn-primary w-100">Rent</button> </a>';
                              echo '        </div>';
                              echo '    </div>';
                              echo '</div>';
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
    
  <?php include('../../core/themes.php') ?>

  <script src="../../assets/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../../assets/src/js/loading.js"></script>

</body>

</html>