<?php
// Connect to the database (replace with your own database connection code)
$db = new PDO('mysql:host=localhost;dbname=ePharmadb', 'root', '');

// Retrieve user input
$email = $_POST['email'];
$ID_no = $_POST['ID_no'];

// Prepare and execute the query to check patient information
$query = $db->prepare("SELECT * FROM patientinfo WHERE email = :email");
$query->bindParam(':email', $email);
$query->execute();

// Check if the user is registered as a patient
if ($query->rowCount() > 0) {
    // User is registered as a patient
    header('Location: patientprof.html');
    exit();
}

// Prepare and execute the query to check doctor information
$doctorQuery = $db->prepare("SELECT * FROM docinfo WHERE ID_no = :ID_no");
$doctorQuery->bindParam(':ID_no', $ID_no);
$doctorQuery->execute();

// Check if the doctor is registered
if ($doctorQuery->rowCount() > 0) {
    // Doctor is registered
    header('Location: docprof.html');
    exit();
} else {
    // Neither patient nor doctor is registered
    header('Location: docinfo.html');
    exit();
}
?>
