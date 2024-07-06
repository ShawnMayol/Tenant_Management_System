<?php
include('../../core/database.php');

$priceRange = $_GET['priceRange'] ?? '';
$status = $_GET['status'] ?? '';
$sortBy = $_GET['sortBy'] ?? '';

$priceCondition = '';
if ($priceRange) {
    $range = explode('-', $priceRange);
    $priceCondition = "AND rentPerMonth BETWEEN {$range[0]} AND {$range[1]}";
} elseif ($priceRange === '9000-10000') {
    $priceCondition = "AND rentPerMonth >= 9000";
}

$statusCondition = '';
if ($status) {
    $statusCondition = "AND apartmentStatus = '{$status}'";
}

$orderCondition = 'ORDER BY ';
if ($sortBy === 'rentAsc') {
    $orderCondition .= 'rentPerMonth ASC';
} elseif ($sortBy === 'rentDesc') {
    $orderCondition .= 'rentPerMonth DESC';
} else {
    $orderCondition .= 'apartmentStatus, apartmentType';
}

$sql = "SELECT apartmentNumber, apartmentType, rentPerMonth, apartmentPictures, apartmentStatus 
        FROM apartment 
        WHERE apartmentStatus <> 'Hidden' $priceCondition $statusCondition $orderCondition";

$result = $conn->query($sql);

$apartments = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $apartments[] = $row;
    }
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($apartments);
?>
