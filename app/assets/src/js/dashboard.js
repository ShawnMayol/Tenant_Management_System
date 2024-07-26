document.getElementById('lease-btn').addEventListener('click', function () {
  document.getElementById('display-content').innerHTML = '';
  loadLeaseForm()
});

document.getElementById('client-btn').addEventListener('click', function () {
  document.getElementById('display-content').innerHTML = '';
  showClients()
});

// Display Lease Form (Admin Side)
function loadLeaseForm() {
  const displayContent = document.getElementById('display-content');
  displayContent.innerHTML = `
  
  <div class="form-signup">
    <form action="" method="">
      <h1 class="h3 mb-3 fw-normal">Tenant Lease Form</h1>

      <div class="name-fields d-flex justify-content-between">
        <div class="form-floating me-1 flex-fill">
          <input type="text" class="form-control" id="firstName" name="firstName" placeholder="First Name" required>
          <label for="firstName">Tenant ID:</label>
        </div>
      </div>

      <div class="form-floating">
        <input type="date" class="form-control" id="startDate" name="startDate" placeholder="Start Date" required>
        <label for="startDate">Start Date</label>
      </div>

      <div class="form-floating">
        <input type="date" class="form-control" id="endDate" name="endDate" placeholder="End Date" required>
        <label for="endDate">End Date</label>
      </div>

      <div class="form-floating">
        <select name="bill-period" class="form-select">
            <option value="Monthly">Monthly</option>
            <option value="Quarterly">Quarterly</option>
            <option value="Anually">Anually</option>
        </select>
        <label for="billPeriod">Bill Period</label>
      </div>

      <div class="form-floating">
        <select name="bill-period" class="form-select">
            <option value="Monthly">End of the Month</option>
        </select>
        <label class="form-label">Billing Cycle</label>
      </div>

      <div class="form-floating">
        <select name="status" class="form-select">
            <option value="Active">Active</option>
        </select>
        <label class="form-label">Status</label>
      </div>

      <button class="btn btn-primary w-100 py-2" id="upLease-btn" type="submit">Upload Lease</button>
      <p class="mt-3 text-body-secondary">&copy; C-Apartments 2024</p>
    </form>
  </div>
  `;
}

// Display Client (Admin Side)
function showClients() {
  const displayContent = document.getElementById('display-content');
  displayContent.innerHTML = `

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
  `
  fetchClients();
}

function fetchClients() {
  fetch('./client/ret_client.php')
    .then(response => response.json())
    .then(data => {
      const tableBody = document.getElementById('client-table-body');
      data.forEach(clients => {
        const row = document.createElement('tr');
        row.innerHTML = `
                        <td class="cl-table">${clients.Name}</td>
                        <td class="cl-table">${clients.birth_date}</td>
                        <td class="cl-table">${clients.email}</td>
                        <td class="cl-table">${clients.phone_number}</td>
                        <td class="cl-table"><a href="${clients.id_attachment}" target="_blank">View/Download</a></td>
                        <td>
                          <button class="btn btn-sm btn-success cli-accept-btn" data-id="${clients.id}">Accept</button>
                          <button class="btn btn-sm btn-danger cli-reject-btn" data-id="${clients.id}">Reject</button>
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

function moveToTenants() {
    // Move the data from client table to tenant table
    // Remove the data in the client table
}

function removeClient() {
    // Delete the client data from the table
    // I'm not sure if deleting is a proper way can you provide an alternative?
}


