<style>
    table thead th {
        padding-top: 10px;
        /* Adjust this value as needed */
        padding-bottom: 20px !important;
        /* Adjust this value as needed */
    }

    table thead {
        margin-bottom: 10px;
        /* Adjust this value if necessary */
    }

    #deposit_placeholder {
        display: none;
    }
</style>

<head>
    <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="assets/dist/js/bootstrap.bundle.min.js"></script>
</head>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div>
        <div
            class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h1">Requests</h1>
        </div>

        <div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Apartment</th>
                        <th scope="col">Requested By</th>
                        <th scope="col">Terms of Stay</th>
                        <th scope="col">Request Date</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody id="client-table-body">
                    <!-- client rows will be appended here by JavaScript -->
                </tbody>
            </table>
        </div>
    </div>
</main>


<!-- Modal -->
<div class="modal fade" id="addTenantModal" tabindex="-1" aria-labelledby="tenantModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tenantModalLabel">Add Tenant</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="tenantForm">
                    <div class="mb-3">
                        <label for="firstName" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="firstName" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="lastName" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="lastName" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="middleName" class="form-label">Middle Name</label>
                        <input type="text" class="form-control" id="middleName" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="dateOfBirth" class="form-label">Date of Birth</label>
                        <input type="text" class="form-control" id="dob" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="phoneNumber" class="form-label">Phone Number</label>
                        <input type="text" class="form-control" id="phoneNum" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="emailAddress" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="emailAdd" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="deposit" class="form-label">Deposit</label>
                        <input type="text" class="form-control" id="deposit" readonly>
                    </div>

                    <!--Deposit Interger Placeholder-->
                    <div class="mb-3" id="deposit_placeholder">
                        <label for="deposit" class="form-label" aria-hidden="">Deposit</label>
                        <input type="text" class="form-control" id="deposit_num" readonly>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveTenantBtn">Save</button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="successModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <p>Tenant Added Successfully</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>

    // document.addEventListener('DOMContentLoaded', (event) => {
    //     retrieveReq();
    // });

    function retrieveReq() {
        fetch('handlers/admin/retrieveReq.php')
            .then(response => response.json())
            .then(data => {
                // Sort the data by requestDate in ascending order (oldest first)
                data.sort((a, b) => new Date(a.requestDate) - new Date(b.requestDate));

                const tableBody = document.getElementById('client-table-body');
                tableBody.innerHTML = ''; // Clear the table body before appending new rows

                data.forEach(request => {
                    const row = document.createElement('tr');

                    // Generate links for each attachment
                    let attachmentsHTML = '';
                    request.requestBin.forEach((attachment, index) => {
                        attachmentsHTML += `<a href="${attachment}" target="_blank">View Picture ${index + 1}</a><br>`;
                    });

                    // Fetch Apartment Details
                    fetchApartmentName(request.apartmentNumber)
                        .then(apartment => {
                            if (apartment.length > 0) {
                                row.innerHTML = `
                                <td class="cl-table">
                                    ${apartment[0].apartmentType} <br>
                                    ${apartment[0].rentPerMonth} <br>
                                    ${apartment[0].apartmentStatus} <br>
                                </td>
                                <td class="cl-table">
                                    ${request.Name} <br>
                                    ${request.dateOfBirth} <br>
                                    ${request.emailAddress} <br>
                                    ${request.phoneNumber} <br>
                                    ${attachmentsHTML} <br>
                                </td>
                                <td class="cl-table">
                                    ${request.termsOfStay} <br>
                                    ${request.startDate} <br>
                                    ${request.endDate} <br>
                                </td>
                                <td class="cl-table">${request.requestDate}</td>
                                <td class="cl-table">
                                  <p>Note:<br>
                                    ${request.note}
                                  </p>
                                  <button class="btn btn-sm btn-success cli-accept-btn" data-id="${request.request_ID}" data-request='${JSON.stringify(request)}' data-apartment='${JSON.stringify(apartment[0])}'>Accept</button>
                                  <button class="btn btn-sm btn-danger cli-reject-btn" data-id="${request.request_ID}">Reject</button>
                                </td>
                            `;
                            }
                            tableBody.appendChild(row);
                        })
                        .catch(error => {
                            console.error('Failed to get Apartment Name', error);
                        });
                });

                document.getElementById('client-table-body').addEventListener('click', function (event) {
                    if (event.target.classList.contains('cli-accept-btn')) {
                        showTenantModal(event);
                    }
                    if (event.target.classList.contains('cli-reject-btn')) {
                        removeClient(event);
                    }
                });
            })
            .catch(error => {
                console.error('Error fetching clients:', error);
            });
    }

    // Call retrieveReq() once the script is loaded
    retrieveReq();

    function fetchApartmentName(apartmentId) {
        return fetch(`handlers/admin/retrieveApartment.php?apartmentId=${apartmentId}`)
            .then(response => response.json())
            .catch(error => {
                console.error('Error fetching apartment name:', error);
                throw new Error('Failed to fetch apartment name.');
            });
    }


    function showTenantModal(event) {
        const acceptBtn = event.target.closest('.cli-accept-btn'); // Find the closest .cli-accept-btn element to the clicked element
        if (!acceptBtn) return; // Exit if no matching button is found

        const tenantModal = new bootstrap.Modal(document.getElementById('addTenantModal'), {});
        tenantModal.show();

        const requestId = acceptBtn.getAttribute('data-id');
        const requestData = JSON.parse(acceptBtn.getAttribute('data-request'));
        const apartmentData = JSON.parse(acceptBtn.getAttribute('data-apartment'));

        console.log(`Accepting request ${requestId}`);
        console.log('Request data:', requestData);
        console.log('Apartment data:', apartmentData);

        // Populate modal fields with request data
        document.getElementById('firstName').value = requestData.firstName;
        document.getElementById('lastName').value = requestData.lastName;
        document.getElementById('middleName').value = requestData.middleName;
        document.getElementById('dob').value = requestData.dateOfBirth;
        document.getElementById('phoneNum').value = requestData.phoneNumber;
        document.getElementById('emailAdd').value = requestData.emailAddress;
        document.getElementById('deposit').value = 'Php ' + apartmentData.rentPerMonth;
        document.getElementById('deposit_num').value = apartmentData.rentPerMonth;

        // Set data-request-id attribute on save button
        const saveButton = document.getElementById('saveTenantBtn');
        saveButton.setAttribute('data-request-id', requestId);
    }

    document.getElementById('saveTenantBtn').addEventListener('click', function () {
        const requestId = this.getAttribute('data-request-id');
        //const apartmentId = this.getAttribute('data-apartment-id');
        const tenantData = {
            firstName: document.getElementById('firstName').value,
            lastName: document.getElementById('lastName').value,
            middleName: document.getElementById('middleName').value,
            dateOfBirth: document.getElementById('dob').value,
            phoneNumber: document.getElementById('phoneNum').value,
            emailAddress: document.getElementById('emailAdd').value,
            deposit: document.getElementById('deposit').value,
            depositNum: document.getElementById('deposit_num').value,
            //apartmentId: apartmentId,
            requestId: requestId
        };

        fetch('handlers/admin/addTenant.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(tenantData)
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Close the modal
                    //alert('test');
                    const tenantModal = bootstrap.Modal.getInstance(document.getElementById('addTenantModal'));
                    tenantModal.hide();
                    const successModal = new bootstrap.Modal(document.getElementById('successModal'), {});
                    successModal.show();
                    // Refresh the request list
                    retrieveReq();
                } else {
                    console.error('Failed to add tenant:', data.message);
                }
            })
            .catch(error => {
                console.error('Error adding tenant:', error);
            });

    });

</script>