<?php
session_start();
include '../../core/database.php';

$loggedInUserID = $_SESSION['user_id'] ?? null;

$sql = "SELECT l.rentalDeposit, l.startDate, a.rentPerMonth, l.lease_ID, l.endDate, l.createdOn, l.reviewedBy
        FROM lease l
        JOIN apartment a ON l.apartmentNumber = a.apartmentNumber
        JOIN tenant t ON t.lease_ID = l.lease_ID
        JOIN user u ON u.tenant_ID = t.tenant_ID
        WHERE u.user_ID = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $loggedInUserID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($data = $result->fetch_assoc()) {

        $deposit = $data['rentalDeposit'];
        $startDate = new DateTime($data['startDate']);
        $rentPerMonth = $data['rentPerMonth'];
        $leaseID = $data['lease_ID'];
        $createDate = $data['createdOn'];
        $reviewedByStaff = $data['reviewedBy'];

        //$endDate = new DateTime($data['endDate']);    //Makes bill until end of term

        // Retrieves the Current Date
        $nowDate = date('Y-m-d');   
        $tempNowDate = new DateTime($nowDate);
        $tempNowDate = $tempNowDate->modify('first day of next month');

        // Calculate number of months covered by the deposit
        $monthsCoveredByDeposit = floor($deposit / $rentPerMonth);

        // Generate bills for each month from startDate to endDate
        $currentDate = clone $startDate;
        $monthsCount = 0;
        while ($currentDate <= $tempNowDate) {                              // replace with $endDate to make bills until end of term
            // Set the bill date to the 28th of the current month
            $billDate = $currentDate->format('Y-m') . '-28';
            
            // Calculate due date (7 days after bill date)
            $dueDate = (new DateTime($billDate))->modify('+7 days')->format('Y-m-d');

            // Determine bill status
            //$billStatus = ($monthsCount < $monthsCoveredByDeposit) ? 'Paid by Deposit' : 'Pending';
            if($monthsCount < $monthsCoveredByDeposit){
                $billStatus = 'Paid by Deposit';
                $paidAmount = $rentPerMonth;
                $paidByDeposit = true;
            }
            else{
                $billStatus = 'Pending';
                $paidAmount = 0;
            }
            
            // Generate bill using the function
            $recentBillID = generateBills($conn, $leaseID, $rentPerMonth, $billDate, $dueDate, $billStatus, $paidAmount);
            
            if($paidByDeposit){
            // Update Payments
            $stmt = $conn->prepare("INSERT INTO payments (bill_ID, paymentAmount, proofOfPayment,receivedBy, paymentDate, paymentStatus) VALUES (?, ?, 'Paid by Deposit', ?, ? ,'Received')");
            $stmt->bind_param("idis", $recentBillID, $deposit,$reviewedByStaff,$createDate);
            $stmt->execute();
            $stmt->close();
            }

            // Move to the next month
            $currentDate = $currentDate->modify('first day of next month');
            $paidByDeposit = false; 
            $monthsCount++;
        }
    }
} else {
    echo "No leases found for the logged-in user.";
}

$stmt->close();
$conn->close();

function generateBills($conn, $leaseID, $rentPerMonth, $billDate, $dueDate, $billStatus, $paidAmount)
{
    $sql = "INSERT INTO bill (lease_id, dueDate, billDate,amountDue, billStatus, amountPaid) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issdsd", $leaseID, $dueDate,$billDate, $rentPerMonth, $billStatus, $paidAmount);
    $stmt->execute();

    // Retrieve the ID of the newly created row
    $newBillID = $stmt->insert_id;

    $stmt->close();
    return $newBillID;
}

