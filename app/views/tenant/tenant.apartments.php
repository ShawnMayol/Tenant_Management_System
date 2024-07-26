<?php 
    include('handlers/tenant/retrieveApartment.php');
?>

<style>
    /* Custom CSS to remove padding around card image */
    .sidebar, .offcanvas-md {
        z-index: 1000; /* Lower z-index for the sidebar */
    }

    .apartment-container {
        margin-bottom: 20px;
        padding: 10px;
    }

    .apartment-img img {
        width: 100%;
        height: auto;
        object-fit: cover;
        border-radius: 5px;
    }

    .apartment-info div {
        margin-bottom: 10px;
    }

    .custom-modal-dialog {
        max-width: 80%; /* Set maximum width of the modal */
        margin: auto; /* Center horizontally */
    }

    .custom-modal-content {
        width: 100%; /* Ensure modal content fills the dialog */
    }

    .custom-modal-body {
        padding: 20px; /* Add padding to the modal body */
    }

    .custom-img {
        width: 100%;
        height: auto; /* Adjust maximum height of the image */
        object-fit: cover;
    }
</style>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Apartment</h1>
    </div>

    <?php if ($apartment): ?>
        <div class="row apartment-container">
            <div class="col-md-6">
                <div class="apartment-img">
                    <img src="a<?= htmlspecialchars($apartment['apartmentPictures']) ?>" alt="<?= htmlspecialchars($apartment['apartmentType']) ?>">
                </div>
            </div>
            <div class="col-md-6">
                <h1><?php echo $apartment['apartmentType']; ?></h1><hr>
                <div class="apartment-info">
                    <h5>₱<?php echo number_format($apartment['rentPerMonth'], 2); ?> / month</h5>
                    <p><?php echo $apartment['apartmentDescription']; ?></p>
                    <p><strong>Max Occupants:</strong> <?php echo $apartment['maxOccupants']; ?></p>
                    <p><strong>Address:</strong> <?php echo $apartment['apartmentAddress']; ?></p>
                    <p><strong>Apartment Dimensions:</strong> <?php echo $apartment['apartmentDimensions']; ?></p>
                    <p><strong>Max Occupants:</strong> <?php echo $apartment['maxOccupants']; ?></p><br>

                    <h3>Lease Details</h3><hr>
                    <p><strong>Start Date:</strong> <?php echo $apartment['startDate']; ?></p>
                    <p><strong>End Date:</strong> <?php echo $apartment['endDate']; ?></p>
                    <p><strong>Billing Period:</strong> <?php echo $apartment['billingPeriod']; ?></p>
                </div>
            </div>
        </div>
    <?php else: ?>
        <p>No apartment information available for the logged-in user.</p>
    <?php endif; ?>
</main>
