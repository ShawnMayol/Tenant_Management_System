<?php include ('../../core/database.php') ?>

<?php
    // Fetch apartment data based on apartmentNumber
    $apartmentNumber = $_GET['apartmentNumber'];
    $sql = "SELECT * FROM apartment WHERE apartmentNumber = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $apartmentNumber);
    $stmt->execute();
    $result = $stmt->get_result();
    $apartment = $result->fetch_assoc();
    $conn->close();
?>


<div class="apartment-container">
        <div class="apartment-image">
            <img src="<?php echo $apartment['apartmentPictures']; ?>" class="img-fluid" alt="<?php echo $apartment['apartmentType']; ?>">
        </div>
        <div class="apartment-details">
            <h2><?php echo $apartment['apartmentType']; ?></h2>
            <p><strong>Peso Rent / month:</strong> ₱<?php echo number_format($apartment['rentPerMonth'], 2); ?></p>
            <p><strong>Description:</strong> <?php echo $apartment['description']; ?></p>
            <p><strong>Max Occupants:</strong> <?php echo $apartment['maxOccupants']; ?></p>
            <p><strong>Address:</strong> <?php echo $apartment['address']; ?></p>
            <p><strong>Apartment Dimensions:</strong> <?php echo $apartment['apartmentDimensions']; ?></p>
        </div>
    </div>

    <div class="proposed-lease mt-5">
        <h3>Proposed Lease</h3>
        <form action="lease_process.php" method="POST">
            <input type="hidden" name="apartmentNumber" value="<?php echo $apartmentNumber; ?>">
            <div class="mb-3">
                <label for="termsOfStay" class="form-label">Terms of Stay</label>
                <select class="form-select" id="termsOfStay" name="termsOfStay" required>
                    <option value="short">Short term (< 6 months)</option>
                    <option value="long">Long term (> 6 months)</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="startDate" class="form-label">Start Date</label>
                <input type="date" class="form-control" id="startDate" name="startDate" required>
            </div>
            <div class="mb-3">
                <label for="endDate" class="form-label">End Date</label>
                <input type="date" class="form-control" id="endDate" name="endDate" required>
            </div>
            <div class="mb-3">
                <label for="billingPeriod" class="form-label">Billing Period</label>
                <select class="form-select" id="billingPeriod" name="billingPeriod" required>
                    <option value="weekly">Weekly</option>
                    <option value="monthly">Monthly</option>
                    <option value="annually">Annually</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="numOccupants" class="form-label">Number of Occupants</label>
                <input type="number" class="form-control" id="numOccupants" name="numOccupants" min="1" max="<?php echo $apartment['maxOccupants']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="message" class="form-label">Message</label>
                <textarea class="form-control" id="message" name="message" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Proceed to Tenant Information Filling</button>
        </form>
    </div>