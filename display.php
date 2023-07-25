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

// Pagination variables
$limit = 10; // Number of records to display per page
$page = isset($_GET['page']) ? $_GET['page'] : 1; // Current page number
$start = ($page - 1) * $limit; // Starting index for records

// Retrieve total number of records
$sql_count = "SELECT COUNT(*) as total FROM patientinfo";
$result_count = $conn->query($sql_count);
$row_count = $result_count->fetch_assoc();
$total_records = $row_count['total'];

// Calculate total number of pages
$total_pages = ceil($total_records / $limit);

// Retrieve records for the current page
$sql = "SELECT * FROM patientinfo LIMIT $start, $limit";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Patient Details</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <h1>Patient Details</h1>
    
    <!-- Display table -->
    <style>
        <style>
  table {
    border-collapse: collapse;
  }

  th, td {
    border: 1px solid black;
    padding: 8px;
    text-align: left;
  }
</style>
    <table>
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>ID Number</th>
            <th>Gender</th>
            <th>Email</th>
            <th>Phone Number</th>
            <th>Action</th>
        </tr>
        </style>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['first_name'] . "</td>";
                echo "<td>" . $row['last_name']  . "</td>";
                echo "<td>" . $row['IDno']  . "</td>";
                echo "<td>" . $row['sex'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . $row['phoneNo'] . "</td>";
                echo "<td>";
                echo "<a href='edit.php?IDno=" . $row['IDno'] . "'>Edit</a> | ";
                echo "<a href='delete.php?IDno=" . $row['IDno'] . "' onclick='return confirm(\"Are you sure?\")'>Delete</a>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No records found</td></tr>";
        }
        ?>
    </table>

    <!-- Pagination -->
    <ul class="pagination">
        <?php
        for ($i = 1; $i <= $total_pages; $i++) {
            echo "<li><a href='?page=$i'>$i</a></li>";
        }
        ?>
    </ul>

</body>
</html>

