document.addEventListener("DOMContentLoaded", function () {
    document.getElementById('admin-users-btn').addEventListener('click', function () {
      loadUsersTable();
    });
  });
  
  function loadUsersTable() {
    const displayContent = document.getElementById('display-content');
    displayContent.innerHTML = `
      <table class="table table-striped" id="users-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Email</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <!-- User rows will be appended here by JavaScript -->
        </tbody>
      </table>
    `;
  
    fetchUsers();
  }
  
  function fetchUsers() {
    fetch('fetch_users.php')
      .then(response => response.json())
      .then(users => {
        const tbody = document.querySelector('#users-table tbody');
        tbody.innerHTML = '';
  
        users.forEach(user => {
          const row = document.createElement('tr');
          row.innerHTML = `
            <td>${user.id}</td>
            <td><input type="text" value="${user.email}" data-id="${user.id}" class="form-control email-input"></td>
            <td>
              <button class="btn btn-sm btn-primary edit-btn" data-id="${user.id}">Edit</button>
              <button class="btn btn-sm btn-danger delete-btn" data-id="${user.id}">Delete</button>
            </td>
          `;
          tbody.appendChild(row);
        });
  
        // Add event listeners for edit and delete buttons
        document.querySelectorAll('.edit-btn').forEach(button => {
          button.addEventListener('click', handleEdit);
        });
        document.querySelectorAll('.delete-btn').forEach(button => {
          button.addEventListener('click', handleDelete);
        });
      })
      .catch(error => {
        console.error('Error fetching users:', error);
      });
  }
  
  function handleEdit(event) {
    const id = event.target.getAttribute('data-id');
    const emailInput = document.querySelector(`input[data-id="${id}"]`);
    const email = emailInput.value;
  
    fetch('edit_user.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({ id, email })
    })
    .then(response => response.json())
    .then(data => {
      if (data.status === 'success') {
        alert('Email updated successfully');
      } else {
        alert('Error updating email: ' + data.message);
      }
    })
    .catch(error => {
      console.error('Error:', error);
    });
  }
  
  function handleDelete(event) {
    const id = event.target.getAttribute('data-id');
  
    fetch('delete_user.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({ id })
    })
    .then(response => response.json())
    .then(data => {
      if (data.status === 'success') {
        alert('User deleted successfully');
        loadUsersTable(); // Reload the table to reflect changes
      } else {
        alert('Error deleting user: ' + data.message);
      }
    })
    .catch(error => {
      console.error('Error:', error);
    });
  }
  