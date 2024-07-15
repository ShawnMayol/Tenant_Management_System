<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

<style>
    .icon-wrapper {
    position: relative;
    display: inline-block;
    width: 1em; /* Ensure the container has a fixed width */
    }
    .icon-default,
    .icon-hover {
        position: absolute;
        top: -13px;
        left: 0;
    }
    .icon-default-2 {
        position: absolute;
        top: -13px;
        left: 0;
    }
    .icon-hover {
        display: none;
    }

    .icon-wrapper:hover .icon-default {
        display: none;
    }

    .icon-wrapper:hover .icon-hover {
        display: inline;
    }
</style>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 " data-theme="<?php echo $theme; ?>">
<?php include ('core/database.php') ?>
    <?php
    // Fetch apartment data based on apartmentNumber
    if (isset($_GET['apartment'])) {
        $apartmentNumber = $_GET['apartment'];
    } else {
        echo "Apartment number is not specified.";
        exit();
    }

    // Prepare SQL statement to fetch apartment details
    $sql = "SELECT * FROM apartment WHERE apartmentNumber = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $apartmentNumber);
    $stmt->execute();
    $result = $stmt->get_result();
    $apartment = $result->fetch_assoc();

    // Prepare SQL statement to fetch the current lease agreement end date
    $lease_sql = "SELECT endDate FROM lease WHERE apartmentNumber = ? ORDER BY endDate DESC LIMIT 1";
    $lease_stmt = $conn->prepare($lease_sql);
    $lease_stmt->bind_param("i", $apartmentNumber);
    $lease_stmt->execute();
    $lease_result = $lease_stmt->get_result();
    $lease = $lease_result->fetch_assoc();

    // Close the database connection
    $conn->close();
    ?>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <div class="container">
            <div class="row">
                <div class="col-auto ps-2 pe-3">
                    <a href="?page=admin.apartments" class="icon-wrapper" style="text-decoration: none;">
                        <i class="bi bi-arrow-left-circle text-secondary h2 icon-default"></i>
                        <i class="bi bi-arrow-left-circle-fill text-secondary h2 icon-hover"></i>
                    </a>
                </div>
                <div class="col">
                    <h1 class="h1 m-0"><?php echo $apartment['apartmentType']; ?></h1>
                </div>
                <div class="col-auto pe-5">
                    <a href="#" title="Edit this apartment" class="icon-wrapper" style="text-decoration: none;">
                        <div class="link">
                            <i class="bi bi-building-gear text-secondary h2 icon-default-2" data-bs-toggle="modal" data-bs-target="#editApartmentModal"></i>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <br>
    <?php include ('modal.updateApartment.php'); ?>
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-12 mb-4">
                <div class="position-relative">
                    <img src="<?php echo substr($apartment['apartmentPictures'], 6); ?>" style="width: 100%;" class="img-fluid shadow" alt="<?php echo $apartment['apartmentType']; ?>">
                </div>
                <div class="d-grid gap-2 col-12 mx-auto mt-3">
                    <form action="handlers/admin/updateApartmentPicture.php?apartment=<?php echo htmlspecialchars($_GET['apartment']); ?>" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-8 ms-4">
                                <label for="uploadImageInput" class="form-label">Change Apartment Picture:</label>
                                <input class="form-control py-1" type="file" id="uploadImageInput" name="apartmentImage" accept="image/*" aria-describedby="fileHelp">
                                <!-- <div id="fileHelp" class="form-text">Choose an image file to update the apartment picture.</div> -->
                            </div>
                            <div class="col-md-3 mt-4">
                                <button type="submit" class="btn btn-outline-secondary btn-sm py-1" style="width: 100%; margin-top: 9px;">Change</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-6 col-md-12">
                <h3><?php echo $apartment['apartmentType']; ?></h3>
                <hr>
                <h5>₱<?php echo number_format($apartment['rentPerMonth'], 2); ?> / month</h5>
                <p><?php echo $apartment['apartmentDescription']; ?></p>
                <p><strong>Max Occupants:</strong> <?php echo $apartment['maxOccupants']; ?></p>
                <p><strong>Address:</strong> <?php echo $apartment['apartmentAddress']; ?></p>
                <p><strong>Apartment Dimensions:</strong> <?php echo $apartment['apartmentDimensions']; ?></p><br>
                <h3>Availability</h3>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                    <?php 
                            $availableBy = !empty($apartment['availableBy']) ? date('F j, Y', strtotime($apartment['availableBy'])) : 'N/A';
                            
                            switch($apartment['apartmentStatus']) {
                                case 'Available':
                                    echo '<div class="p-3 mb-2 bg-success-subtle text-success-emphasis rounded">This apartment is available for rent</div>';
                                    break;
                                case 'Occupied':
                                    echo '<div class="p-3 mb-2 bg-danger-subtle text-danger-emphasis rounded">This apartment is currently occupied<br>Will be available by ' . $availableBy . '</div>';
                                    break;
                                case 'Maintenance':
                                    echo '<div class="p-3 mb-2 bg-warning-subtle text-warning-emphasis rounded">This apartment is currently under maintenance<br>Will be available by ' . $availableBy . '</div>';
                                    break;
                                case 'Hidden':
                                    echo '<div class="p-3 mb-2 bg-secondary-subtle text-secondary-emphasis rounded">This apartment is hidden from view</div>';
                                    break;
                                default:
                                    echo '<div class="p-3 mb-2 bg-secondary-subtle text-secondary-emphasis rounded">Unknown apartment status</div>';
                            }
                        ?>
                        <div class="container mb-5">
                            <form action="handlers/admin/updateApartmentStatus.php?apartment=<?php echo htmlspecialchars($_GET['apartment']); ?>" method="post">
                                <div class="row">
                                    <div class="col-md-9 mt-3">
                                        <label for="statusSelect" class="form-label">Change Availability Status:</label>
                                        <select class="form-select" id="statusSelect" name="statusSelect" onchange="toggleAvailableByInput()">
                                            <?php
                                                $statusOptions = ['Available', 'Occupied', 'Maintenance', 'Hidden'];
                                                foreach ($statusOptions as $option) {
                                                    $selected = ($option === $apartmentStatus) ? 'selected' : '';
                                                    echo '<option value="' . $option . '" ' . $selected . '>' . ucfirst($option) . '</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-9 mt-3" id="availableByDiv" style="display: none;">
                                        <label for="availableBy" class="form-label">Available By:</label>
                                        <input type="date" class="form-control" id="availableBy" name="availableBy">
                                    </div>
                                    <div class="col-md-3 mt-3 text-center pt-4">
                                        <button type="submit" class="btn btn-outline-secondary px-4" style="margin-top: 6px;">Change</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <script>
                            function toggleAvailableByInput() {
                                var statusSelect = document.getElementById('statusSelect');
                                var availableByDiv = document.getElementById('availableByDiv');
                                var availableByInput = document.getElementById('availableBy');

                                if (statusSelect.value === 'Maintenance' || statusSelect.value === 'Occupied') {
                                    availableByDiv.style.display = 'block';
                                    if (statusSelect.value === 'Maintenance') {
                                        // Set the minimum date for the availableBy input to today's date
                                        var today = new Date();
                                        var day = String(today.getDate()).padStart(2, '0');
                                        var month = String(today.getMonth() + 1).padStart(2, '0'); // January is 0
                                        var year = today.getFullYear();
                                        availableByInput.min = year + '-' + month + '-' + day;
                                    } else {
                                        // For 'Occupied' status, you may set additional logic if needed
                                    }
                                } else {
                                    availableByDiv.style.display = 'none';
                                    availableByInput.value = ''; // Clear the date input
                                }
                            }

                            // Call the function on page load to set the initial state
                            document.addEventListener('DOMContentLoaded', function() {
                                toggleAvailableByInput();
                            });
                        </script>


                    </div>
                </div>
                
            </div>
        </div>
    </div>  
</main>
<script src="../../assets/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function() {
        $('#changeImageButton').click(function() {
            $('#uploadImageInput').click(); // Trigger click on hidden file input
        });

        $('#uploadImageInput').change(function() {
            var file = this.files[0];
            if (file) {
                // Handle the selected file here (e.g., display preview, upload to server)
                console.log('Selected file:', file);
            }
        });
    });
</script>
<script>
    (function () {
        'use strict'

        const storedTheme = localStorage.getItem('theme') || 'auto'

        const getPreferredTheme = () => {
            if (storedTheme === 'auto') {
                return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'
            }

            return storedTheme
        }

        const setTheme = function (theme) {
            const isDark = theme === 'auto' ? window.matchMedia('(prefers-color-scheme: dark)').matches : theme === 'dark'

            document.documentElement.setAttribute('data-bs-theme', theme)
            document.querySelector('.theme-icon-active use').setAttribute('href', isDark ? '#moon-stars-fill' : '#sun-fill')

            const themeSwitcher = document.querySelectorAll('[data-bs-theme-value]')
            Array.from(themeSwitcher).forEach(el => {
                el.classList.remove('active')
                el.setAttribute('aria-pressed', 'false')
            })

            const btnToActive = document.querySelector(`[data-bs-theme-value="${theme}"]`)
            if (btnToActive) {
                btnToActive.classList.add('active')
                btnToActive.setAttribute('aria-pressed', 'true')
            }

            localStorage.setItem('theme', theme)
        }

        setTheme(getPreferredTheme())

        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
            if (storedTheme !== 'auto') {
                return
            }

            setTheme(getPreferredTheme())
        })

        window.addEventListener('DOMContentLoaded', () => {
            const themeSwitcher = document.querySelectorAll('[data-bs-theme-value]')

            Array.from(themeSwitcher).forEach(el => {
                el.addEventListener('click', () => {
                    const theme = el.getAttribute('data-bs-theme-value')
                    setTheme(theme)
                })
            })
        })
    })()
</script>