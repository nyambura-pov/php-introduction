<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <style>
    body {
      text-align: center;
      background-image: url("photo2.jpg"); /* Add your background image path here */
      background-size: cover;
      background-repeat: no-repeat;
    }
    table {
      margin: 0 auto;
      border-collapse: collapse;
      width: 70%;
      border: 1px solid black;
      background-color: rgba(255, 255, 255, 0.4); /* Set a background color for the table */
    }
    h2 {
      text-align: center;
      margin-bottom: 20px;
      color: black;
      text-decoration: underline;
    }
    th, td {
      padding: 8px;
      border: 1px solid #ccc;
    }
    th {
      background-color: #f2f2f2;
    }
  </style>
</head>
<body>
  <?php
  // Replace database connection details with your actual credentials
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "ePharmadb";

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $admin_username = $_POST["username"];
    $admin_password = $_POST["password"];

    // Perform admin login validation here
    // (Check if the admin credentials are valid and match the database records)
    // If valid, proceed to display the users

    // Create a database connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve all users and their roles from the database
    $sql = "SELECT username, email, name, phone_number, role FROM users"; // Include the new columns in the SELECT query
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      echo "<h1>Welcome!</h1>";
      echo "<h2>Users in the system</h2>";
      echo "<table>";
      echo "<tr><th>Username</th><th>Email</th><th>Name</th><th>Phone Number</th><th>Role</th></tr>"; // Include new headers

      while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["username"] . "</td>";
        echo "<td>" . $row["email"] . "</td>"; // Display the new columns
        echo "<td>" . $row["name"] . "</td>";
        echo "<td>" . $row["phone_number"] . "</td>";
        echo "<td>" . $row["role"] . "</td>";
        echo "</tr>";
      }

      echo "</table>";
      echo "<br>";
      echo '<button onclick="goBack()">Back</button>';
      echo '<script>function goBack() {window.history.back();}</script>';
    } else {
      echo "No users found.";
    }

    $conn->close();
  } else {
    echo "Error: Invalid request.";
  }
  ?>
</body>
</html>
