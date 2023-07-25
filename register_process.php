<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Replace database connection details with your actual credentials
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

  // Retrieve user input from the form
  $username = $_POST["username"];
  $password = $_POST["password"];
  $email = $_POST["email"];          // New column - Email
  $name = $_POST["name"];            // New column - Name
  $phone_number = $_POST["phone_number"];  // New column - Phone Number
  $role = $_POST["role"];

  // Hash the password for security (use a secure hashing algorithm like bcrypt)
  $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

  // Insert the data into the database
  $sql = "INSERT INTO users (username, password, email, name, phone_number, role) 
          VALUES (:username, :password, :email, :name, :phone_number, :role)";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':username', $username);
  $stmt->bindParam(':password', $hashedPassword);
  $stmt->bindParam(':email', $email);          // New column - Email
  $stmt->bindParam(':name', $name);            // New column - Name
  $stmt->bindParam(':phone_number', $phone_number);  // New column - Phone Number
  $stmt->bindParam(':role', $role);

  if ($stmt->execute()) {
    echo "Registration successful!";
  } else {
    echo "Error: " . $stmt->errorInfo()[2];
  }

  // Close the connection
  $conn = null;
}
?>
