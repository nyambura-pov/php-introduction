<?php
// Establish a connection to the database
$host = 'localhost';
$dbname = 'ePharmadb';
$username = 'root';
$password = '';

try {
  $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
  die("Connection failed: " . $e->getMessage());
}

// Retrieve data from the form
$username = $_POST['username'];
$password = $_POST['password'];
$user_type = $_POST['user'];

// Insert the data into the database
$sql = "INSERT INTO confirm (username, password, user_type) VALUES (:username, :password, :user_type)";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':username', $username);
$stmt->bindParam(':password', $password);
$stmt->bindParam(':user_type', $user_type);

if ($stmt->execute()) {
  echo "Registration successful!";
} else {
  echo "Error: " . $stmt->errorInfo()[2];
}

// Close the connection
$conn = null;
?>
