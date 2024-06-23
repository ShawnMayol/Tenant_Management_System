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

  document.getElementById('admin-users-btn').addEventListener('click', function() {
    document.getElementById('display-content').innerHTML = '<br><h3>MAINTENANCE REQUEST</h3>';
  });

  document.getElementById('account-btn').addEventListener('click', function() {
    document.getElementById('display-content').innerText = 'otin';
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

