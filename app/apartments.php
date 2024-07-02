<!-- For now rent button and apply filter button doesn't work -->

<!DOCTYPE html>
<html lang="en">

<?php
session_start();
?>

<head>
    <script src="./assets/dist/js/color-modes.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./assets/dist/font-awesome/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./assets/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/src/css/apartment_catalogue.css">
    <link href="assets/src/css/dashboard.css" rel="stylesheet">
    <link rel="icon" href="assets/src/svg/c-logo.svg">
    <title>Apartment Catalogue</title>
</head>

<body class="bg-body-tertiary">


    <div class="container-fluid card text-center p-3">
        <h1 class="align-middle px-4">Apartment Catalogue</h1>
    </div>

    <!-- Filter Options and Apartment List -->
    <div class="container mt-4 text-center">

        <!-- Filter Options -->
        <div class="row">
            <div class="col card d-flex align-items-center justify-content-center">
                <form class="mt-3">
                    <div class="row">
                        <!-- Apartment Size -->
                        <div class="col mb-3">
                            <label for="apartmentSize" class="form-label">Apartment Size</label>
                            <select class="form-select" id="apartmentSize">
                                <option value="0-500">0-500 sq. ft</option>
                                <option value="501-1000">501-1000 sq. ft</option>
                            </select>
                        </div>
                        <!-- Price Range -->
                        <div class="col mb-3">
                            <label for="priceRange" class="form-label">Price Range (₱)</label>
                            <select class="form-select" id="priceRange">
                                <option value="0-2000">₱0-₱2000</option>
                                <option value="2001-4000">₱2001-₱4000</option>
                            </select>
                        </div>
                        <!-- Availability Status -->
                        <div class="col mb-3">
                            <label for="availabilityStatus" class="form-label">Availability Status</label>
                            <select class="form-select" id="availabilityStatus">
                                <option value="available">Available</option>
                                <option value="notAvailable">Not Available</option>
                            </select>
                        </div>
                        <!-- Max Occupants -->
                        <div class="col mb-3">
                            <label for="maxOccupants" class="form-label">Max Occupants</label>
                            <select class="form-select" id="maxOccupants">
                                <option value="1-2">1-2 occupants</option>
                                <option value="3-4">3-4 occupants</option>
                            </select>
                        </div>
                    </div>
                    <!-- Apply Filter Button -->
                    <button type="submit" class="btn btn-primary">Apply Filter</button>
                </form>
            </div>
        </div>

        <!-- Apartment List -->
        <div class="row">
            <div class="container card px-4" id="cards-container">
                <div class="row custom-row">
                    <!-- Apartment Item 1 -->
                    <div class="col-xl-3 col-md-4 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <!-- Image Carousel -->
                                <div id="carouselExample1" class="carousel slide">
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <img src="assets/src/img/apartment-img-template-1.jpg" class="d-block w-100"
                                                alt="...">
                                        </div>
                                        <div class="carousel-item">
                                            <img src="assets/src/img/apartment-img-template-1.jpg" class="d-block w-100"
                                                alt="...">
                                        </div>
                                        <div class="carousel-item">
                                            <img src="assets/src/img/apartment-img-template-1.jpg" class="d-block w-100"
                                                alt="...">
                                        </div>
                                    </div>
                                    <button class="carousel-control-prev" type="button"
                                        data-bs-target="#carouselExample1" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button"
                                        data-bs-target="#carouselExample1" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                </div>
                                <!-- Apartment Information -->
                                <div class="apartment-info">
                                    <h5 class="card-title">Apartment 1</h5>
                                    <p>Size: 100 sq. ft</p>
                                    <p>Price: $1000/month</p>
                                    <p>Status: Available</p>
                                    <p>Max Occupants: 2</p>
                                </div>
                                <!-- Rent Button -->
                                <a href="client/request.php">
                                    <button class="btn btn-primary w-100">Rent</button>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Apartment Item 2 -->
                    <div class="col-xl-3 col-md-4 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <!-- Image Carousel -->
                                <div id="carouselExample2" class="carousel slide">
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <img src="assets/src/img/apartment-img-template-1.jpg" class="d-block w-100"
                                                alt="...">
                                        </div>
                                        <div class="carousel-item">
                                            <img src="assets/src/img/apartment-img-template-1.jpg" class="d-block w-100"
                                                alt="...">
                                        </div>
                                        <div class="carousel-item">
                                            <img src="assets/src/img/apartment-img-template-1.jpg" class="d-block w-100"
                                                alt="...">
                                        </div>
                                    </div>
                                    <button class="carousel-control-prev" type="button"
                                        data-bs-target="#carouselExample2" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button"
                                        data-bs-target="#carouselExample2" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                </div>
                                <!-- Apartment Information -->
                                <div class="apartment-info">
                                    <h5 class="card-title">Apartment 2</h5>
                                    <p>Size: 100 sq. ft</p>
                                    <p>Price: $1000/month</p>
                                    <p>Status: Available</p>
                                    <p>Max Occupants: 2</p>
                                </div>
                                <!-- Rent Button -->
                                <a href="client/request.php">
                                    <button class="btn btn-primary w-100">Rent</button>
                                </a>

                            </div>
                        </div>
                    </div>

                    <!-- Apartment Item 3 -->
                    <div class="col-xl-3 col-md-4 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <!-- Image Carousel -->
                                <div id="carouselExample3" class="carousel slide">
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <img src="assets/src/img/apartment-img-template-1.jpg" class="d-block w-100"
                                                alt="...">
                                        </div>
                                        <div class="carousel-item">
                                            <img src="assets/src/img/apartment-img-template-1.jpg" class="d-block w-100"
                                                alt="...">
                                        </div>
                                        <div class="carousel-item">
                                            <img src="assets/src/img/apartment-img-template-1.jpg" class="d-block w-100"
                                                alt="...">
                                        </div>
                                    </div>
                                    <button class="carousel-control-prev" type="button"
                                        data-bs-target="#carouselExample3" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button"
                                        data-bs-target="#carouselExample3" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                </div>
                                <!-- Apartment Information -->
                                <div class="apartment-info">
                                    <h5 class="card-title">Apartment 3</h5>
                                    <p>Size: 100 sq. ft</p>
                                    <p>Price: $1000/month</p>
                                    <p>Status: Available</p>
                                    <p>Max Occupants: 2</p>
                                </div>
                                <!-- Rent Button -->
                                <a href="client/request.php">
                                    <button class="btn btn-primary w-100">Rent</button>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Apartment Item 4 -->
                    <div class="col-xl-3 col-md-4 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <!-- Image Carousel -->
                                <div id="carouselExample4" class="carousel slide">
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <img src="assets/src/img/apartment-img-template-1.jpg" class="d-block w-100"
                                                alt="...">
                                        </div>
                                        <div class="carousel-item">
                                            <img src="assets/src/img/apartment-img-template-1.jpg" class="d-block w-100"
                                                alt="...">
                                        </div>
                                        <div class="carousel-item">
                                            <img src="assets/src/img/apartment-img-template-1.jpg" class="d-block w-100"
                                                alt="...">
                                        </div>
                                    </div>
                                    <button class="carousel-control-prev" type="button"
                                        data-bs-target="#carouselExample4" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button"
                                        data-bs-target="#carouselExample4" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                </div>
                                <!-- Apartment Information -->
                                <div class="apartment-info">
                                    <h5 class="card-title">Apartment 2</h5>
                                    <p>Size: 100 sq. ft</p>
                                    <p>Price: $1000/month</p>
                                    <p>Status: Available</p>
                                    <p>Max Occupants: 2</p>
                                </div>
                                <!-- Rent Button -->
                                <a href="client/request.php">
                                    <button class="btn btn-primary w-100">Rent</button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include ('./aesthetics/themes.php'); ?>
    <script src="assets/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>