<?php
// Retrieve form data
$fname = $_POST['fname'];
$lname = $_POST['last-name'];
$email = $_POST['email'];
$IDnum = $_POST['IDnum'];
$phonenum = $_POST['phonenum'];
$gender = $_POST['gender'];


// Database connection configuration
$host = 'localhost';  // MySQL database host
$dbUser = 'root';  // MySQL username
$dbPass = '';  // MySQL password
$dbName = 'pharmacydb';  // MySQL database name

// Create database connection
$conn = new mysqli($host, $dbUser, $dbPass, $dbName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Insert data into database
$sql = "INSERT INTO info (fname, lname, email, IDnum, phonenum, gender) VALUES ('$fname', '$lname', '$email', '$IDnum', '$phonenum','$gender')";

if ($conn->query($sql) === true) {
    echo "Data inserted successfully!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close database connection
$conn->close();
?>



