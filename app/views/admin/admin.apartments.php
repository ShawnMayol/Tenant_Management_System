<style>
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
    .icon-adjust {
        position: relative;
        top: -1.5px;
    }

    .hover-white:hover .text-secondary,
    .hover-white:hover .bi {
        color: white !important;
    }
    .form-control:focus, .form-select:focus{
        box-shadow: none;
        border-color: darkgray;
    }
</style>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <?php include ('core/database.php') ?>
    <?php include ('views/admin/modal.addApartment.php'); ?>
    <?php
    // Fetch apartment data from the database
    $sql = "SELECT 
                apartmentNumber, 
                apartmentType, 
                rentPerMonth, 
                apartmentPictures, 
                apartmentStatus 
            FROM apartment
            ORDER BY rentPerMonth";
    $result = $conn->query($sql);

    $apartments = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $apartments[] = $row;
        }
    }
    $conn->close();
    ?>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h1">Apartments</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="input-group me-2">
                <input type="text" class="form-control" id="filterInput" placeholder="Search Apartment Type..." oninput="searchApartments()">
                <span class="input-group-text">
                    <i class="bi bi-search"></i>
                </span> 
            </div>
            <a href="" class="text-secondary" id="addApartmentButton" data-bs-toggle="modal" data-bs-target="#addApartmentModal" title="Add apartment" style="text-decoration: none;">
                <button type="button" class="btn btn-outline-secondary d-flex align-items-center gap-1 hover-white">
                    <span class="m-1">Add Apartment</span><i class="bi bi-plus-square icon-adjust m-1"></i>
                </button>
            </a>
        </div>
    </div>
    <div class="container pb-3 border-bottom">
        <div class="row">
            <div class="col-md-5 d-flex align-items-end">
                <h1 id="apartmentCount" class="h4">Showing 0 of 0 apartments</h1> 
            </div>
            <div class="col-md-7 text-end">
                <form id="filterForm" class="row">
                    <div class="col-md-4">
                        <label for="priceRange" class="form-label">Price Range</label>
                        <select class="form-select" id="priceRange">
                            <option value="">All</option>
                            <option value="1000-3000">₱1,000 - ₱3,000</option>
                            <option value="3000-6000">₱3,000 - ₱6,000</option>
                            <option value="6000-9000">₱6,000 - ₱9,000</option>
                            <option value="9000-10000">₱9,000+</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status">
                            <option value="">All</option>
                            <option value="Available">Available</option>
                            <option value="Occupied">Occupied</option>
                            <option value="Maintenance">Maintenance</option>
                            <option value="Hidden">Hidden</option>
                        </select>
                    </div>
                    <div class="col-md-4">
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

    <div class="pt-1 pb-3 mb-3">
        
    </div>


    <!-- <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <div class="container">
            <div class="row">
                <div class="col">
                    <h1 class="h1">Apartments</h1>
                </div>
                <div class="col-auto h2 pe-5 mt-1">
                    <a href="" id="addApartmentButton" data-bs-toggle="modal" data-bs-target="#addApartmentModal" title="Add apartment" style="text-decoration: none;">
                        <i class="bi bi-plus-square text-secondary"></i>
                    </a>
                </div>
            </div>
        </div>
    </div> -->

    <div class="container">
        
        <div class="row" id="apartmentGrid">
            <!-- Apartment cards will be dynamically inserted here -->
        </div>
    </div>
</main>

<script>
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
        fetch(`handlers/admin/fetchApartments.php?priceRange=${priceRange}&status=${status}&sortBy=${sortBy}`)
            .then(response => response.json())
            .then(data => {
                window.apartments = data.apartments; // Update the global apartments variable
                const apartmentGrid = document.getElementById('apartmentGrid');
                apartmentGrid.innerHTML = data.apartments.map(createApartmentCard).join('');
                updateApartmentCount(data.apartments.length, data.totalCount); // Update count based on fetched data
            })
            .catch(error => {
                console.error('Error fetching apartments:', error);
            });
    }

    function updateApartmentCount(currentCount, totalCount) {
        const apartmentCountElement = document.getElementById('apartmentCount');
        apartmentCountElement.textContent = `Showing ${currentCount} of ${totalCount} apartment${totalCount !== 1 ? 's' : ''}`;
    }

    function createApartmentCard(apartment) {
        let statusMessage = '';
        if (apartment.apartmentStatus === 'Available') {
            statusMessage = '<div class="p-2 mb-2 text-success-emphasis text-end">Available</div>';
        } else if (apartment.apartmentStatus === 'Occupied') {
            statusMessage = '<div class="p-2 mb-2 text-danger-emphasis text-end">Occupied</div>';
        } else if (apartment.apartmentStatus === 'Maintenance') {
            statusMessage = '<div class="p-2 mb-2 text-warning-emphasis text-end">Maintenance</div>';
        } else if (apartment.apartmentStatus === 'Hidden') {
            statusMessage = '<div class="p-2 mb-2 text-secondary-emphasis text-end">Hidden</div>';
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
            case 'Hidden':
                cardBgClass = 'bg-secondary-subtle';
                break;
            default:
                cardBgClass = 'bg-secondary-subtle';
                break;
        }

        let src = apartment.apartmentPictures.substring(6); // Adjust path to match your images location
        return `
            <div class="col-md-4 mb-4">
                <div class="card bg-transparent thumbnail shadow ${cardBgClass}">
                    <a href="?page=admin.viewApartment&apartment=${apartment.apartmentNumber}" style="text-decoration: none;">
                        <img src="${src}" style="object-fit: cover; height: 250px;" class="card-img-top" alt="${apartment.apartmentType}">
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
        const filteredApartments = window.apartments.filter(apartment => apartment.apartmentType.toLowerCase().includes(searchValue));
        const apartmentGrid = document.getElementById('apartmentGrid');
        apartmentGrid.innerHTML = filteredApartments.map(createApartmentCard).join('');
        updateApartmentCount(filteredApartments.length, window.apartments.length); // Update count based on filtered data
    }
</script>
