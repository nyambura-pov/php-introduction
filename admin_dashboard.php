<?php
session_start();

// Replace database connection details with your actual credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ePharmadb";

// Function to validate admin credentials
function validateAdminCredentials($conn, $username, $password) {
  $sql = "SELECT id, role FROM users WHERE username = ? AND password = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ss", $username, $password);
  $stmt->execute();
  $stmt->store_result();

  return $stmt->num_rows > 0;
}

// Function to fetch all users from the database
function getAllUsers($conn) {
  $sql = "SELECT id, username, role FROM users";
  $result = $conn->query($sql);

  $users = array();
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $users[] = $row;
    }
  }

  return $users;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $conn = new mysqli($servername, $username, $password, $dbname);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $username = $_POST["username"];
  $password = $_POST["password"];

  if (validateAdminCredentials($conn, $username, $password)) {
    // Admin logged in successfully, store the username in the session
    $_SESSION["admin_username"] = $username;
  } else {
    echo "Invalid credentials. Please try again.";
  }

  $conn->close();
}

// Check if the admin is logged in
if (isset($_SESSION["admin_username"])) {
  // Display the admin dashboard with all users
  $conn = new mysqli($servername, $username, $password, $dbname);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $users = getAllUsers($conn);
  $conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
</head>
<body>
  <h2>Admin Dashboard</h2>
  <p>Welcome, <?php echo $_SESSION["admin_username"]; ?>!</p>

  <h3>All Users:</h3>
  <table>
    <tr>
      <th>ID</th>
      <th>Username</th>
      <th>Role</th>
    </tr>
    <?php
      foreach ($users as $user) {
        echo "<tr>";
        echo "<td>" . $user["id"] . "</td>";
        echo "<td>" . $user["username"] . "</td>";
        echo "<td>" . $user["role"] . "</td>";
        echo "</tr>";
      }
    ?>
  </table>

  <p><a href="logout.php">Logout</a></p>
</body>
</html>
<?php
} // End of admin dashboard display
?>
