<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Drugs</title>
</head>
<body>
  <h2>Add/Edit Drugs</h2>
  <form action="process_drugs.php" method="post">
    <input type="hidden" name="action" value="add"> <!-- Hidden field to indicate action -->

    <label for="drug_name">Drug Name:</label>
    <input type="text" name="drug_name" required>

    <label for="strength">Strength:</label>
    <input type="text" name="strength" required>

    <button type="submit">Add Drug</button>
  </form>

  <hr>

  <h2>Edit Drugs</h2>
  <form action="process_drugs.php" method="post">
    <input type="hidden" name="action" value="edit"> <!-- Hidden field to indicate action -->

    <label for="drug_id">Select Drug to Edit:</label>
    <select name="drug_id" required>
      <!-- Options for selecting drug to edit -->
      <?php
        // PHP code to fetch drug data from the database and populate the dropdown
        // Replace database connection details with your actual credentials
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "ePharmadb";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT drug_id, drug_name FROM drugs";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            echo '<option value="' . $row["drug_id"] . '">' . $row["drug_id"] . ' - ' . $row["drug_name"] . '</option>';
          }
        }

        $conn->close();
      ?>
    </select>

    <label for="new_drug_name">New Drug Name:</label>
    <input type="text" name="new_drug_name" required>

    <label for="new_strength">New Strength:</label>
    <input type="text" name="new_strength" required>

    <button type="submit">Save Changes</button>
  </form>
</body>
</html>