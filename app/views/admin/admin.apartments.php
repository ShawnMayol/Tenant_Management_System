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
</style>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h1">Apartments</h1>
    </div>
    <?php include ('core/database.php') ?>

    <?php
        // Fetch apartment data from the database
        $sql = "SELECT apartmentNumber, apartmentType, rentPerMonth, apartmentPictures, apartmentStatus FROM apartment ORDER BY apartmentStatus";
        $result = $conn->query($sql);

        $apartments = [];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $apartments[] = $row;
            }
        }
        $conn->close();
    ?>
    <div class="container">
        <div class="row mb-3">
            <div class="col-12">
                <input type="text" class="form-control" id="filterInput" placeholder="Filter apartments...">
            </div>
        </div>
        <div class="row" id="apartmentGrid">
            <!-- Apartment cards will be dynamically inserted here -->
        </div>
    </div>
</main>

<script>
    const apartments = <?php echo json_encode($apartments); ?>;

    function createApartmentCard(apartment) {
        // Determine the status message
        let statusMessage = '';
        if (apartment.apartmentStatus === 'available') {
            statusMessage = '<div class="p-3 mb-2 text-success-emphasis text-end">Available</div>';
        } else if (apartment.apartmentStatus === 'unavailable') {
            // Assuming you want the date the apartment will be available
            let availableDate = new Date();
            availableDate.setMonth(availableDate.getMonth() + 1); // Example: setting available date to one month later
            statusMessage = `<div class="p-3 mb-2 text-danger-emphasis text-end">Available by ${availableDate.toISOString().split('T')[0]}</div>`;
            statusMessage = `<div class="p-3 mb-2 text-danger-emphasis text-end">Unavailable</div>`;
        } else {
            statusMessage = 'unknown status';
        }

        const cardBgClass = apartment.apartmentStatus === 'available' ? 'bg-success-subtle' : 'bg-danger-subtle';

        return `
            <div class="col-md-4 mb-4">
                <div class="card bg-transparent thumbnail shadow ${cardBgClass}">
                    <a href="?page=admin.viewApartment&apartment=${apartment.apartmentNumber}" style="text-decoration: none;">
                        <img src="${apartment.apartmentPictures}" class="card-img-top" alt="${apartment.apartmentType}">
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

    function loadApartments() {
        const apartmentGrid = document.getElementById('apartmentGrid');
        apartmentGrid.innerHTML = apartments.map(createApartmentCard).join('');
    }

    document.addEventListener('DOMContentLoaded', loadApartments);
</script>