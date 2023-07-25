<?php
function getDrugOptions() {
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

  return $options;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $action = $_POST["action"];

  if ($action === "add") {
    // Process drug addition
    $drug_name = $_POST["drug_name"];
    $strength = $_POST["strength"];

    // Add drug to the drugs table
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "ePharmadb";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO drugs (drug_name, strength) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $drug_name, $strength);
    $stmt->execute();

    $conn->close();

    // Redirect to the same page after adding the drug
    header("Location: index.html");
    exit();
  } elseif ($action === "edit") {
    // Process drug edit
    $drug_name = $_POST["drug_name"]; // Use drug_name as the identifier for editing

    // Retrieve the drug details from the database based on the drug name
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "ePharmadb";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM drugs WHERE drug_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $drug_name);
    $stmt->execute();
    $result = $stmt->get_result();
    $drug = $result->fetch_assoc();

    if ($drug) {
      $new_drug_name = $_POST["new_drug_name"];
      $new_strength = $_POST["new_strength"];

      // Update drug in the drugs table
      $sql = "UPDATE drugs SET drug_name = ?, strength = ? WHERE drug_name = ?";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("sss", $new_drug_name, $new_strength, $drug_name);
      $stmt->execute();

      $conn->close();

      // Redirect to the same page after editing the drug
      header("Location: index.html");
      exit();
    } else {
      echo "Drug not found for editing.";
    }
  }
}
?>
