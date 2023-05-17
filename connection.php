<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "patientdb";
// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully";


$sql = "INSERT INTO patients (first_name, email, phone, last_name)
VALUES('Grace','grace@gmail.com','0711625678','Philly')";

$sql = "INSERT INTO drugs (drug_id, drug_name)
VALUES('1171','Celestamine')";

echo($sql);

if(mysqli_query($conn, $sql)){
  echo "New record created successfully";
} 
else {
  echo "Error: " .$sql . "<br>" . $conn->error;
}

$conn->close();

?>