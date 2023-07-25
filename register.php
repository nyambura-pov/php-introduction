<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Registration</title>
</head>
<body>
  <h2>User Registration</h2>
  <form action="register_process.php" method="post">
    <label for="username">Username:</label>
    <input type="text" name="username" required>

    <label for="password">Password:</label>
    <input type="password" name="password" required>

    <label for="role">Role:</label>
    <select name="role" required>
      <option value="admin">Admin</option>
      <option value="doctor">Doctor</option>
      <option value="patient">Patient</option>
      <option value="pharmacist">Pharmacist</option>
    </select>

    <button type="submit">Register</button>
  </form>
</body>
</html>

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

// Insert the data into the database
$sql = "INSERT INTO users (username, password, role) VALUES (:username, :password, :role)";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':username', $username);
$stmt->bindParam(':password', $password);
$stmt->bindParam(':user_type', $role);

if ($stmt->execute()) {
  echo "Registration successful!";
} else {
  echo "Error: " . $stmt->errorInfo()[2];
}

// Close the connection
$conn = null;
?>

