<?php
// user.php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['user_type'] !== 'Patient') {
  header('Location: login2.php');
  exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Patient Details Page</title>
  <style>
    table {
      border-collapse: collapse;
    }

    th, td {
      padding: 8px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }
  </style>
</head>
<body>
  <h1>View Personal Details</h1>
  <h2>Welcome, <?php echo $_SESSION['username']; ?></h2>

  <form method="POST" action="user.php">
    <label for="IDno">Patient ID:</label>
    <input type="text" id="IDno" name="IDno" required>
    <button type="submit">View Details</button>
  </form>

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

  // Retrieve the patient ID from the form submission
  if(isset($_POST['IDno'])) {
    $IDno = $_POST['IDno'];

    // Retrieve the personal details from the database
    $sql = "SELECT * FROM patientinfo WHERE IDno = :IDno";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':IDno', $IDno);
    $stmt->execute();

    // Fetch the personal details from the database
    $details = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($details) {
      // Display the personal details in a table
      echo "<h2>Patient Details</h2>";
      echo "<table>";
      echo "<tr><th>Field</th><th>Value</th></tr>";
      echo "<tr><td>Patient ID</td><td>" . $details['IDno'] . "</td></tr>";
      echo "<tr><td>First Name</td><td>" . $details['first_name'] . "</td></tr>";
      echo "<tr><td>Last Name</td><td>" . $details['last_name'] . "</td></tr>";
      echo "<tr><td>Email</td><td>" . $details['email'] . "</td></tr>";
      echo "<tr><td>Phone Number</td><td>" . $details['phoneNo'] . "</td></tr>";
      echo "<tr><td>Gender</td><td>" . $details['sex'] . "</td></tr>";
      // Add additional details you want to display
      echo "</table>";

    } else {
      echo "<p>No personal details found for the provided patient ID.</p>";
    }
  }
  
  // Close the connection
  $conn = null;
  ?>

  <!-- Button that redirects to another HTML file -->
  <br>
  <div class="center-button">
    <a href="medicalrec.html">
      <button>Next</button>
    </a>
  </div>
  </br>
</body>
</html>




