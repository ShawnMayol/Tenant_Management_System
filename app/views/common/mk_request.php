<!doctype html>
<html lang="en" data-bs-theme="auto">

<?php
session_start();
// Retrieve the apartment number from the query parameter
$aptNumber = isset($_GET['apartmentNumber']) ? $_GET['apartmentNumber'] : '';
?>

<style>
    input[readonly] {
        color: #6c757d; /* Neutral gray for text color */
        cursor: not-allowed; /* Show disabled cursor */
    }
</style>

<head>
  <script src="../../assets/dist/js/color-modes.js"></script>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="icon" href="../../assets/src/svg/c-logo.svg">
  <title><?php echo isset($_SESSION['title']) ? $_SESSION['title'] : '' ?>Request Form</title>

  <link href="../../assets/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="../../assets/dist/font-awesome/css/all.min.css" rel="stylesheet">
  <link href="../../assets/src/css/signup.css" rel="stylesheet">
  <?php include ('../../core/themes.php'); ?>
</head>

<body class="bg-body-tertiary">

  <div class="container">
    <div class="form-signup">
      <form action="../../handlers/common/req_handler.php" method="POST" enctype="multipart/form-data">
        <img class="mb-2" src="../../assets/src/svg/c-logo.svg" alt="" width="40" height="35">
        <h1 class="h3 mb-3 fw-normal">Create Request</h1>

        <div class="name-fields d-flex justify-content-between">
          <div class="form-floating me-1 flex-fill">
            <input type="text" class="form-control" id="apartment-num" name="apartment-num" placeholder="Apartment"
              value="<?= htmlspecialchars($aptNumber); ?>" readonly>
            <label for="apartment-num">Apartment No:</label>
          </div>
        </div>

        <div class="form-floating">
          <input type="date" class="form-control" id="reqDate" name="reqDate" placeholder="Request Date" readonly>
          <label for="reqDate">Request Date</label>
        </div>

        <div class="name-fields d-flex justify-content-between">
          <div class="form-floating me-1 flex-fill">
            <input type="text" class="form-control" id="firstName" name="firstName" placeholder="First Name" required>
            <label for="firstName">First Name</label>
          </div>
          <div class="form-floating mx-1 flex-fill">
            <input type="text" class="form-control" id="middleName" name="middleName" placeholder="Middle Name">
            <label for="middleName">Middle Name</label>
          </div>
          <div class="form-floating ms-1 flex-fill">
            <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Last Name" required>
            <label for="lastName">Last Name</label>
          </div>
        </div>

        <div class="form-floating">
          <input type="date" class="form-control" id="birthDate" name="birthDate" placeholder="Birth Date" required>
          <label for="birthDate">Birth Date</label>
        </div>

        <div class="form-floating">
          <input type="tel" class="form-control" id="phoneNumber" name="phoneNumber" placeholder="Phone Number"
            required>
          <label for="phoneNumber">Phone Number</label>
        </div>

        <div class="form-floating">
          <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" required>
          <label for="email">Email Address</label>
        </div>

        <div class="mb-3">
          <label for="formFileMultiple" class="form-label">Attach Valid I.D (Front & Back)</label>
          <input class="form-control" type="file" id="formFileMultiple" name="formFileMultiple[]" multiple required>
        </div>

        <button class="btn btn-primary w-100 py-2 mt-3" id="signup-btn" type="submit">Send Request</button>
        <p class="mt-3 text-body-secondary">&copy; C-Apartments 2024</p>
      </form>
    </div>
  </div>
  <script src="../../assets/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../../assets/src/js/request.js"></script>
</body>

</html>