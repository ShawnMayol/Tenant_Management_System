<!doctype html>
<html lang="en" data-bs-theme="auto">
<head>
  <script src="assets\js\color-modes.js"></script>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sign Up</title>
  <link href="assets\dist\css\bootstrap.min.css" rel="stylesheet">
  <link href="styles\signup.css" rel="stylesheet">
  <link rel="icon" href="assets\pictures\web-icon.png">
  <link href="assets\fontawesome-free-6.5.2-web\css\all.min.css" rel="stylesheet">
</head>

<style>
  .field-icon:hover {
    cursor: pointer ;
  }

  .field-icon i {
  font-size: 1rem;
  padding: 1rem;
}
</style>

<body class="bg-body-tertiary">

  <!-- Theme Logo -->
  <svg xmlns="http://www.w3.org/2000/svg" class="d-none">
    <symbol id="check2" viewBox="0 0 16 16">
      <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
    </symbol>
    <symbol id="circle-half" viewBox="0 0 16 16">
      <path d="M8 15A7 7 0 1 0 8 1v14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z"/>
    </symbol>
    <symbol id="moon-stars-fill" viewBox="0 0 16 16">
      <path d="M6 .278a.768.768 0 0 1 .08.858 7.208 7.208 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277.527 0 1.04-.055 1.533-.16a.787.787 0 0 1 .81.316.733.733 0 0 1-.031.893A8.349 8.349 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.752.752 0 0 1 6 .278z"/>
      <path d="M10.794 3.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387a1.734 1.734 0 0 0-1.097 1.097l-.387 1.162a.217.217 0 0 1-.412 0l-.387-1.162A1.734 1.734 0 0 0 9.31 6.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387a1.734 1.734 0 0 0 1.097-1.097l.387-1.162zM13.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.156 1.156 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.156 1.156 0 0 0-.732-.732l-.774-.258a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732L13.863.1z"/>
    </symbol>
    <symbol id="sun-fill" viewBox="0 0 16 16">
      <path d="M8 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-4.657a.5.5 0 0 1 0 .707l-1.414 1.414a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707l-1.414 1.414a.5.5 0 1 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 0a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z"/>
  </svg>

  <!-- Theme Dropdown -->
  <div class="dropdown position-fixed bottom-0 end-0 mb-3 me-3 bd-mode-toggle">
    <button class="btn btn-bd-primary py-2 dropdown-toggle d-flex align-items-center"
            id="bd-theme"
            type="button"
            aria-expanded="false"
            data-bs-toggle="dropdown"
            aria-label="Toggle theme (auto)">
      <svg class="bi my-1 theme-icon-active" width="1em" height="1em"><use href="#circle-half"></use></svg>
      <span class="visually-hidden" id="bd-theme-text">Toggle theme</span>
    </button>
    <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="bd-theme-text">
      <li>
        <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="light" aria-pressed="false">
          <svg class="bi me-2 opacity-50" width="1em" height="1em"><use href="#sun-fill"></use></svg>
          Light
          <svg class="bi ms-auto d-none" width="1em" height="1em"><use href="#check2"></use></svg>
        </button>
      </li>
      <li>
        <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="dark" aria-pressed="false">
          <svg class="bi me-2 opacity-50" width="1em" height="1em"><use href="#moon-stars-fill"></use></svg>
          Dark
          <svg class="bi ms-auto d-none" width="1em" height="1em"><use href="#check2"></use></svg>
        </button>
      </li>
      <li>
        <button type="button" class="dropdown-item d-flex align-items-center active" data-bs-theme-value="auto" aria-pressed="true">
          <svg class="bi me-2 opacity-50" width="1em" height="1em"><use href="#circle-half"></use></svg>
          Auto
          <svg class="bi ms-auto d-none" width="1em" height="1em"><use href="#check2"></use></svg>
        </button>
      </li>
    </ul>
  </div>

<div class="container">

  <div class="form-signup">
    <form method="POST">
      <img class="mb-4" src="assets/pictures/web-icon.png" alt="" width="72" height="60">
      <h1 class="h3 mb-3 fw-normal">Create Account</h1>

      <div class="name-fields d-flex justify-content-between">
        <div class="form-floating me-1 flex-fill">
          <input type="text" class="form-control" id="firstName" placeholder="First Name" required>
          <label for="firstName">First Name</label>
        </div>
        <div class="form-floating mx-1 flex-fill">
          <input type="text" class="form-control" id="middleName" placeholder="Middle Name">
          <label for="middleName">Middle Name</label>
        </div>
        <div class="form-floating ms-1 flex-fill">
          <input type="text" class="form-control" id="lastName" placeholder="Last Name" required>
          <label for="lastName">Last Name</label>
        </div>
      </div>

      <div class="form-floating">
        <input type="date" class="form-control" id="birthDate" placeholder="Birth Date" required>
        <label for="birthDate">Birth Date</label>
      </div>

      <div class="form-floating">
        <input type="tel" class="form-control" id="phoneNumber" placeholder="Phone Number" required>
        <label for="phoneNumber">Phone Number</label>
      </div>

      <div class="form-floating">
        <input type="email" class="form-control" id="email" placeholder="name@example.com" required>
        <label for="email">Email address</label>
      </div>

      <div class="form-floating d-flex align-items-center position-relative">
        <input type="password" class="form-control" id="password" placeholder="Password" required>
        <label for="password">Password</label>
        <span class="field-icon toggle-password position-absolute end-0 top-50 translate-middle-y">
            <i class="fas fa-eye"></i>
          </span>
      </div>

      <div class="form-floating d-flex align-items-center position-relative">
        <input type="password" class="form-control" id="confirmPassword" placeholder="Confirm Password" required>
        <label for="confirmPassword">Confirm Password</label>
        <span class="field-icon toggle-confirm-password position-absolute end-0 top-50 translate-middle-y">
            <i class="fas fa-eye"></i>
      </div>

      <div class="d-flex justify-content-start my-3">
        <a href="login.php" class="text-decoration-none">Already have an account?</a>
      </div>

      <button class="btn btn-primary w-100 py-2" type="submit">Sign up</button>
      <p class="mt-5 mb-3 text-body-secondary">&copy; C-Apartments 2024</p>
    </form>
  </div>
</div>
<script src="assets\dist\js\bootstrap.bundle.min.js"></script>
<script src="assets\signup.js"></script>
</body>
</html>