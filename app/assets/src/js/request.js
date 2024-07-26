// Function to set the current date
function setCurrentDate() {
    // Get the current date
    var today = new Date();

    // Format the date as YYYY-MM-DD
    var day = String(today.getDate()).padStart(2, '0');
    var month = String(today.getMonth() + 1).padStart(2, '0'); // Months are zero-based
    var year = today.getFullYear();

    var formattedDate = year + '-' + month + '-' + day;

    // Set the value of the date input field
    document.getElementById('reqDate').value = formattedDate;
}

// Call the function when the window loads
window.onload = function() {
    setCurrentDate();
};