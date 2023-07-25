<?php
// Establishing connection to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ePharmadb";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $IDno = $_POST['IDno'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $sex = $_POST['sex'];
    $email = $_POST['email'];
    $phoneNo = $_POST['phoneNo'];

    // Update the record in the database
    $sql = "UPDATE patientinfo SET first_name = '$first_name', last_name = '$last_name', sex = '$sex', email = '$email', phoneNo = '$phoneNo' WHERE IDno = '$IDno'";

    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully.";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

$conn->close();
?>
