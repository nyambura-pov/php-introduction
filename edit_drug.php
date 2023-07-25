<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Drug</title>
</head>
<body>
  <h2>Edit Drug</h2>
  
  <?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle form submission to update the drug details in the database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "ePharmadb";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    $drug_id = $_POST['drug_id'];
    $new_drug_name = $_POST['new_drug_name'];
    $new_strength = $_POST['new_strength'];

    $sql = "UPDATE drugs SET drug_name='$new_drug_name', strength='$new_strength' WHERE drug_id='$drug_id'";

    if ($conn->query($sql) === TRUE) {
      echo "Drug details updated successfully.";
    } else {
      echo "Error updating drug details: " . $conn->error;
    }

    $conn->close();
  } else {
    // Show the form to select and edit the drug
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "ePharmadb";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    $drug_name = $_GET['drug_name'];

    $sql = "SELECT drug_id, drug_name, strength FROM drugs WHERE drug_name='$drug_name'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      $drug_id = $row['drug_id'];
      $drug_name = $row['drug_name'];
      $strength = $row['strength'];

      // Display the form to edit drug details
      echo '
        <form action="edit_drug.php" method="post">
          <input type="hidden" name="drug_id" value="' . $drug_id . '">

          <label for="new_drug_name">New Drug Name:</label>
          <input type="text" name="new_drug_name" value="' . $drug_name . '" required>

          <label for="new_strength">New Strength:</label>
          <input type="text" name="new_strength" value="' . $strength . '" required>

          <button type="submit">Save Changes</button>
        </form>
      ';
    } else {
      echo "Drug not found.";
    }

    $conn->close();
  }
  ?>
</body>
</html>
