<?php
// Establishing connection to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pharmacydb";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to update prescription status to "dispensed" based on the prescription ID
function dispenseMedicine($conn, $prescriptionId) {
    $sql = "UPDATE prescriptions SET status = 'dispensed' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $prescriptionId);
    if ($stmt->execute()) {
        return true; // Dispense successful
    } else {
        return false; // Dispense failed
    }
}

// Function to retrieve drugs prescribed by doctors
function getPrescriptions($conn) {
    $sql = "SELECT id, doctor_id, patient_id, drug_name, frequency, status FROM prescriptions";
    $result = $conn->query($sql);
    if (!$result) {
        // Error handling for the query
        die("Error retrieving prescriptions: " . $conn->error);
    }
    return $result->fetch_all(MYSQLI_ASSOC);
}
?>