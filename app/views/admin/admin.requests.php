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


<!-- Modal For Tenants -->
<div class="modal fade" id="addTenantModal" tabindex="-1" aria-labelledby="tenantModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tenantModalLabel">Add Tenant</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="tenantForm">
                    <div class="mb-3">
                        <label for="firstName" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="firstName">
                    </div>
                    <div class="mb-3">
                        <label for="lastName" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="lastName">
                    </div>
                    <div class="mb-3">
                        <label for="middleName" class="form-label">Middle Name</label>
                        <input type="text" class="form-control" id="middleName">
                    </div>
                    <div class="mb-3">
                        <label for="dateOfBirth" class="form-label">Date of Birth</label>
                        <input type="text" class="form-control" id="dob">
                    </div>
                    <div class="mb-3">
                        <label for="phoneNumber" class="form-label">Phone Number</label>
                        <input type="text" class="form-control" id="phoneNum">
                    </div>
                    <div class="mb-3">
                        <label for="emailAddress" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="emailAdd">
                    </div>
                    <div class="mb-3">
                        <label for="deposit" class="form-label">Deposit</label>
                        <input type="text" class="form-control" id="deposit">
                    </div>


                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" data-bs-target="#leaseModal"
                    data-bs-toggle="modal">Proceed to Lease</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal For Lease -->
<div class="modal fade" id="leaseModal" tabindex="-1" aria-labelledby="leaseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tenantModalLabel">Create Lease</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="leaseForm">
                    <div class="mb-3">
                        <label for="startDate" class="form-label">Start Date</label>
                        <input type="date" class="form-control" id="startDate">
                    </div>

                    <div class="mb-3">
                        <label for="endDate" class="form-label">End Date</label>
                        <input type="date" class="form-control" id="endDate">
                    </div>

                    <div class="mb-3">
                        <label for="billPeriod" class="form-label">Billing Period</label>
                        <input type="text" class="form-control" id="billPeriod">
                    </div>

                    <div class="mb-3" id="occupants-container">
                        <label for="occupants" class="form-label">Occupants</label>
                        <!-- Input groups will be added here dynamically -->
                    </div>
                    <button type="button" class="btn btn-primary mt-2" id="add-occupant-btn">Add Occupant</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="makeLeaseBtn">Generate Lease</button>
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
                <button type="button" class="btn btn-success" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>

    let occupantCount = 0, maxOccupants, requestId, tenantId, apartNum, leaseId;

    // Display All Pending Requests
    function retrieveReq() {
        fetch('handlers/admin/retrieveReq.php')
            .then(response => response.json())
            .then(data => {
                // Parse the requestDate to a consistent date format
                data.forEach(request => {
                    request.requestDate = new Date(request.requestDate).toISOString();
                });

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
                            Occupants: ${request.occupants} <br>
                        </td>
                        <td class="cl-table">${new Date(request.requestDate).toLocaleDateString()}</td>
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
                    maxOccupants = request.occupants;
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

    // Display Request Info Modal
    function showTenantModal(event) {
        const acceptBtn = event.target.closest('.cli-accept-btn'); // Find the closest .cli-accept-btn element to the clicked element
        if (!acceptBtn) return; // Exit if no matching button is found

        const tenantModal = new bootstrap.Modal(document.getElementById('addTenantModal'), {});
        tenantModal.show();

        // Retrieve data attributes
        requestId = acceptBtn.getAttribute('data-id');
        const requestData = JSON.parse(acceptBtn.getAttribute('data-request'));
        const apartmentData = JSON.parse(acceptBtn.getAttribute('data-apartment'));

        // Debugging Purpose - Feel free to comment out
        console.log(`Accepting request ${requestId}`);
        console.log('Request data:', requestData);
        console.log('Apartment data:', apartmentData);

        // Log the specific properties we are interested in
        console.log('Request data - apartmentNumber:', requestData.apartmentNumber);
        console.log('Apartment data - apartmentNumber:', apartmentData.apartmentNumber);

        // Debugging Purpose - Check if apartNum is set correctly
        apartNum = apartmentData.apartmentNumber;
        console.log('apartNum:', apartNum);

        // Populate modal fields with request data
        document.getElementById('firstName').value = requestData.firstName;
        document.getElementById('lastName').value = requestData.lastName;
        document.getElementById('middleName').value = requestData.middleName;
        document.getElementById('dob').value = requestData.dateOfBirth;
        document.getElementById('phoneNum').value = requestData.phoneNumber;
        document.getElementById('emailAdd').value = requestData.emailAddress;
        document.getElementById('deposit').value = apartmentData.rentPerMonth;
        document.getElementById('billPeriod').value = requestData.billingPeriod;
        document.getElementById('startDate').value = requestData.startDate;
        document.getElementById('endDate').value = requestData.endDate;
        document.getElementById('occupants').value = requestData.occupants;
    }

    // Dynamic Rows For Occupants
    document.addEventListener('DOMContentLoaded', (event) => {
        let occupantCount = 0;
        const occupantsContainer = document.getElementById('occupants-container');
        const addOccupantBtn = document.getElementById('add-occupant-btn');

        addOccupantBtn.addEventListener('click', () => {
            if (occupantCount < maxOccupants) {
                occupantCount++;
                const occupantDiv = document.createElement('div');
                occupantDiv.className = 'occupant-group mt-2';
                occupantDiv.id = `occupant-group-${occupantCount}`;
                occupantDiv.innerHTML = `
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="firstName" placeholder="First Name">
                    <input type="text" class="form-control" name="middleName" placeholder="Middle Name">
                    <input type="text" class="form-control" name="lastName" placeholder="Last Name">
                    <input type="text" class="form-control" name="gender" placeholder="Gender">
                    <input type="text" class="form-control" name="phone" placeholder="Phone">
                    <input type="email" class="form-control" name="email" placeholder="Email">
                    <button type="button" class="btn btn-danger remove-occupant-btn">X</button>
                </div>
            `;

                occupantsContainer.appendChild(occupantDiv);

                occupantDiv.querySelector('.remove-occupant-btn').addEventListener('click', () => {
                    occupantDiv.remove();
                    occupantCount--;
                });
            } else {
                alert('Maximum number of occupants reached');
            }
        });
    });


    function makeTenant() {
        const testBtn = document.getElementById('makeLeaseBtn');
        testBtn.addEventListener('click', function () {
            const tenantData = {
                firstName: document.getElementById('firstName').value,
                lastName: document.getElementById('lastName').value,
                middleName: document.getElementById('middleName').value,
                dateOfBirth: document.getElementById('dob').value,
                phoneNum: document.getElementById('phoneNum').value,
                email: document.getElementById('emailAdd').value,
                deposit: document.getElementById('deposit').value,
                reqID: requestId // Assuming requestId is defined elsewhere
            };

            fetch('handlers/admin/addTenant.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(tenantData)
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        console.log('Added tenant');
                        console.log('Tenant ID:', data.tenant_id);
                        tenantId = data.tenant_id;

                        const leaseData = {
                            startDate: document.getElementById('startDate').value,
                            endDate: document.getElementById('endDate').value,
                            billPeriod: document.getElementById('billPeriod').value,
                            tenant_ID: tenantId,
                            apartmentNum: apartNum // Assuming apartNum is defined elsewhere
                        };

                        return fetch('handlers/admin/addLease.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify(leaseData)
                        });
                    } else {
                        throw new Error('Failed to add tenant: ' + data.message);
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        console.log('Added Lease');
                        console.log('Lease ID:', data.lease_ID);
                        leaseId = data.lease_ID;

                        const occupantData = [];

                        document.querySelectorAll('.occupant-group').forEach(group => {
                            const occupant = {
                                firstName: group.querySelector('[name="firstName"]').value,
                                middleName: group.querySelector('[name="middleName"]').value,
                                lastName: group.querySelector('[name="lastName"]').value,
                                gender: group.querySelector('[name="gender"]').value,
                                phone: group.querySelector('[name="phone"]').value,
                                email: group.querySelector('[name="email"]').value,
                                lease_ID: leaseId
                            };

                            occupantData.push(occupant);
                        });

                        return fetch('handlers/admin/addOccupants.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({ occupants: occupantData })
                        });
                    } else {
                        throw new Error('Failed to add lease: ' + data.message);
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        alert('Successfully Added All Details');
                        const leaseModal = new bootstrap.Modal(document.getElementById('addTenantModal'), {});
                        //const successModal = new bootstrap.Modal(document.getElementById('successModal'), {});
                        leaseModal.hide();
                        //successModal.show();
                        // Add automatic close modal
                        retrieveReq();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    // Handle errors here, e.g., show an alert or log the error
                });
        });
    }

    // Call makeTenant() once the script is loaded
    makeTenant();


</script>