<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

<style>
  .no-caret::after {
    display: none; /* Hide the dropdown caret */
}

.dropdown-toggle {
    cursor: pointer; /* Set cursor to pointer on hover */
}
</style>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h1">Announcements</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <!-- <div class="input-group me-2">
                <input type="text" class="form-control" id="filterInput" placeholder="Search Tenant..." oninput="searchTenants()">
                <span class="input-group-text">
                    <i class="bi bi-search d-flex align-items-center"></i>
                </span> 
            </div> -->
            <a href="#" class="text-secondary" data-bs-toggle="modal" data-bs-target="#sendAnnouncementModal" title="Make Announcement" style="text-decoration: none;">
                <button type="button" class="btn btn-outline-secondary d-flex align-items-center gap-1 hover-white">
                    <span class="m-1 h6">Make an Announcement</span><i class="bi bi-megaphone d-flex align-items-center"></i></i>
                </button>
            </a>
        </div>
    </div>
    <?php include'views/manager/modal.announcement.php'; ?>
        <div class="row">
        <?php
            // Include database connection
            include('core/database.php');

            // Query to fetch announcements with user and staff information
            $sql = "SELECT a.*, u.picDirectory, u.userRole, s.firstName, s.lastName, s.staffRole
                    FROM announcement a
                    INNER JOIN user u ON a.staff_id = u.staff_ID
                    INNER JOIN staff s ON u.staff_ID = s.staff_ID
                    ORDER BY a.created_at DESC
                    LIMIT 10";

            // Execute the query
            $result = $conn->query($sql);

            // Check if there are any announcements
            if ($result->num_rows > 0) {
                // Output data of each row
                while($row = $result->fetch_assoc()) {
                    // Format the timestamp into a readable format
                    $created_at = date('l, F j, Y, h:i A', strtotime($row['created_at']));
                    $content = nl2br(htmlspecialchars($row['content']));

                    // Output the announcement HTML
                    echo '<div class="col-md-12 mb-4">';
                    echo '<div class="card">';
                    echo '<div class="card-body d-flex">';
                    // Display staff picture on the left side
                    echo '<img src="' . htmlspecialchars(substr($row['picDirectory'], 6)) . '" class="img-fluid rounded-circle me-3" style="width: 50px; height: 50px; object-fit: cover;" alt="Staff Picture">';

                    // Announcement body with arrow pointing to the staff picture
                    echo '<div class="flex-grow-1">';
                    echo '<div class="d-flex justify-content-between align-items-center">';
                    echo '<h5 class="card-title mb-0">' . htmlspecialchars($row['firstName'] . ' ' . $row['lastName']) . '</h5>';
                    echo '<div class="dropdown">';
                    echo '<i class="bi bi-three-dots-vertical fs-5 dropdown-toggle no-caret" id="dropdownMenuButton' . $row['announcement_ID'] . '" data-bs-toggle="dropdown" aria-expanded="false"></i>';
                    echo '<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton' . $row['announcement_ID'] . '">';
                    echo '<li><a class="dropdown-item" href="#" 
                            data-bs-toggle="modal" 
                            data-bs-target="#editAnnouncementModal" 
                            data-announcement-id="' . $row['announcement_ID'] . '" 
                            data-target="' . htmlspecialchars($row['target']) . '" 
                            data-title="' . htmlspecialchars($row['title']) . '" 
                            data-content="' . htmlspecialchars($row['content']) . '">Edit Announcement</a></li>';
                    echo '<li>';
                    echo '<form method="POST" action="handlers/manager/deleteAnnouncement.php" onsubmit="return confirm(\'Are you sure you want to delete this announcement?\');" style="display:inline;">';
                    echo '<input type="hidden" name="announcementID" value="' . $row['announcement_ID'] . '">';
                    echo '<button type="submit" class="dropdown-item text-danger">Delete Announcement</button>';
                    echo '</form>';
                    echo '</li>';
                            
                    echo '</ul>';
                    echo '</div>'; // .dropdown
                    echo '</div>'; // .d-flex

                    echo '<p class="card-text mb-0">' . htmlspecialchars($row['staffRole']) . '</p>';
                    echo '<p class="card-text text-muted mb-3">' . htmlspecialchars($created_at) . '</p>';

                    echo '<h5 class="card-subtitle mb-2">' . htmlspecialchars($row['title']) . '</h5>';
                    echo '<p class="card-text">' . $content . '</p>';
                    echo '</div>'; // .flex-grow-1

                    echo '</div>'; // .card-body

                    echo '</div>'; // .card
                    echo '</div>'; // .col-md-12

                }
            } else {
                echo '<div class="alert alert-info">No announcements yet :)</div>';
            }

            // Close database connection
            $conn->close();
        ?>
        <?php include'views/manager/modal.editAnnouncement.php'; ?>

        </div>
    
</main>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var editAnnouncementModal = document.getElementById('editAnnouncementModal');
    editAnnouncementModal.addEventListener('show.bs.modal', function (event) {
        // Button that triggered the modal
        var button = event.relatedTarget;
        
        // Extract info from data-* attributes
        var announcementID = button.getAttribute('data-announcement-id');
        var target = button.getAttribute('data-target');
        var title = button.getAttribute('data-title');
        var content = button.getAttribute('data-content');
        
        // Update the modal's content
        var modal = this;
        modal.querySelector('#editAnnouncementID').value = announcementID;
        modal.querySelector('#announcementTitle').value = title;
        modal.querySelector('#announcementContent').value = content;
    });
});
</script>
