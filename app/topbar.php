<?php

// Set a session variable for the user's name (for demonstration purposes)
$_SESSION['username'] = 'Lance'; // This would be fetched from the database in a real application

// Get the user's name from the session
$userName = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
?>

<nav class="navbar navbar-expand-lg navbar-light fixed-top navbar-custom">
    <div class="container">
        <div class="d-flex justify-content-between w-100">
            <div id="greeting"></div>
            <b id="time"></b>
        </div>
    </div>
</nav>

<style>
    .navbar-custom {
        margin-left: 200px;
    }
</style>

<script>
    // Get the current date and time
    var today = new Date();

    // Days of the week array
    var days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

    // Extract day of the week, hours, minutes, and AM/PM from the current date
    var dayOfWeek = days[today.getDay()];
    var hours = today.getHours();
    var minutes = today.getMinutes();
    var ampm = hours >= 12 ? 'PM' : 'AM';

    // Convert hours to 12-hour format
    hours = hours % 12;
    hours = hours ? hours : 12; // The hour '0' should be '12' in 12-hour format

    // Add leading zeros to minutes if less than 10
    minutes = minutes < 10 ? '0' + minutes : minutes;

    // Display time and day of the week in desired format
    var timeString = dayOfWeek + ', ' + hours + ':' + minutes + ' ' + ampm;

    // Update the content of the element with id 'time'
    document.getElementById('time').innerHTML = timeString;

    // Get the user's name from PHP
    var userName = '<?php echo $userName; ?>';

    // Determine the greeting based on the current hour
    var greeting;
    if (today.getHours() < 12) {
        greeting = 'Good Morning';
    } else if (today.getHours() < 18) {
        greeting = 'Good Afternoon';
    } else {
        greeting = 'Good Evening';
    }

    // Update the greeting element
    document.getElementById('greeting').innerHTML = `${greeting}, ${userName}`;
</script>