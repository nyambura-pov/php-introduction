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

if (isset($_GET['IDno'])) {
    $id = $_GET['IDno'];

    // Delete the record with the specified ID
    $sql = "DELETE FROM patientinfo WHERE IDno = '$id'";
    if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully.";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    echo "Invalid request. Please provide a valid ID.";
}

$conn->close();
?>

