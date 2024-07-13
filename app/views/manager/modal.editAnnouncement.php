<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<!-- Modal for Edit Announcement -->
<div class="modal fade" id="editAnnouncementModal" tabindex="-1" aria-labelledby="editAnnouncementModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editAnnouncementModalLabel">Edit Announcement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editAnnouncementForm" method="POST" action="handlers/manager/editAnnouncement.php">
                    <input type="hidden" id="editAnnouncementID" name="editAnnouncementID"> <!-- Hidden field to store announcement ID -->
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="announcementTarget" class="form-label">Target*</label>
                            <select class="form-select" id="announcementTarget" name="announcementTarget" required>
                                <option value="" hidden>Select Target</option>
                                <option value="all" selected>All</option>
                                <option value="admins" hidden>Admins</option>
                                <option value="managers" hidden>Managers</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="announcementTitle" class="form-label">Title*</label>
                        <input type="text" class="form-control" id="announcementTitle" name="announcementTitle" required>
                    </div>
                    <div class="mb-3">
                        <label for="announcementContent" class="form-label">Content*</label>
                        <textarea class="form-control" id="announcementContent" name="announcementContent" rows="5" required></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
