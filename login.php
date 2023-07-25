<?php
// Start the session
session_start();

// Database connection configuration
$host = "localhost";
$username = "root";
$password = "";
$database = "pharmacydb";

// Create a connection to the database
$conn = new mysqli($host, $username, $password, $database);

// Check for any connection error
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted and the "username" and "password" keys are set in $_POST
if (isset($_POST["username"]) && isset($_POST["password"])) {
    // Get the submitted username and password
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Prepare the SQL statement to fetch user details
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the user exists and the password matches
    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $user["password"])) {
            $_SESSION["username"] = $user["username"];
            $_SESSION["role"] = $user["role"];

            // Redirect the user to their respective page based on the user type
            switch ($user["role"]) {
                case "doctor":
                    header("Location: doctor.php");
                    exit();
                case "patient":
                    header("Location: patient.php");
                    exit();
                case "pharmacist":
                    header("Location: pharmacist.php");
                    exit();
                case "admin":
                    header("Location: admin_login.html");
                    exit();
            }
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "User not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Add your CSS styles here (if any) -->
</head>
<body>
    <!-- Display any errors here -->
    <?php if (isset($error)) : ?>
        <p><?php echo $error; ?></p>
    <?php endif; ?>

    <!-- Your login form -->
    <h2>Login</h2>
    <form action="login.php" method="post">
        <label for="username">Username:</label>
        <input type="text" name="username" required>

        <label for="password">Password:</label>
        <input type="password" name="password" required>

        <button type="submit">Login</button>
    </form>
</body>
</html>
With this modification, if there's an error during login (e.g., invalid password or user not found), it will display an error message on the login page itself rather than redirecting to index.html?error=1. The user can then see what went wrong and try again.