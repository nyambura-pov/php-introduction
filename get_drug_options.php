<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ePharmadb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$options = '';

// Fetch drug data from the database and generate options for the dropdown
$sql = "SELECT drug_name FROM drugs"; // We only need the drug name for editing
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $options .= '<option value="' . $row["drug_name"] . '">' . $row["drug_name"] . '</option>';
  }
}

$conn->close();

echo $options;
?>
