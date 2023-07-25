<?php
// Establishing connection to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ePharmadb";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['IDno'])) {
    $IDno = $_GET['IDno'];

    // Retrieve the record with the specified ID
    $sql = "SELECT * FROM patientinfo WHERE IDno = '$IDno'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Display the form with pre-filled data for editing
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Edit Patient Details</title>
        </head>
        <body>
            <h1>Edit Patient Details</h1>
            <form method="post" action="update.php">
                <input type="hidden" name="IDno" value="<?php echo $row['IDno']; ?>">
                <label>First Name:</label>
                <input type="text" name="first_name" value="<?php echo $row['first_name']; ?>"><br><br>
                <label>Last Name:</label>
                <input type="text" name="last_name" value="<?php echo $row['last_name']; ?>"><br><br>
                <label>ID Number:</label>
                <input type="text" name="IDno" value="<?php echo $row['IDno']; ?>"><br><br>
                <label>Gender:</label>
                <input type="text" name="sex" value="<?php echo $row['sex']; ?>"><br><br>
                <label>Email:</label>
                <input type="text" name="email" value="<?php echo $row['email']; ?>"><br><br>
                <label>Phone Number:</label>
                <input type="text" name="phoneNo" value="<?php echo $row['phoneNo']; ?>"><br><br>
                <input type="submit" value="Update">
            </form>
        </body>
        </html>
        <?php
    } else {
        echo "No record found with the specified ID.";
    }
} else {
    echo "Invalid request. Please provide a valid ID.";
}

$conn->close();
?>
