<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div>
        <div class="client-title">
            <h1 class="h1 mb-3 fw-normal">CLIENTS</h1>
        </div>

        <div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Birthday</th>
                        <th scope="col">Email</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Valid ID</th>
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
    // DEFAULT (OLD)
    // function retrieveReq() {
    //     fetch('handlers/admin/retrieveReq.php')
    //         .then(response => response.json())
    //         .then(data => {
    //             const tableBody = document.getElementById('client-table-body');
    //             data.forEach(request => {
    //                 const row = document.createElement('tr');
    //                 row.innerHTML = `
    //                     <td class="cl-table">${request.Name}</td>
    //                     <td class="cl-table">${request.birth_date}</td>
    //                     <td class="cl-table">${request.email}</td>
    //                     <td class="cl-table">${request.phone_number}</td>
    //                     <td class="cl-table"><a href="${request.id_attachment}" target="_blank">View/Download</a></td>
    //                     <td>
    //                       <button class="btn btn-sm btn-success cli-accept-btn" data-id="${request.request_id}">Accept</button>
    //                       <button class="btn btn-sm btn-danger cli-reject-btn" data-id="${request.request_id}">Reject</button>
    //                     </td>
    //                 `;
    //                 tableBody.appendChild(row);
    //             });
    //             // Add event listeners for accept and reject button
    //             document.querySelectorAll('.cli-accept-btn').forEach(button => {
    //                 button.addEventListener('click', moveToTenants);
    //             });
    //             document.querySelectorAll('.cli-reject-btn').forEach(button => {
    //                 button.addEventListener('click', removeClient);
    //             });
    //         })
    //         .catch(error => {
    //             console.error('Error fetching clients:', error);
    //         });
    // }
    function retrieveReq() {
    fetch('handlers/admin/retrieveReq.php')
        .then(response => response.json())
        .then(data => {
            const tableBody = document.getElementById('client-table-body');
            data.forEach(request => {
                const row = document.createElement('tr');
                
                // Generate links for each attachment
                let attachmentsHTML = '';
                request.id_attachment.forEach((attachment, index) => {
                    attachmentsHTML += `<a href="${attachment}" target="_blank">View Picture ${index + 1}</a><br>`;
                });
                
                row.innerHTML = `
                    <td class="cl-table">${request.Name}</td>
                    <td class="cl-table">${request.birth_date}</td>
                    <td class="cl-table">${request.email}</td>
                    <td class="cl-table">${request.phone_number}</td>
                    <td class="cl-table">${attachmentsHTML}</td>
                    <td class="cl-table ">
                      <button class="btn btn-sm btn-success cli-accept-btn" data-id="${request.request_id}">Accept</button>
                      <button class="btn btn-sm btn-danger cli-reject-btn" data-id="${request.request_id}">Reject</button>
                    </td>
                `;
                tableBody.appendChild(row);
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
</script>
