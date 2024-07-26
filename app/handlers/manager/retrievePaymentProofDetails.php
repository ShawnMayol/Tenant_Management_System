<?php
include('core/database.php'); // Include your database connection script

if (isset($_GET['paymentProof_ID'])) {
    $paymentProof_ID = intval($_GET['paymentProof_ID']);

    $query = "SELECT *
              FROM paymentproof pp
              LEFT JOIN invoice i ON pp.invoice_ID = i.invoice_ID
              LEFT JOIN fees fe ON i.fee_ID = fe.fee_ID
              LEFT JOIN bill b ON i.invoice_ID = b.invoice_ID
              LEFT JOIN lease le ON le.lease_ID = fe.lease_ID
              LEFT JOIN tenant te ON te.tenant_ID = le.tenant_ID
              LEFT JOIN apartment ap ON le.apartmentNumber = ap.apartmentNumber
              LEFT JOIN user us ON us.tenant_ID = te.tenant_ID
              WHERE pp.paymentProof_ID = ?";

    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("i", $paymentProof_ID);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
        } else {
            $data = null;
        }

        $stmt->close();
    } else {
        // Display error message if the statement could not be prepared
        echo "Error preparing statement: " . $conn->error;
        $data = null;
    }
} else {
    $data = null;
}

$conn->close();

