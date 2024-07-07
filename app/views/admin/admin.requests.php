<style>
    table thead th {
    padding-top: 10px; /* Adjust this value as needed */
    padding-bottom: 20px !important; /* Adjust this value as needed */
}

table thead {
    margin-bottom: 10px; /* Adjust this value if necessary */
}

</style>


<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
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

<script>
    function retrieveReq() {
    fetch('handlers/admin/retrieveReq.php')
        .then(response => response.json())
        .then(data => {
            const tableBody = document.getElementById('client-table-body');
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
                                  <button class="btn btn-sm btn-success cli-accept-btn" data-id="${request.request_ID}">Accept</button>
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
            // Add event listeners for accept and reject button
            document.querySelectorAll('.cli-accept-btn').forEach(button => {
                button.addEventListener('click', moveToTenants);
            });
            document.querySelectorAll('.cli-reject-btn').forEach(button => {
                button.addEventListener('click', removeClient);
            });
        })
        .catch(error => {
            console.error('Error fetching clients:', error);
        });
}

// Call retrieveReq() once the script is loaded
retrieveReq();

// Fetch apartment name based on apartmentId
function fetchApartmentName(apartmentId) {
    return fetch(`handlers/admin/retrieveApartment.php?apartmentId=${apartmentId}`)
        .then(response => response.json())
        .catch(error => {
            console.error('Error fetching apartment name:', error);
            throw new Error('Failed to fetch apartment name.');
        });
}


</script>

