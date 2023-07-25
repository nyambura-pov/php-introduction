<?php
var_dump($_POST);

$name = $_POST['name'];
$specialty = $_POST['specialty'];
$ID_no = $_POST['ID_no'];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ePharmadb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

//code to display a table of the records in the database
/*
echo "<table>";
echo "<tr><th>first_name</th><th>last_name</th><th>IDno</th><th>email</th><th>phoneNo</th><th>sex</th></th>";

while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row['first_name'] . "</td>";
    echo "<td>" . $row['last_name'] . "</td>";
    echo "<td>" . $row['IDno'] . "</td>";
    echo "<td>" . $row['email'] . "</td>";
    echo "<td>" . $row['phoneNo'] . "</td>";
    echo "<td>" . $row['sex'] . "</td>";
    echo "</tr>";
}

echo "</table>";
*/

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    $sql = "INSERT INTO docinfo (name, specialty, ID_no)
            VALUES ('$name', '$specialty', '$ID_no')";

    if ($conn->query($sql)) {
        echo "New record is inserted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
}
?>