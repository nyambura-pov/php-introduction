<!DOCTYPE html>
<html>
<head>
  <title>View Personal Details</title>
</head>
<body>
  <h1>View Personal Details</h1>

  <form action="view_details.php" method="post"> <!-- Use method="post" here -->
    <label for="IDno">Enter Patient ID:</label>
    <input type="text" name="IDno" required>
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
      // Display the personal details
      echo "<h2>Patient ID: " . $details['IDno'] . "</h2>";
      echo "<p>Name: " . $details['first_name'] . "</p>";
      echo "<p>Email: " . $details['email'] . "</p>";
      // Add additional details you want to display

    } else {
      echo "<p>No personal details found for the provided patient ID.</p>";
    }
  } else {
    echo "<p>Error: Invalid request.</p>";
  }

  // Close the connection
  $conn = null;
  ?>
</body>
</html>
