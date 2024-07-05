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
        <div class="container">
            <div class="row">
                <div class="col-auto ps-2 pe-3">
                    <a href="?page=admin.apartments" class="icon-wrapper" style="text-decoration: none;">
                        <i class="bi bi-arrow-left-circle text-light h2 icon-default"></i>
                        <i class="bi bi-arrow-left-circle-fill text-light h2 icon-hover"></i>
                    </a>
                </div>
                <div class="col">
                    <h1 class="h1 m-0"><?php echo $apartment['apartmentType']; ?></h1>
                </div>
                <div class="col-auto pe-5">
                    <a href="#" title="Edit this apartment" class="icon-wrapper" style="text-decoration: none;">
                        <div class="link">
                            <i class="bi bi-pencil-square text-light h2 icon-default-2" data-bs-toggle="modal" data-bs-target="#editApartmentModal"></i>
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
                <img src="<?php echo $apartment['apartmentPictures']; ?>" class="img-fluid shadow" alt="<?php echo $apartment['apartmentType']; ?>">
            </div>
            <div class="col-lg-6 col-md-12">
                <h3><?php echo $apartment['apartmentType']; ?></h3>
                <hr>
                <h5>₱<?php echo number_format($apartment['rentPerMonth'], 2); ?> / month</h5>
                <p><?php echo $apartment['apartmentDescription']; ?></p>
                <p><strong>Max Occupants:</strong> <?php echo $apartment['maxOccupants']; ?></p>
                <p><strong>Address:</strong> <?php echo $apartment['apartmentAddress']; ?></p>
                <p><strong>Apartment Dimensions:</strong> <?php echo $apartment['apartmentDimensions']; ?></p><br>
                <h3>Availability</h3><hr>
                <?php 
                    switch($apartment['apartmentStatus']) {
                        case 'available':
                            echo '<div class="p-3 mb-2 bg-success-subtle text-success-emphasis rounded">This apartment is available for rent</div>';
                            break;
                            
                        case 'unavailable':
                            echo '<div class="p-3 mb-2 bg-danger-subtle text-danger-emphasis rounded">This apartment is currently unavailable <br>
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