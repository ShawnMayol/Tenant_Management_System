<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    
    <?php include ('core/database.php') ?>
    <?php
        // Fetch apartment data based on apartmentNumber
        if (isset($_GET['apartment'])) {
            $apartmentNumber = $_GET['apartment'];
        } else {
            echo "Apartment number is not specified.";
        }
        $sql = "SELECT * FROM apartment WHERE apartmentNumber = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $apartmentNumber);
        $stmt->execute();
        $result = $stmt->get_result();
        $apartment = $result->fetch_assoc();
        $conn->close();
    ?>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2"><?php echo $apartment['apartmentType']; ?></h1>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-12 mb-4">
                <img src="<?php echo $apartment['apartmentPictures']; ?>" class="img-fluid shadow" alt="<?php echo $apartment['apartmentType']; ?>">
            </div>
            <div class="col-lg-6 col-md-12">
                <h1><?php echo $apartment['apartmentType']; ?></h1>
                <hr>
                <h5>₱<?php echo number_format($apartment['rentPerMonth'], 2); ?> / month</h5>
                <p><?php echo $apartment['description']; ?></p>
                <p><strong>Max Occupants:</strong> <?php echo $apartment['maxOccupants']; ?></p>
                <p><strong>Address:</strong> <?php echo $apartment['address']; ?></p>
                <p><strong>Apartment Dimensions:</strong> <?php echo $apartment['apartmentDimensions']; ?></p><br>
                <h3>Availability</h3><hr>
                <?php 
                    switch($apartment['apartmentStatus']) {
                        case 'available':
                            echo '<div class="p-3 mb-2 bg-success-subtle text-success-emphasis rounded">This apartment is available for rent</div>';
                            break;
                            
                        case 'unavailable':
                            echo '<div class="p-3 mb-2 bg-danger-subtle text-danger-emphasis rounded">This apartment is currently unvailable <br>
                            Will be available by ' . date('m-d-Y') . '</div>';
                            break;
                        default:
                            echo 'unknown status';
                    }
                ?>
            </div>
        </div>
    </div>    
</main>
<script src="../../assets/dist/js/bootstrap.bundle.min.js"></script>
