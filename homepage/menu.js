document.getElementById('apartments-btn').addEventListener('click', function() {
    document.getElementById('display-content').innerHTML = '<br><h3>APARTMENTS</h3>';
  });

  document.getElementById('invoice-btn').addEventListener('click', function() {
    document.getElementById('display-content').innerHTML = '<br><h3>INVOICE</h3>';
  });

  document.getElementById('history-btn').addEventListener('click', function() {
    document.getElementById('display-content').innerHTML = '<br><h3>PAYMENT HISTORY</h3>';
  });

  document.getElementById('req-maintenance-btn').addEventListener('click', function() {
    document.getElementById('display-content').innerHTML = '<br><h3>MAINTENANCE REQUEST</h3>';
  });

  document.getElementById('status-maintenance-btn').addEventListener('click', function() {
    document.getElementById('display-content').innerHTML = '<br><h3>MAINTENANCE STATUS</h3>';
  });

  document.getElementById('account-new-btn').addEventListener('click', function() {
    document.getElementById('display-content').innerHTML = '<br><h3>NEW ACCOUNT</h3>';
  });

  document.getElementById('account-profile-btn').addEventListener('click', function() {
    document.getElementById('display-content').innerHTML = '<br><h3>PROFILE</h3>';
  });

  document.getElementById('account-settings-btn').addEventListener('click', function() {
    document.getElementById('display-content').innerHTML = '<br><h3>SETTINGS</h3>';
  });

  document.getElementById('account-signout-btn').addEventListener('click', function() {
    document.getElementById('display-content').innerHTML = '<br><h3>SIGN OUT</h3>';
  });

  document.addEventListener('DOMContentLoaded', function () {
    const dropdowns = document.querySelectorAll('[data-bs-toggle="collapse"]');

    dropdowns.forEach(dropdown => {
      dropdown.addEventListener('click', function () {
        const currentTarget = this.dataset.bsTarget;
        dropdowns.forEach(otherDropdown => {
          const otherTarget = otherDropdown.dataset.bsTarget;
          if (otherTarget !== currentTarget && document.querySelector(otherTarget).classList.contains('show')) {
            new bootstrap.Collapse(document.querySelector(otherTarget), {
              toggle: true
            });
          }
        });
      });
    });
  });

