<?php
// Start the session
session_start();

// Check if the user is logged in and their type
if (!isset($_SESSION["username"]) || !isset($_SESSION["role"]) || $_SESSION["role"] !== "doctor") {
    header("Location: login.php");
    exit();
}

// Include your database connection code here (assuming you have a file named connection.php)
include 'connection.php';

// Function to search for a patient by name
function searchPatient($conn, $patientName) {
    $sql = "SELECT * FROM users WHERE role='patient' AND username LIKE ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $patientName);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Function to prescribe a drug to a patient
function prescribeDrug($conn, $doctorId, $patientId, $drugName, $frequency) {
    $sql = "INSERT INTO prescriptions (doctor_id, patient_id, drug_name, frequency) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $doctorId, $patientId, $drugName, $frequency);
    $stmt->execute();
}

// Process the prescription form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["patient_id"]) && isset($_POST["drug_name"]) && isset($_POST["frequency"])) {
        $patientId = $_POST["patient_id"];
        $drugName = $_POST["drug_name"];
        $frequency = $_POST["frequency"];
        $doctorId = $_SESSION["usseid"]; // Assuming you have set $_SESSION["id"] during login

        // Call the function to prescribe the drug
        prescribeDrug($conn, $doctorId, $patientId, $drugName, $frequency);
    }
}
?>

<!-- Rest of your HTML code remains the same -->

<!DOCTYPE html>
<html>
<head>
    <title>Welcome</title>
    <style>
        /* Add some basic styling */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        h1 {
            margin-bottom: 20px;
        }

        .logout {
            position: absolute;
            top: 20px;
            right: 20px;
        }
    </style>
</head>
<body>
    <h1>Welcome, <?php echo $_SESSION["username"]; ?>!</h1>
    <a href="logout.php" class="logout">Logout</a>

    <h2>Search for a Patient</h2>
    <form action="" method="post">
        <label for="patient_name">Patient Name:</label>
        <input type="text" name="patient_name" id="patient_name" required>
        <button type="submit">Search</button>
    </form>

    <?php
    // Handle the patient search
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["patient_name"])) {
        $patientName = $_POST["patient_name"];
        $patients = searchPatient($conn, $patientName);

        if (count($patients) > 0) {
            echo "<h3>Search Results:</h3>";
            echo "<ul>";
            foreach ($patients as $patient) {
                echo "<li>{$patient['username']}</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>No patients found.</p>";
        }
    }
    ?>

    <h2>Prescribe Drug</h2>
    <form action="" method="post">
        <label for="patient_id">Patient ID:</label>
        <input type="text" name="patient_id" id="patient_id" required>
        <label for="drug_name">Drug Name:</label>
        <input type="text" name="drug_name" id="drug_name" required>
        <label for="frequency">Frequency:</label>
        <input type="text" name="frequency" id="frequency" required>
        <button type="submit">Prescribe</button>
    </form>
</body>
</html>