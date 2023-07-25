<?php
// Include the connection.php file to establish a database connection and have access to functions
include 'connection.php';

// Function to retrieve drugs from the database
function getDrugs($conn) {
    $sql = "SELECT * FROM drugs";
    $result = $conn->query($sql);
    if (!$result) {
        // Error handling for the query
        die("Error retrieving drugs: " . $conn->error);
    }
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Function to add a drug to the database
function addDrug($conn, $drugName, $strength) {
    $sql = "INSERT INTO drugs (name, strength) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $drugName, $strength);
    if ($stmt->execute()) {
        return true; // Drug added successfully
    } else {
        return false; // Failed to add drug
    }
}

// Function to update a drug in the database
function updateDrug($conn, $drugId, $drugName, $strength) {
    $sql = "UPDATE drugs SET name = ?, strength = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $drugName, $strength, $drugId);
    if ($stmt->execute()) {
        return true; // Drug updated successfully
    } else {
        return false; // Failed to update drug
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["dispense"])) {
        $prescriptionId = $_POST["dispense"];

        // Call the function to update the prescription status to "dispensed" in the database
        $dispenseSuccess = dispenseMedicine($conn, $prescriptionId);

        // Check if dispense was successful
        if ($dispenseSuccess) {
            echo "<p>Prescription dispensed successfully!</p>";
        } else {
            echo "Failed to dispense prescription.";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Pharmacist</title>
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

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        /* Style the tabbed interface */
        .tab {
            overflow: hidden;
            border: 1px solid #ccc;
            background-color: #f1f1f1;
        }

        .tab button {
            background-color: inherit;
            float: left;
            border: none;
            outline: none;
            cursor: pointer;
            padding: 14px 16px;
            transition: 0.3s;
        }

        .tab button:hover {
            background-color: #ddd;
        }

        .tab button.active {
            background-color: #ccc;
        }

        .tabcontent {
            display: none;
            padding: 20px;
            border: 1px solid #ccc;
            border-top: none;
        }

        .tabcontent.active {
            display: block;
        }

        /* Form styling */
        .form-container {
            max-width: 500px;
            margin: 20px auto;
            border: 1px solid #ccc;
            padding: 20px;
        }

        .form-container input[type="text"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
        }

        .form-container button[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 8px 12px;
            border: none;
            cursor: pointer;
        }

        .form-container button[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Welcome, Pharmacist!</h1>
    <!-- Add a logout link if needed -->
    <!-- <a href="logout.php" class="logout">Logout</a> -->

    <!-- Create the tabbed interface -->
    <div class="tab">
        <button class="tablinks active" onclick="openTab(event, 'prescriptions')">Prescriptions</button>
        <button class="tablinks" onclick="openTab(event, 'drugs')">Drugs</button>
    </div>

    <!-- Tab content for prescriptions -->
<div id="prescriptions" class="tabcontent active">
    <h2>Prescriptions by Doctors</h2>
    <?php
    // Retrieve drugs prescribed by doctors
    $prescriptions = getPrescriptions($conn);

    if ($prescriptions && count($prescriptions) > 0) {
        ?>
        <table>
            <tr>
                <th>Doctor ID</th>
                <th>Patient ID</th>
                <th>Drug Name</th>
                <th>Frequency</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php
            foreach ($prescriptions as $prescription) {
                echo "<tr>";
                echo "<td>{$prescription['doctor_id']}</td>";
                echo "<td>{$prescription['patient_id']}</td>";
                echo "<td>{$prescription['drug_name']}</td>";
                echo "<td>{$prescription['frequency']}</td>";
                echo "<td>{$prescription['status']}</td>";
                echo "<td>";
                if ($prescription['status'] !== 'dispensed') {
                    echo "<form method='post'>";
                    echo "<input type='hidden' name='dispense' value='{$prescription['id']}'>";
                    echo "<button type='submit'>Dispense</button>";
                    echo "</form>";
                } else {
                    echo "Dispensed";
                }
                echo "</td>";
                echo "</tr>";
            }
            ?>
        </table>
        <?php
    } else {
        echo "<p>No prescriptions found.</p>";
    }
    ?>
</div>

    <!-- ... (previous code) ... -->

<!-- Tab content for drugs -->
<div id="drugs" class="tabcontent">
    <h2>Add or Edit Drugs</h2>
    <!-- Form to add or edit drugs -->
    <div class="form-container">
        <form method="post">
            <input type="hidden" name="action" id="action" value="add">
            <input type="hidden" name="drug_id" id="drug_id" value="">
            <label for="drug_name">Drug Name:</label>
            <input type="text" name="drug_name" id="drug_name" required>
            <label for="strength">Strength:</label>
            <input type="text" name="strength" id="strength" required>
            <button type="submit" id="submit_btn">Add Drug</button>
        </form>
    </div>

    <h2>Available Drugs</h2>
    <?php
    // Retrieve drugs from the database
    $drugs = getDrugs($conn);

    if ($drugs && count($drugs) > 0) {
        ?>
        <table>
            <tr>
                <th>Drug ID</th>
                <th>Drug Name</th>
                <th>Strength</th>
                <th>Action</th>
            </tr>
            <?php
            foreach ($drugs as $drug) {
                echo "<tr>";
                echo "<td>{$drug['id']}</td>";
                echo "<td>{$drug['name']}</td>";
                echo "<td>{$drug['strength']}</td>";
                echo "<td>";
                // Add an edit button for each drug
                echo "<button onclick=\"editDrug('{$drug['id']}', '{$drug['name']}', '{$drug['strength']}')\">Edit</button>";
                echo "</td>";
                echo "</tr>";
            }
            ?>
        </table>
        <?php
    } else {
        echo "<p>No drugs found.</p>";
    }
    ?>

    <!-- Back button to navigate back to prescriptions tab -->
    <button onclick="openTab(event, 'prescriptions')">Back</button>
</div>

<script>
// ... (previous code) ...

function openTab(evt, tabName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].classList.remove("active");
    }
    document.getElementById(tabName).style.display = "block";
    evt.currentTarget.classList.add("active");
}

function editDrug(drugId, drugName, strength) {
    document.getElementById("action").value = "edit";
    document.getElementById("drug_id").value = drugId;
    document.getElementById("drug_name").value = drugName;
    document.getElementById("strength").value = strength;
    document.getElementById("submit_btn").innerText = "Update Drug";
}
</script>

<!-- ... (previous code) ... -->

</body>
</html>

<?php
// Close the database connection
$conn->close();
?>