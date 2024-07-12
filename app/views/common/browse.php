<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<?php
    session_start();
    // print_r($_SESSION);
?>

<head>
    <script src="../../assets/dist/js/color-modes.js"></script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Browse Apartments | C-Apartments</title>
    <link rel="icon" href="../../assets/src/svg/c-logo.svg">

    <link rel="stylesheet" href="../../assets/dist/css/bootstrap.min.css">
    <link href="../../assets/src/css/themes.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>

<style>
    .glass-navbar {
        backdrop-filter: blur(0.5px); /* Blur effect */
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Subtle shadow */
    }
    #banner {
        max-height: 50px; /* Minimized logo size */
        transition: 0.8s; /* Smooth transition */
    }
    .thumbnail { 
        display:block; 
        z-index:999; 
        cursor: pointer; 
        -webkit-transition-property: all; 
        -webkit-transition-duration: 0.3s; 
        -webkit-transition-timing-function: ease; 
    } 
    /*change the number below to scale to the appropriate size*/ 
    .thumbnail:hover { 
        transform: scale(1.01); 
    }
    .sidebar .offcanvas-body {
        display: flex;
        flex-direction: column;
        align-items: center;
    }
        .sidebar .offcanvas-body .form-label,
        .sidebar .offcanvas-body .form-select,
        .sidebar .offcanvas-body .btn {
            width: 100%;
    }
    .form-control:focus, .form-select:focus{
        box-shadow: none;
        border-color: darkgray;
    }
</style>

<body class="bg-body-tertiary">
    <?php include ('../../core/themes.php') ?>
    <?php include ('../../core/database.php') ?>

    <?php
    // Fetch apartment data from the database
    $sql = "SELECT 
                apartmentNumber, 
                apartmentType, 
                rentPerMonth, 
                apartmentPictures, 
                apartmentStatus 
            FROM apartment 
            WHERE apartmentStatus <> 'Hidden'
            ORDER BY apartmentStatus, apartmentType";
    $result = $conn->query($sql);

    $apartments = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $apartments[] = $row;
        }
    }
    $conn->close();
    ?>

<nav class="navbar navbar-light fixed-top justify-content-center align-items-center bg-dark-subtle shadow">
        <a class="navbar-brand logo" href="landing.php">
            <img id="banner" src="../../assets/src/svg/c.svg" alt="Website Logo" class="img-fluid">
        </a>
    </nav>


<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="sidebar position-fixed border border-end ms-3 col-md-3 col-lg-2 p-0 bg-body shadow" style="margin-top: 95px;">
        <div class="offcanvas-md bg-dark-subtle offcanvas-end bg-body" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="sidebarMenuLabel">Filters</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body p-3">
                <form id="filterForm">
                    <div class="mb-3">
                        <label for="priceRange" class="form-label">Price Range</label>
                        <select class="form-select" id="priceRange">
                            <option value="">All</option>
                            <option value="1000-3000">₱1,000 - ₱3,000</option>
                            <option value="3000-6000">₱3,000 - ₱6,000</option>
                            <option value="6000-9000">₱6,000 - ₱9,000</option>
                            <option value="9000-10000">₱9,000+</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status">
                            <option value="">All</option>
                            <option value="Available">Available</option>
                            <option value="Occupied">Occupied</option>
                            <option value="Maintenance">Maintenance</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="sortBy" class="form-label">Sort By</label>
                        <select class="form-select" id="sortBy">
                            <option value="rentAsc">Rent (Low to High)</option>
                            <option value="rentDesc">Rent (High to Low)</option>
                        </select>
                    </div>
                </form>
            </div>
        </div>
    </div>
        <!-- Main Content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="container pt-3" style="margin-top: 80px;">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 id="apartmentCount" class="h2">Showing 0 apartments</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="col-md-2 input-group">
                            <input type="text" class="form-control" id="filterInput" placeholder="Search Apartment Type..." oninput="searchApartments()">
                            <span class="input-group-text">
                                <i class="bi bi-search"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row" id="apartmentGrid">
                <!-- Apartment cards will be dynamically inserted here -->
                </div>
            </div>
        </main>
    </div>
</div>



<script src="../../assets/dist/js/bootstrap.bundle.min.js"></script>
<script>
    window.apartments = <?php echo json_encode($apartments); ?>;
    
    document.addEventListener('DOMContentLoaded', function() {
        applyFilters(); // Initial load of apartments

        // Bind applyFilters() to change event of each select element
        document.getElementById('priceRange').addEventListener('change', applyFilters);
        document.getElementById('status').addEventListener('change', applyFilters);
        document.getElementById('sortBy').addEventListener('change', applyFilters);

        document.getElementById('applyFilters').addEventListener('click', function(event) {
            event.preventDefault(); // Prevent form submission (button default behavior)
            applyFilters(); // Trigger filtering function when Apply Filters button is clicked
        });

        document.getElementById('filterInput').addEventListener('input', function() {
            searchApartments(); // Trigger search function when user types in search box
        });
    });

    function applyFilters() {
        // Get filter values
        const priceRange = document.getElementById('priceRange').value;
        const status = document.getElementById('status').value;
        const sortBy = document.getElementById('sortBy').value;

        // Fetch filtered data
        fetchApartments(priceRange, status, sortBy);
    }

    function fetchApartments(priceRange, status, sortBy) {
        fetch(`../../handlers/common/fetchApartments.php?priceRange=${priceRange}&status=${status}&sortBy=${sortBy}`)
            .then(response => response.json())
            .then(data => {
                const apartmentGrid = document.getElementById('apartmentGrid');
                apartmentGrid.innerHTML = data.map(createApartmentCard).join('');
                updateApartmentCount(data.length); // Update count based on fetched data
            })
            .catch(error => {
                console.error('Error fetching apartments:', error);
            });
    }

    function updateApartmentCount(count) {
        const apartmentCountElement = document.getElementById('apartmentCount');
        apartmentCountElement.textContent = `Showing ${count} apartment${count !== 1 ? 's' : ''}`;
    }

    function createApartmentCard(apartment) {
        let statusMessage = '';
        if (apartment.apartmentStatus === 'Available') {
            statusMessage = '<div class="p-2 mb-2 text-success-emphasis text-end">Available</div>';
        } else if (apartment.apartmentStatus === 'Occupied') {
            statusMessage = '<div class="p-2 mb-2 text-danger-emphasis text-end">Occupied</div>';
        } else if (apartment.apartmentStatus === 'Maintenance') {
            statusMessage = '<div class="p-2 mb-2 text-warning-emphasis text-end">Maintenance</div>';
        } else {
            statusMessage = 'Unknown status';
        }

        let cardBgClass;
        switch (apartment.apartmentStatus) {
            case 'Available':
                cardBgClass = 'bg-success-subtle';
                break;
            case 'Occupied':
                cardBgClass = 'bg-danger-subtle';
                break;
            case 'Maintenance':
                cardBgClass = 'bg-warning-subtle';
                break;
            default:
                cardBgClass = 'bg-secondary-subtle';
                break;
        }

        return `
            <div class="col-md-4 mb-4">
                <div class="card bg-transparent thumbnail shadow ${cardBgClass}">
                    <a href="apartment.php?apartment=${apartment.apartmentNumber}" style="text-decoration: none;">
                        <img src="${apartment.apartmentPictures}" style="object-fit: cover; height: 250px;" class="card-img-top" alt="${apartment.apartmentType}">
                        <div class="card-body">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h5 class="card-title">${apartment.apartmentType}</h5>
                                        <p class="card-text">₱${Number(apartment.rentPerMonth).toFixed(2)} / month</p>
                                    </div>
                                    <div class="col-md-6">
                                        ${statusMessage}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        `;
    }

    function searchApartments() {
        const searchValue = document.getElementById('filterInput').value.toLowerCase();
        const filteredApartments = apartments.filter(apartment => apartment.apartmentType.toLowerCase().includes(searchValue));
        const apartmentGrid = document.getElementById('apartmentGrid');
        apartmentGrid.innerHTML = filteredApartments.map(createApartmentCard).join('');
        updateApartmentCount(filteredApartments.length);
    }
</script>



    <script>
        // Function to handle scroll event
        // window.addEventListener('scroll', function() {
        //     var banner = document.getElementById('banner');
        //     var navbar = document.getElementsByClassName('glass-navbar')[0]; // Select the first element

        //     if (window.scrollY > 80) {
        //         banner.style.maxHeight = '35px'; // Adjusted size when scrolled down
        //         // navbar.style.background = 'none'; // Remove background when scrolled down
        //         navbar.style.backdropFilter = 'none'; // Remove backdrop filter when scrolled down
        //         navbar.style.boxShadow = 'none'; // Remove box shadow when scrolled down
        //     } else {
        //         banner.style.maxHeight = '50px'; // Default size when not scrolled down
        //         navbar.style.background = 'rgba(0, 0, 0, 0.3)'; // Default background color
        //         navbar.style.backdropFilter = 'blur(0.5px)'; // Restore backdrop filter when not scrolled down
        //         navbar.style.boxShadow = '0 4px 6px rgba(0, 0, 0, 0.1)'; // Restore box shadow when not scrolled down
        //     }
        // });
    </script>
</body>
</html>