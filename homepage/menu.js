document.getElementById('apartments-btn').addEventListener('click', function() {
    document.getElementById('display-content').innerText = 'hello';
  });

  document.getElementById('invoice-btn').addEventListener('click', function() {
    document.getElementById('display-content').innerText = 'Happy Birthday';
  });

  document.getElementById('req-maintenance-btn').addEventListener('click', function() {
    document.getElementById('display-content').innerText = 'Waxxupt';
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

